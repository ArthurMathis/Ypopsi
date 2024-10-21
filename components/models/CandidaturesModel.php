<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');

define("COOPTATION", "Prime de cooptation");

class CandidaturesModel extends Model {
    /// Méthode publique retourant la liste des candidatures 
    public function getCandidatures() {
        // On initialise la requête
        $request = "SELECT 
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
        
        ORDER BY app.Id DESC";
    
        // On lance la requête
        return $this->get_request($request);
    }
    
    protected function searchCandidatByConcat($name) {
        // On initalise la requête
        $request = "SELECT * FROM Candidates
        WHERE CONCAT(Nom, ' ', Prenom) = :candidat";
        $params = ['candidat' => $name];

        // On lance la requête
        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method that checks if input data is honest before saving it to the database
     *
     * @param Array $candidate The array containing the candidate's data
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The array containing the candidate's helps
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param Int $coopteur The employee co-opting the new candidate
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
                $id = $this->searchHelps(COOPTATION)['Id'];
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

    /// Méthode publique générant un candidat et inscrivant les logs
    public function createCandidat(&$candidate, $diplomes=[], $aide=[], $coopteur) {
        $this->inscriptCandidat($candidat);
        $candidate->setKey($this->searchCandidate($candidat->getName(), $candidat->getFirstname(), $candidat->getEmail())['Id_Candidats']);

        if(!empty($diplomes)) 
            foreach($diplomes as $item) 
                $this->inscriptObtenir($candidat->getCle(), $this->searchDiplome($item)['Id_Diplomes']);
    
        if($aide != null) foreach($aide as $item) 
            $this->inscriptAvoir_droit_a($candidat->getCle(), $item, $item == 3 ? $coopteur['Id_Candidats'] : null);
            
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau candidat", 
            "Inscription du candidat " . strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname())
        );
    }
    /// Méthode publique générant une nouvelle aide
    public function createAide($aide) {
        // On initialise la requête
        $request = "INSERT INTO Aides_au_recrutement (Intitule_Aides_au_recrutement) VALUES (:intitule)";
        $params = ["intitule" => $aide];

        // On lance la requête
        $this->post_request($request, $params);
    }

    /// Méthode publique inscrivant une candidature et les logs
    public function inscriptCandidature(&$candidate, $application=[]) {
        try {
            if($candidate->getKey() == null) {
                $search = $this->searchCandidate($candidate->getName(), $candidate->getFirstname(), $candidate->getEmail())['Id_Candidats'];
                $candidate->setKey($search);           
            }

            // On ajoute l'action à la base de données
            $request = "INSERT INTO Applications (status, key_candidates, key_jobs, key_types_of_contracts, key_sources) 
                        VALUES (:status, :candidate, :job, :contract, :source)";
            $params = [
                "status" => 'Non-traitée', 
                "candidate" => $candidate->getKey(), 
                "job" => $this->searchPoste($application["job"])['Id'], 
                "contract" => $this->searchTypeContrat($application['type of contract'])['Id'], 
                "source" => $this->searchSource($application["source"])['Id']
            ];
        
            // On ajoute la base de données
            $this->post_request($request, $params);

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la candidature",
                'msg' => $e
            ]);
        }

        // On inscript la demande de service
        if(!empty($candidatures['service'])) {
            // On récupère la candidature
            $cle_candidatures = $this->searchCandidatureFromCandidat($candidat->getCle(), $instant)['Id_Candidatures'];

            // On récupère la clé service
            $service = $this->searchService($candidatures['service'])['Id_Services'];

            // On vérifie l'intégrité des données
            try {
                if(empty($service)) throw new Exception('Service introuvable');
                
            } catch(Exception $e) {
                forms_manip::error_alert([
                    'title' => "Erreur lors de l'inscription de la candidature",
                    'msg' => $e
                ]);
            }
            
            // On inscrit la demande
            $this->inscriptAppliquer_a($cle_candidatures, $service);
        }

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouvelle candidature", 
            "Nouvelle candidature de " . strtoupper($candidat->getNom()) . " " . forms_manip::nameFormat($candidat->getPrenom()) . " au poste de " . $candidatures["poste"]
        );
    }

    /// Méthode publique récupérant un candidat de la base de données depuis son nom et son prénom
    public function searchCandidate($name, $firstname, $email=null, $phone=null) {
        if($email != null) {
            // On récupère le candidats
            $request = "SELECT * FROM Candidates WHERE name = :name AND firstname = :firstname AND email = :email";
            $params = [
                ":name" => $name,
                ":firstname" => $firstname, 
                ":email" => $email
            ];
            $candidats = $this->get_request($request, $params, true);

        } elseif($phone != null) {
            // On récupère le candidats
            $request = "SELECT * FROM Candidates WHERE name = :nom AND firstname = :prenom AND phone = :phone";
            $params = [
                ":name" => $name,
                ":firstname" => $firstname, 
                ":phone" => $phone
            ];
            $candidats = $this->get_request($request, $params, true);

        } else 
            throw new Exception("Imposssible d'effectuer la requête sans email ou numéro de téléphone !");
        
        // On retourne le résultat
        return $candidats;
    }
}