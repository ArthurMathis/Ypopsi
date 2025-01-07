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
     * Public method that checks if input data is honest before saving it to the database
     *
     * @param Array $candidate The array containing the candidate's data
     * @param Array $qualifications The array containing the candidate's qualifications
     * @param Array $helps The array containing the candidate's helps
     * @param Date $medical_visit The expiration date of the new candidate's medical examination
     * @param String $coopteur A string containing a concatenation of the first and last name of the employee advising the new candidate
     * @return Void
     */
    public function verifyCandidate(array &$candidate, ?array $qualifications = null, ?array $helps = null, ?string $medical_visit = null, ?string $coopteur = null) { 
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
     * @param Int $coopteur The employee's primary key who advises the new candidate 
     * @return Void
     */
    public function createCandidate(Candidate &$candidate, ?array $qualifications = null, ?array $helps = null, ?int $coopteur = null) {
        $candidate->setKey($this->inscriptCandidates($candidate));
        if(!empty($qualifications)) 
            foreach($qualifications as $item) 
                $this->inscriptGetQualifications($candidate->getKey(), $item['qualification'], $item['date']);
        if(!empty($helps)) 
            foreach($helps as $item) 
                $this->inscriptHaveTheRightTo($candidate->getKey(), $item, $item == $this->searchHelps(COOPTATION)['Id'] ? $coopteur : null);   
    }

    /**
     * Public method registering one application and the logs
     *
     * @param Int $key_candidates
     * @param Int $key_sources
     * @param Int $key_jobs
     * @param Int|Null $key_types_of_contracts
     * @param Int|Null $key_services
     * @param Int|Null $key_establishemnts
     * @param Int|Null $key_needs
     * @throws Exception|PDOException If the request is not integred
     * @return Void
     */
    public function inscriptApplications(int $key_candidates, int $key_sources, int $key_jobs, ?int $key_types_of_contracts = null, ?int $key_services = null, ?int $key_establishemnts = null, ?int $key_needs = null) {
        $request = "INSERT INTO Applications (key_candidates, key_jobs, key_sources";
        $values_request = "VALUES (:candidate, :job, :source";
        $params = [ 
            "candidate" => $key_candidates,
            "job"       => $key_jobs,
            "source"    => $key_sources
        ];

        if($key_types_of_contracts) {
            $request .= ', key_types_of_contracts';
            $values_request .= ', :contract';
            $params['contract'] = $key_types_of_contracts;
        }
        if($key_needs) {
            $request .= ", key_needs";
            $values_request .= ", :needs";
            $params["needs"] = $key_needs; 
        }
        if($key_establishemnts) {
            $request .= ", key_establishments";
            $values_request .= ", :establishment";
            $params["establishment"] = $key_establishemnts;
        }
        if($key_services) {
            $request .= ", key_services";
            $values_request .= ", :service";
            $params["service"] = $key_services;
        }
        $request .= ")" . $values_request . ")";
        unset($values_request);

        $this->post_request($request, $params);
    }
}