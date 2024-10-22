<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');

define("COOPTATION", "Prime de cooptation");

/**
 * The model responsible for processing applications
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidaturesModel extends Model {
    /**
     * Public function returning the liste of applications
     *
     * @return Array The liste of applications
     */
    public function getCandidatures(): ?Array { 
        return $this->get_request(
            "SELECT 
            c.id AS Cle,
            app.Status AS Statut, 
            c.name AS Nom, 
            c.firstname AS Prenom, 
            j.titled AS Poste,
            c.email AS Email, 
            c.phone AS Telephone, 
            s.titled AS Source, 
            c.availability AS Disponibilite

            FROM Applications as app
            INNER JOIN Candidates as c on app.Key_Candidates = c.Id
            INNER JOin Jobs as j on app.Key_Jobs = j.Id
            INNER JOIN sources as s on app.Key_Sources = s.Id
            
            ORDER BY app.Id DESC"
        );
    }
    
    /**
     * Protected method searching one employee (candidate in contract) from a concatenation of his first and last name
     *
     * @param String $candidate_concat The concatenation
     * @return Array The employee's data
     */ 
    protected function searchCandidatByConcat($candidate_concat): Array {
        // $request = "SELECT * FROM Candidates WHERE CONCAT(name, ' ', firstname) = :candidate_concat"; $params = ['candidate_concat' => $candidate_concat];
        return $this->get_request(
            "SELECT * FROM Candidates WHERE CONCAT(name, ' ', firstname) = :candidate_concat", 
            ['candidate_concat' => $candidate_concat], 
            true, 
            true
        );
    }
    /**
     * Public method searching a candidate with his name, his firstnam and his email address or his phone number
     *
     * @param String $name The candidate's name
     * @param String $firstname The candidate's firstname
     * @param String $email The candidate's email
     * @param String $phone The candidate's phone number
     * @return The candidate
     */
    public function searchCandidate($name, $firstname, $email=null, $phone=null): ?Array {
        if($email != null) {
            $request = "SELECT * FROM Candidates WHERE name = :name AND firstname = :firstname AND email = :email";
            $params = [
                ":name" => $name,
                ":firstname" => $firstname, 
                ":email" => $email
            ];
            $candidate = $this->get_request($request, $params, true);

        } elseif($phone != null) {
            $request = "SELECT * FROM Candidates WHERE name = :name AND firstname = :firstname AND phone = :phone";
            $params = [
                ":name" => $name,
                ":firstname" => $firstname, 
                ":phone" => $phone
            ];
            $candidate = $this->get_request($request, $params, true);

        } else 
            throw new Exception("Imposssible d'effectuer la requête sans email ou numéro de téléphone !");
        
        return $candidate;
    }

    /**
     * Public method that checks if input data is honest before saving it to the database
     *
     * @param Array $candidate The array containing the candidate's data
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The array containing the candidate's helps
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param String $coopteur A string containing a concatenation of the first and last name of the employee advising the new candidate
     * @return Void
     */
    public function verify_candidat(&$candidate=[], $qualifications=[], $helps=[], $medical_visit, $coopteur) { 
        try {
            $candidate = new Candidate(
                $candidate['name'], 
                $candidate['firstname'], 
                $candidate['email'], 
                $candidate['phone'], 
                $candidate['address'],
                $candidate['city'],
                $candidate['post code']
            );
            
            if(!empty($helps)) {
                $coopt = 0;
                $id = $this->searchHelps(COOPTATION)['id'];
                foreach($helps as $item) 
                    if($item === $id)
                        $coopt++;
                if(1 < $coopt) 
                    throw new Exception("Il n'est possible de renseigner q'une prime de cooptation");
            }
        
        } catch(InvalideCandidateExceptions $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        
        if(!empty($medical_visit))
            $candidate->setMedicalVisit($medical_visit);
    
        if($coopteur)
            $coopteur = $this->searchCandidatByConcat($coopteur);

        $_SESSION['candidate']      = $candidate;
        $_SESSION['qualifications'] = $qualifications;
        $_SESSION['helps']          = $helps;
        $_SESSION['coopteur']       = $coopteur;
    }

    /**
     * Public method generating and saving a in th database a new candidate
     *
     * @param Candidate $candidate The object containing the candidate's informations
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The array containing the candidate's helps
     * @param String $coopteur The employee's name who advises the new candidate 
     * @return Void
     */
    public function createCandidate(&$candidate, $qualifications=[], $helps=[], $coopteur=null) {
        $this->inscriptCandidat($candidate);

        if(!empty($qualifications)) 
            foreach($qualifications as $item) 
                $this->inscriptGetQualifications($candidate->getKey(), $this->searchQualifications($item)['id']);

        if(!empty($helps)) 
            foreach($helps as $item) 
                $this->inscriptHaveTheRightTo($candidate->getKey(), $this->searchHelps($item)['id']);

        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau candidat", 
            "Inscription du candidat " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname())
        );
    }

    /// Méthode publique inscrivant une candidature et les logs
    public function inscriptCandidature(&$candidate, $application=[]) {
        try {
            if($candidate->getKey() == null) 
                $candidate->setKey($this->searchCandidate($candidate->getName(), $candidate->getFirstname(), $candidate->getEmail())['Id_Candidats']);           

            $request = "INSERT INTO Applications (status, key_candidates, key_jobs, key_types_of_contracts, key_sources";
            $values_request = "VALUES (:status, :candidate, :job, :contract, :source";
            $params = [
                "status" => 'Non-traitée', 
                "candidate" => $candidate->getKey(), 
                "job" => $this->searchPoste($application["job"])['id'], 
                "contract" => $this->searchTypesOfContracts($application['type of contract'])['id'], 
                "source" => $this->searchSource($application["source"])['id']
            ];
            if(isset($application['needs'])) {
                $request .= ", key_needs";
                $values_request .= ", :needs";
                $params["needs"] = $application['needs'];
            }
            if(isset($application['establishment'])) {
                $request .= ", key_establishment";
                $values_request .= ", :establishment";
                $params["establishment"] = $application['establishment'];
            }
            if(isset($application['service'])) {
                $request .= ", key_service";
                $values_request .= ", :service";
                $params["service"] = $application['service'];
            }
            $request .= ") " . $values_request;
            unset($values_request);
        
            $this->post_request($request, $params);

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la candidature",
                'msg' => $e
            ]);
        }

        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouvelle candidature", 
            "Nouvelle candidature de " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname()) . " au poste de " . $application["job"]
        );
    }
}