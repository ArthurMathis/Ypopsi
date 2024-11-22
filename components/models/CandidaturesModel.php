<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');

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
            CASE 
                WHEN app.IsAccepted = 1 THEN 'Acceptée'
                WHEN app.IsRefused = 1 THEN 'Refusée'
                ELSE 'Non-traitée' 
            END AS Statut,
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
     * Public method that checks if input data is honest before saving it to the database
     *
     * @param Array $candidate The array containing the candidate's data
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The array containing the candidate's helps
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param String $coopteur A string containing a concatenation of the first and last name of the employee advising the new candidate
     * @return Void
     */
    public function verifyCandidate(&$candidate=[], $qualifications=[], $helps=[], $medical_visit, $coopteur) { 
        try {
            $candidate = new Candidate(
                $candidate['name'], 
                $candidate['firstname'], 
                $candidate['gender'],
                $candidate['email'], 
                $candidate['phone'], 
                $candidate['address'],
                $candidate['city'],
                $candidate['post code']
            );
            
            if(!empty($helps)) {
                $coopt = 0;
                $id = $this->searchHelps(COOPTATION)['Id'];
                foreach($helps as $item) 
                    if($item === $id)
                        $coopt++;
                if(1 < $coopt) 
                    throw new Exception("Il n'est possible de renseigner qu'une seule prime de cooptation");
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
        echo 'On génère le nouveau candidat<br>';

        $candidate->setKey($this->inscriptCandidates($candidate));

        echo 'La clé du nouveau candidat : ' . $candidate->getKey() . '<br>'; 
        echo 'Liste des qualifications du candidat : <br>';

        if(!empty($qualifications)) 
            foreach($qualifications as $item) 
                $this->inscriptGetQualifications($candidate->getKey(), $this->searchQualifications($item['qualification'])['Id'], $item['date']);

        if(!empty($helps)) 
            foreach($helps as $item) 
                $this->inscriptHaveTheRightTo($candidate->getKey(), $this->searchHelps($item)['id']);

        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau candidat", 
            "Inscription du candidat " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname())
        );
    }

    /**
     * Public method registering one application and the logs
     * 
     * TODO : Recherche d'un besoin ==> $this->searchNeed($application['needs'])['Id];
     * 
     * @param Candidate $candidate The object containing the candidate's data
     * @param Array $application The array containing the application's data
     * @return Void
     */
    public function inscriptApplication(&$candidate, $application=[]) {
        try {
            $request = "INSERT INTO Applications (key_candidates, key_jobs, key_sources";
            $values_request = "VALUES (:candidate, :job, :source";
            $params = [ 
                "candidate" => $candidate->getKey(), 
                "job" => $this->searchJobs($application["job"])['Id'], 
                "source" => $this->searchSources($application["source"])['Id']
            ];

            if(isset($application['type of contract'])) {
                $request .= ', key_types_of_contracts';
                $values_request .= ', :contract';
                $params['contract'] = $this->searchTypesOfContracts($application['type of contract'])['Id'];
            }
            if(isset($application['needs'])) {
                $request .= ", key_needs";
                $values_request .= ", :needs";
                $params["needs"] = $application['needs']; // TODO : Recherche du besoin à réaliser !! // 
            }
            if(isset($application['establishment'])) {
                $request .= ", key_establishments";
                $values_request .= ", :establishment";
                $params["establishment"] = $this->searchEstablishments($application['establishment'])['Id'];
            }
            if(isset($application['service'])) {
                $request .= ", key_services";
                $values_request .= ", :service";
                $params["service"] = $this->searchServices($application['service'])['Id'];
            }
            $request .= ")" . $values_request . ")";
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