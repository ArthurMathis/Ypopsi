<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Contract.php');



class CandidatsModel extends Model {
    /**
     * Public method returning the liste of candidates 
     *
     * @return Void
     */
    public function getContent() {
        $request = "SELECT 
            Id AS Cle,
            Name AS Nom, 
            Firstname AS Prenom, 
            Email AS Email, 
            City AS Ville, 
            Rating AS Notation

            FROM Candidates";
    
        $temp = $this->get_request($request);

        if(!empty($temp)) 
            foreach ($temp as &$obj) 
                if ($obj['Notation'] == null) 
                    $obj['Notation'] = "Aucune notation";  
        unset($obj);

        return $temp;
    }
    /// Méthode publique récupérant les données d'un candidat pour sa mise-à-jour
    public function getEditCandidatContent($key_candidate) {
        if(!is_numeric($key_candidate))
            throw new Exception("L'index n'est pas valide. Veullez saisir un entier !");

        $candidats = $this->getCandidate($key_candidate);
        array_push($candidats, ['diplomes' => $this->getCandidatesFromQualifications($key_candidate)]);
        array_push($candidats, ['aides' => $this->getHelpsFromCandidates($key_candidate)]);

        return [
            'candidat' => $candidats,
            'coopteur' => $this->searchCoopter($key_candidate),
            'aide' => $this->getHelps(),
            'diplome' => $this->getQualifications()
        ];
    }
    /**
     * Public method search and returning the meeting's data
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Array
     */
    public function getEditMeetingContent($key_meeting): Array {
        $request = "SELECT
        m.Id AS key_meeting,
        c.Id AS key_candidate,
        u.Identifier AS Recruteur,
        e.Titled AS Etablissement,
        DATE_FORMAT(m.Date, '%Y-%m-%d') AS Date, 
        DATE_FORMAT(m.Date, '%H:%i') AS Horaire,
        m.Description AS description
        
        FROM Meetings AS m
        INNER JOIN Users AS u ON m.Key_Users = u.Id
        INNER JOIN Candidates AS c ON m.Key_Candidates = c.Id
        INNER JOIN Establishments AS e ON m.Key_Establishments = e.Id
        
        WHERE m.Id = :key_meeting";
        $params = ['key_meeting' => $key_meeting];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching and returning the candidate's profil data 
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array
     */
    public function getContentCandidate($key_candidate): Array {
        // $candidate = $this->getCandidate($key_candidate);
        $candidate = $this->searchcandidate($key_candidate);
        $candidate['qualifications'] = $this->getCandidatesFromQualifications($key_candidate);

        $employee = $this->searchCoopter($key_candidate);
        if(!empty($employee)) 
            $employee = $employee['text']; 

        return [
            'candidate' => $candidate,
            'helps' => $this->getHelpsFromCandidates($key_candidate),
            'employee' => $employee, 
            'applications' => $this->getApplicationsFromCandidates($key_candidate),
            'contracts' => $this->getContractsFromCandidates($key_candidate),
            'meeting' => $this->getMeetingFromCandidates($key_candidate)
        ];
    }
    /**
     * Public method searching and returning one candidate from his primary key
     * 
     * ! Utiliser la méthode Model::searchCandidate
     *
     * @param Int $key_candidate The candidte's primary key
     * @return Array|NULL
     */
    // public function getCandidate($key_candidate): ?Array {
    //     if(empty($key_candidate) || !is_numeric($key_candidate))
    //         throw new Exception("Erreur lors de la récupération du candidat.");
    // 
    //     $request = "SELECT id, name, firstname, phone, email,  address, city, postcode, availability, rating, description,  a,  b,  c
    //     FROM candidates WHERE Id = :key";
    // 
    //     $params = ["key" => $key_candidate];
    // 
    //     return $this->get_request($request, $params)[0];
    // }
    /**
     * Private method that searches and returns a candidate's qualifications based on its primary key
     *
     * @param Int $key_qualifications The candidate's primary key
     * @return Array|NULL
     */
    private function getCandidatesFromQualifications($key_qualifications): ?Array {
        $request = "SELECT 
        Titled AS Intitule

        FROM candidates AS c
        INNER JOIN Get_qualifications AS g ON c.Id = g.Key_Candidates
        INNER JOIN Qualifications AS q on g.Key_Qualifications = q.Id
        
        WHERE c.Id = :key";
        $params = ['key' => $key_qualifications];

        return $this->get_request($request, $params);
    }
    /**
     * Private method searching and returning the liste of candidate's applications
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array
     */
    private function getApplicationsFromCandidates($key_candidate): Array {
        $request = "SELECT 
        app.Id AS cle,
        app.Status AS statut, 
        s.titled AS source, 
        t.titled AS type_de_contrat,
        app.moment AS date,
        j.titled AS poste,
        serv.titled AS service,
        e.titled AS etablissement
        
        FROM Applications AS app
        INNER JOIN Sources AS s ON app.key_sources = s.Id
        INNER JOIN Jobs AS j ON app.key_jobs = j.Id
        INNER JOIN Types_of_contracts AS t ON app.Key_Types_of_contracts = t.Id
        LEFT JOIN Services as serv ON app.Key_Services = serv.Id
        LEFT JOIN Establishments AS e ON app.Key_Establishments = e.id

        WHERE app.Key_Candidates = :cle

        ORDER BY cle DESC";
        $params = ['cle' => $key_candidate];

        $temp = $this->get_request($request, $params);
        if(!empty($temp))
            foreach($temp as $item)
                $item["date"] = (new DateTime($item["date"]))->format('d/m/Y');

        return $temp;
    }
    /**
     * Private method searching and returning the liste of candidate's contrtacts
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */ 
    private function getContractsFromCandidates($key_candidate): ?Array {
        $request = "SELECT 
        c.Id AS cle,
        j.titled AS poste,
        s.titled AS service,
        e.titled AS etablissement,
        c.Salary AS salaire,
        c.HourlyRate AS heures,
        c.NightWork AS nuit,
        c.WeekEndWork AS week_end,
        c.StartDate AS date_debut,
        c.EndDate AS date_fin,
        c.ResignationDate AS demission,
        t.titled AS type_de_contrat,
        c.PropositionDate AS proposition,
        c.SignatureDate AS signature 

        FROM Contracts as c
        INNER JOIN Jobs AS j ON c.Key_Jobs = j.Id
        INNER JOIN Services AS s ON c.Key_services = s.Id
        INNER JOIN Establishments AS e ON c.Key_Establishments = e.Id
        INNER JOIN Types_of_contracts AS t ON c.Key_Types_of_contracts = t.Id

        WHERE c.Key_Candidates = :key";
        $params = ['key' => $key_candidate];

        return $this->get_request($request, $params);
    }
    /**
     * Private method searching and returning the list of appointments of a candidate
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    private function getMeetingFromCandidates($key_candidate): ?Array {
        $request = "SELECT 
        meet.Id AS key_meeting,
        u.Name AS nom,
        u.Firstname AS prenom,
        DATE(meet.Date) AS date,
        DATE_FORMAT(meet.Date, '%H:%i') AS heure,
        e.Titled AS etablissement,
        meet.Description AS description

        FROM  Meetings AS meet
        INNER JOIN Users AS u ON meet.Key_Users = u.Id
        INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id
        INNER JOIN Establishments AS e ON e.Id = meet.Key_Establishments

        WHERE meet.Key_Candidates = :key";
        $params = ['key' => $key_candidate];
    
        return $this->get_request($request, $params);
    }

    /**
     * Private method searching and returning the candidte's helps
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    private function getHelpsFromCandidates($key_candidate): ?Array {
        $request = "SELECT 
        Titled AS intitule 

        FROM Helps
        INNER JOIN Have_the_right_to AS have ON helps.Id = have.Key_Helps
        WHERE have.Key_Candidates = " . $key_candidate;

        $result = $this->get_request($request);
    
        return empty($this->get_request($request)) ? null : $result[0];
    }
    /**
     * Private method searching and returning the employee who advices the candidate
     *
     * @param int $key_candidate The candidte's primary key
     * @return Array|NULL The array containing the employee's data
     */
    private function searchCoopter($key_candidate): ?Array {
        $request = "SELECT 
        CONCAT(c.Name, ' ', c.Firstname) AS text

        FROM Have_the_right_to AS have
        INNER JOIN Candidates AS c ON have.Key_Employee = c.Id
        
        WHERE have.Key_Candidates = :key_candidate AND have.Key_Helps = :key_help";
        $params = [
            'key_candidate' => $key_candidate,
            'key_help' => $this->searchHelps(COOPTATION)['Id']
        ];

        return $this->get_request($request, $params, true, false);
    }
    public function getTypeContrat($cle_candidature) {
        $candidature = $this->searchCandidature($cle_candidature);
        return $this->searchTypeContrat($candidature['Cle_Types_de_contrats'])['Intitule_Types_de_contrats'];
    }
    
    /**
     * Public method building an candidate from his primary key
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Candidate
     */
    public function makeCandidate($key_candidate): Candidate {
        $result = $this->searchCandidate($key_candidate);
        $candidate = new Candidate(
            $result['Name'], 
            $result['Firstname'], 
            $result['Gender'],
            $result['Email'], 
            $result['Phone'],
            $result['Address'], 
            $result['City'], 
            $result['PostCode']
        );
        $candidate->setKey($result['Id']);
        return $candidate;
    }

    /**
     * Public method updating the application's status
     *
     * @param String $status The new application's status
     * @param Int $key_application The application's primary key
     * @throws Exception If the status is invalid
     * @return Void
     */
    public function setApplicationStatus($status, $key_application) {
        if(empty($status) || !is_string($status))
            throw new Exception('Statut invalide !');

        $request = "UPDATE Applications SET Status = :status WHERE Id = :key_application";
        $params = [
            'status' => $status,
            'key_application' => $key_application
        ];

        $this->post_request($request, $params);
    }
    /// Méthode publique implémentant le statut d'une proposition
    public function setPropositionStatut($cle) {
        // On initialise la requête
        $request = "UPDATE Contrats SET Statut_Proposition = :statut WHERE Id_Contrats = :cle";
        $params = [
            'statut' => 1,
            'cle' => $cle
        ];
        
        // On exécute la requête
        $this->post_request($request, $params);
    }

    /**
     * Public method dismissing an application and registering the logs
     *
     * @param Int $key_application The application's primary key
     * @return Void
     */
    public function dismissApplications(&$key_application) {
        $this->setApplicationStatus('Refusée', $key_application);
        $candidat = $this->searchCandidateFromApplication($key_application);
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Refus candidature", 
            "Refus de la candidature de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname']) . 
            " au poste de " . forms_manip::nameFormat($this->searchJob($this->searchApplication($key_application)['Key_Jobs'])['Titled'])
        );
    }
    /// Méthode publique refusant une proposition et inscrivant les logs
    public function rejectProposition(&$cle_proposition) {
        // On implémente le statut de la proposition
        $this->setPropositionStatut($cle_proposition);       

        // On récupère les informations de la proposition
        $candidat = $this->searchcandidatFromContrat($cle_proposition);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Refus proposition", 
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " refuse la proposition d'embauche au poste de " . 
            forms_manip::nameFormat($this->searchPoste($this->searchCandidature($cle_proposition)['Cle_Postes'])['Intitule_Postes'])
        );
    }

    /// Méthode construisant une nouvelle proposition d'embauche et l'inscrivant dans la base de données
    public function createPropositions($cle, $propositions) {
        try {
            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            // On ajoute la clé candidat
            $propositions['cle candidat'] = $cle;
            // On ajoute la clé instant
            $propositions['cle instant'] = $instant;
            // On ajoute la clé poste
            $propositions['cle poste'] = is_numeric($propositions['poste']) ? $propositions['poste'] : $this->searchPoste($propositions['poste'])['Id_Postes'];    
            // On ajoute la clé service
            $propositions['cle service'] = is_numeric($propositions['service']) ? $propositions['service'] : $this->searchService($propositions['service'])['Id_Services'];
            // On ajoute la clé de type de contrat
            $propositions['cle type'] = isset($propositions['type']) && is_numeric($propositions['type']) ? $propositions['type'] : $this->searchTypeContrat($propositions['type_de_contrat'])['Id_Types_de_contrats'];

            // On génère le contrat
            $contrat = Contrat::makeContrat($propositions);
        
        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription de la proposition",
                'msg' => $e
            ]);
        }

        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());
        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());

        // On enregistre le contrat 
        $this->inscriptContrats($contrat->exportToSQL());
        unset($contrat);

        // On enregistre les logs
        $candidat = $this->searchcandidat($cle);
        $this-> writeLogs(
            $_SESSION['user_key'],
            "Nouvelle proposition",
            "Nouvelle proposition de contrat pour " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " au poste de " . forms_manip::nameFormat($this->searchPoste($propositions['cle poste'])['Intitule_Postes'])
        );
    }
    /// Méthode construisant une nouvelle proposition d'embauche depuis une candidature et l'inscrivant dans la base de données
    public function createPropositionsFromCandidature($cle_candidature, &$propositions=[], &$cle_candidat) {
        // On récupère la candidature
        $candidature = $this->searchCandidature($cle_candidature);

        // On implémente le tableau de données de la proposition
        $propositions['poste'] = $candidature['Cle_Postes'];
        $propositions['service'] = $this->searchAppliquer_aFromCandidature($candidature['Id_Candidatures'])['Cle_Services'];
        $propositions['type_de_contrat'] = $candidature['Cle_Types_de_contrats'];

        // On récupère la clé candidat
        $cle_candidat = $this->searchCandidateFromApplication($cle_candidature)['Cle_Candidats'];
    }
    /// Méthode construisant une nouvelle proposition d'embauche depuis une cnadidature sans service et l'inscrivant dans la base de données
    public function createPropositionsFromEmptyCandidature($cle_candidature, &$propositions=[], &$cle_candidat) {
        // On récupère la candidature
        $candidature = $this->searchCandidature($cle_candidature);

        // On implémente le tableau de données de la proposition
        $propositions['poste'] = $candidature['Cle_Postes'];
        $propositions['type_de_contrat'] = $candidature['Cle_Types_de_contrats'];

        // On récupère la clé candidat
        $cle_candidat = $this->searchCandidateFromApplication($cle_candidature)['Cle_Candidats'];
    }
    /// Méthode construisant nouveau contrat et l'inscrivant dans la base de données
    public function createContrats($cle_candidats, &$contrat=[]) {
        try {
            // On génère l'instant actuel
            $instant = $this->inscriptInstants()['Id_Instants'];

            // On ajoute la date de signature
            $contrat['signature'] = Moment::currentInstants()->getdate();

            // On récupère les informations relatives au poste
            $poste = $this->searchPoste($contrat['poste']);

            // On ajoute la clé candidat
            $contrat['cle candidat'] = $cle_candidats;
            unset($cle_candidat);
            // On ajoute la clé instant
            $contrat['cle instant'] = $instant;
            unset($instant);
            // On ajoute la clé poste
            $contrat['cle poste'] = $poste['Id_Postes'];
            // On ajoute la clé service
            $contrat['cle service'] = is_numeric($contrat['service']) ? $contrat['service'] : $this->searchService($contrat['service'])['Id_Services'];
            // On ajoute la clé de type de contrat
            $contrat['cle type'] = isset($contrat['type']) && is_numeric($contrat['type']) ? $contrat['type'] : $this->searchTypeContrat($contrat['type_de_contrat'])['Id_Types_de_contrats'];

            // On génère le contrat
            $contrat = Contract::makeContrat($contrat);
        
        } catch(Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'inscription du contrat",
                'msg' => $e
            ]);
        }

        // On inscrit la proposition
        $this->inscriptProposer_a($contrat->getCleCandidats(), $contrat->getCleInstants());
        $this->verifyMission($contrat->getCleServices(), $contrat->getClePostes());

        // On enregistre le contrat 
        $this->inscriptContrats($contrat->exportToSQL());

        // On enregistre les logs
        $candidat = $this->searchcandidat($contrat->getCleCandidats());
        unset($contrat);
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau contrat", 
            "Nouveau contrat de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " au poste de " . $poste['Intitule_Postes']
        );
    }
    /**
     * Public method generating a new meeting
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $meeting The array containing the meeting's data
     * @return Void
     */
    public function createMeeting($key_candidate, &$meeting=[]) {
        $this->inscriptMeetings(
            $this->searchUser($meeting['recruteur'])['Id'], 
            $key_candidate, 
            $this->searchEstablishment($meeting['etablissement'])['Id'], 
            (new DateTime($meeting['date'] . ' ' . $meeting['time'], new DateTimeZone('Europe/Paris')))->getTimestamp()
        );

        $candidate = $this->searchCandidate($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau rendez-vous", 
            "Nouveau rendez-vous avec " . strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . ", le " . $meeting['date']
        );
    }

    /// Méthode protégées inscrivant un contrat dans la base de données
    // TODO : Remanier avec manipulation des strings (request divisé en insert + value) //
    protected function inscriptContrats($contrats=[]) {
        // Requête avec date de fin de contrat
        if(isset($contrats['date fin'])) {
            // Requête avec salaire
            if(isset($contrats['salaire'])) {
                // Requête avec travail de nuit
                if(isset($contrats['travail nuit'])) {
                    // Requête avec travail de week-end
                    if(isset($contrats['travail wk'])) {
                        // Requête avec taux horaire hebdomadaire
                        if(isset($contrats['nb heures'])) {
                            // On initialise la requête
                            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                            VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                            // On prépare les paramètres
                            $params = [
                                "date_debut" => $contrats['date debut'],
                                "date_fin" => $contrats['date fin'],
                                "salaire" => $contrats['salaire'],
                                "travail_nuit" => $contrats['travail nuit'],
                                "travail_wk" => $contrats['travail wk'],
                                "nb_heures" => $contrats['nb heures'],
                                "signature" => $contrats['signature'],
                                "cle_candidat" => $contrats['cle candidat'],
                                "cle_instant" => $contrats['cle instant'],
                                "cle_service" => $contrats['cle service'],
                                "cle_poste" => $contrats['cle poste'],
                                "cle_types" => $contrats['cle types']
                            ];

                        // Requête sans taux horaire hebdomadaire    
                        } else {
                            // On initialise la requête
                            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                            VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                            // On prépare les paramètres
                            $params = [
                                "date_debut" => $contrats['date debut'],
                                "date_fin" => $contrats['date fin'],
                                "salaire" => $contrats['salaire'],
                                "travail_nuit" => $contrats['travail nuit'],
                                "travail_wk" => $contrats['travail wk'],
                                "signature" => $contrats['signature'],
                                "cle_candidat" => $contrats['cle candidat'],
                                "cle_instant" => $contrats['cle instant'],
                                "cle_service" => $contrats['cle service'],
                                "cle_poste" => $contrats['cle poste'],
                                "cle_types" => $contrats['cle types']
                            ];
                        }

                    // Requête sans travail de week-end avec taux horaire hebdomadaire
                    } elseif(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de nuit avec travail de week-end
                } elseif(isset($contrats['travail wk'])) {
                    // Requête avec taux horaire hebdomadaire
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :salaire, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "salaire" => $contrats['salaire'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de week-end avec taux horaire hebdomadaire    
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :salaire, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "salaire" => $contrats['salaire'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire    
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Salaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :salaire, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "salaire" => $contrats['salaire'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans salaire avec travail de nuit
            } elseif(isset($contrats['travail nuit'])) {
                // Requête avec travail de week-end
                if(isset($contrats['travail wk'])) {
                    // Requête avec taux horaire hebdomadaire
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire    
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :date_fin, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "date_fin" => $contrats['date fin'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de week-end avec taux horaire hebdomadaire 
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
        
                // Requête sans taux horaire hebdomadaire     
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec travail de week-end
            } elseif(isset($contrats['travail wk'])) {
                // Requête avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :date_fin, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "date_fin" => $contrats['date fin'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :date_fin, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "date_fin" => $contrats['date fin'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire    
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_fin_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :date_fin, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "date_fin" => $contrats['date fin'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans date de fin avec salaire 
        } elseif(isset($contrats['salaire'])) {
            // Requête avec travail de nuit
            if(isset($contrats['travail nuit'])) {
                // Requête avec travail de week-end
                if(isset($contrats['travail wk'])) {
                    // Requête sans travail de week-end avec taux horaire hebdomadaire 
                    if(isset($contrats['nb heures'])) {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :salaire, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "nb_heures" => $contrats['nb heures'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];

                    // Requête sans taux horaire hebdomadaire
                    } else {
                        // On initialise la requête
                        $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                        VALUES (:date_debut, :salaire, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                        // On prépare les paramètres
                        $params = [
                            "date_debut" => $contrats['date debut'],
                            "salaire" => $contrats['salaire'],
                            "travail_nuit" => $contrats['travail nuit'],
                            "travail_wk" => $contrats['travail wk'],
                            "signature" => $contrats['signature'],
                            "cle_candidat" => $contrats['cle candidat'],
                            "cle_instant" => $contrats['cle instant'],
                            "cle_service" => $contrats['cle service'],
                            "cle_poste" => $contrats['cle poste'],
                            "cle_types" => $contrats['cle types']
                        ];
                    }

                // Requête sans travail de nuit avec taux horaire hebdomadaire  
                } elseif(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                    
                // Requête sans taux horaire hebdomadaire     
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de nuit avec travail de week-end 
            } elseif(isset($contrats['travail wk'])) {
                // Requête sans travail de week-end avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :salaire, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)   
                    VALUES (:date_debut, :salaire, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "salaire" => $contrats['salaire'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de week-end avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :salaire, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "salaire" => $contrats['salaire'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Salaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :salaire, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "salaire" => $contrats['salaire'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans salaire avec travail de nuit    
        } else if(isset($contrats['travail nuit'])) {
            // Requête avec travail de week-end 
            if(isset($contrats['travail wk'])) {
                // Requêtes avec taux horaire hebdomadaire
                if(isset($contrats['nb heures'])) {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :travail_nuit, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "travail_wk" => $contrats['travail wk'],
                        "nb_heures" => $contrats['nb heures'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];

                // Requête sans taux horaire hebdomadaire    
                } else {
                    // On initialise la requête
                    $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                    VALUES (:date_debut, :travail_nuit, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                    // On prépare les paramètres
                    $params = [
                        "date_debut" => $contrats['date debut'],
                        "travail_nuit" => $contrats['travail nuit'],
                        "travail_wk" => $contrats['travail wk'],
                        "signature" => $contrats['signature'],
                        "cle_candidat" => $contrats['cle candidat'],
                        "cle_instant" => $contrats['cle instant'],
                        "cle_service" => $contrats['cle service'],
                        "cle_poste" => $contrats['cle poste'],
                        "cle_types" => $contrats['cle types']
                    ];
                }

            // Requête sans travail de week-end avec taux horaire hebdomadaire
            } elseif(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_nuit, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_nuit" => $contrats['travail nuit'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_de_nuit_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_nuit, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_nuit" => $contrats['travail nuit'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans travail de nuit avec travail de week-end    
        } elseif(isset($contrats['travail wk'])) {
            // Requête avec taux horaire hebdomadaire
            if(isset($contrats['nb heures'])) {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_week_wend_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_wk, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_wk" => $contrats['travail wk'],
                    "nb_heures" => $contrats['nb heures'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];

            // Requête sans taux horaire hebdomadaire
            } else {
                // On initialise la requête
                $request = "INSERT INTO Contrats (Date_debut_Contrats, Travail_week_wend_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
                VALUES (:date_debut, :travail_wk, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
                // On prépare les paramètres
                $params = [
                    "date_debut" => $contrats['date debut'],
                    "travail_wk" => $contrats['travail wk'],
                    "signature" => $contrats['signature'],
                    "cle_candidat" => $contrats['cle candidat'],
                    "cle_instant" => $contrats['cle instant'],
                    "cle_service" => $contrats['cle service'],
                    "cle_poste" => $contrats['cle poste'],
                    "cle_types" => $contrats['cle types']
                ];
            }

        // Requête sans travail de week-end avec taux horaire hebdomadaire     
        } elseif(isset($contrats['nb heures'])) {
            // On initialise la requête
            $request = "INSERT INTO Contrats (Date_debut_Contrats, Nombre_heures_hebdomadaires_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
            VALUES (:date_debut, :nb_heures, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
            // On prépare les paramètres
            $params = [
                "date_debut" => $contrats['date debut'],
                "nb_heures" => $contrats['nb heures'],
                "signature" => $contrats['signature'],
                "cle_candidat" => $contrats['cle candidat'],
                "cle_instant" => $contrats['cle instant'],
                "cle_service" => $contrats['cle service'],
                "cle_poste" => $contrats['cle poste'],
                "cle_types" => $contrats['cle types']
            ];

        // Requête sans taux horaire hebdomadaire
        } else {
            // On initialise la requête
            $request = "INSERT INTO Contrats (Date_debut_Contrats, Date_signature_contrats, Cle_Candidats, Cle_Instants, Cle_Services, Cle_Postes, Cle_Types_de_contrats)
            VALUES (:date_debut, :signature, :cle_candidat, :cle_instant, :cle_service, :cle_poste, :cle_types)";
            // On prépare les paramètres
            $params = [
                "date_debut" => $contrats['date debut'],
                "signature" => $contrats['signature'],
                "cle_candidat" => $contrats['cle candidat'],
                "cle_instant" => $contrats['cle instant'],
                "cle_service" => $contrats['cle service'],
                "cle_poste" => $contrats['cle poste'],
                "cle_types" => $contrats['cle types']
            ];
        }

        $params['cle_instant'] = strval($params['cle_instant']);
        $params['cle_service'] = strval($params['cle_service']);
        $params['cle_poste'] = strval($params['cle_poste']);
        $params['cle_types'] = strval($params['cle_types']);

        // On lance la requête
        $this->post_request($request, $params);
    }
    /// Méthode publique ajoutant une signature à un contrat
    public function addSignature($cle) {
        // On génère l'instant actuel
        $instant = Moment::currentInstants()->getDate();

        // On initialise la requête
        $request = "UPDATE Contrats SET Date_signature_Contrats = :date WHERE Id_Contrats = :contrat";
        $params = [
            'date' => $instant,
            'contrat' => $cle
        ];

        // On lance la requête
        $this->post_request($request, $params);

        // On enregistre les logs
        $candidat = $this->searchcandidatFromContrat($cle);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau contrat",
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " a accepté la proposition d'offre pour le poste " . forms_manip::nameFormat($this->searchPoste($this->searchContrat($cle)['Cle_Postes'])['Intitule_Postes'])
        );
    }
    /// Méthode ajoutant une démission à un contrat 
    public function addDemission($cle) {
        // On génère l'instant actuel
        $instant = Instants::currentInstants()->getDate();

        // On initialise la requête
        $request = "UPDATE Contrats SET Date_demission_Contrats = :date WHERE Id_Contrats = :contrat";
        $params = [
            'date' => $instant,
            'contrat' => $cle
        ];

        // On lance la requête
        $this->post_request($request, $params);

        // On enregistre les logs
        $candidat = $this->searchcandidatFromContrat($cle);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Démission",
            strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats']) . " a démissioné de son travail de " . forms_manip::nameFormat($this->searchPoste($this->searchContrat($cle)['Cle_Postes'])['Intitule_Postes'])
        );
    }
    /**
     * Public function deleting a meeting and registering the linked logs
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Void
     */
    public function deletingMeeting($key_meeting) {
        $meeting = $this->searchMeeting($key_meeting);
        $candidate = $this->searchcandidate($meeting['Key_Users']); 
        $this->deleteMeeting($key_meeting);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Annulation rendez-vous",
            strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . " a annulé son rendez-vous du " . date('Y m d', strtotime($meeting['Date']))
        );
    }
    /// Méthode protégée vérifiant qu'une mission est dans la base de données
    protected function verifyMission($cle_service, $cle_poste) {
        // On initialise la requête 
        $request = "SELECT * FROM Missions WHERE Cle_Services = :service AND Cle_Postes = :poste";
        $params = [
            'service' => $cle_service,
            'poste' => $cle_poste
        ];

        // On lance la requête
        $mission = $this->get_request($request, $params);

        // On test la présence de la mission
        if(empty($mission)) {
            // On inscrit la mission
            $this->inscriptMission($cle_service, $cle_poste);
        }
    }

    public function makeUpdatecandidat($cle_candidat, $candidat) {
        try {
            $c = new Candidat($candidat['nom'], $candidat['prenom'], $candidat['email'], $candidat['telephone'], $candidat['adresse'], $candidat['ville'], $candidat['code-postal']);
            unset($candidat['nom']);
            unset($candidat['prenom']);
            unset($candidat['email']);
            unset($candidat['telephone']);
            unset($candidat['adresse']);
            unset($candidat['ville']);
            unset($candidat['code-postal']);

        } catch(InvalideCandidateExceptions $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de la mise-à-jour du candidat",
                'msg' => $e
            ]);
        }

        // On met à jour le candidat
        $this->updateCandidat($cle_candidat, $c->exportToSQL_update()); //
        unset($c);

        // On supprime les diplomes du candidat
        $request = "DELETE FROM Obtenir WHERE Cle_Candidats = :cle";
        $params = ['cle' => $cle_candidat];
        $this->post_request($request, $params);

        // On récupère la liste des diplomes
        for($i = 0; $i < count($candidat['diplome']); $i++) 
            $this->inscriptObtenir($cle_candidat, $this->searchDiplome($candidat['diplome'][$i])['Id_Diplomes']);
        unset($candidat['diplome']);

        // On supprime l'aide du candidat
        $request = "DELETE FROM Avoir_droit_a WHERE Cle_Candidats = :cle";
        $params = ['cle' => $cle_candidat];
        $this->post_request($request, $params);

        // On enregistre les aides
        if($candidat['aide'] != null) foreach($candidat['aide'] as $item) 
            $this->inscriptAvoir_droit_a($cle_candidat, $item, $item == 3 ? $candidat['coopteur'] : null);    
        unset($candidat);
    }

    /**
     * Public function registering the update candidte's rating logs
     *
     * @param Int $key_candidate
     * @return Void
     */
    public function updateRatingLogs($key_candidate) {
        $candidat = $this->searchcandidate($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour notation",
            "Mise-à-jour de la notation de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname'])
        );
    }
    /// Méthode publique enregistrant les logs de la mise-à-jour d'un candidat
    public function updateCandidatLogs($cle_candidat) {
        // On récupère les informations du candidat
        $candidat = $this->searchcandidat($cle_candidat);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour candidat",
            "Mise-à-jour du profil de " . strtoupper($candidat['Nom_Candidats']) . " " . forms_manip::nameFormat($candidat['Prenom_Candidats'])
        );
    }
    /// Méthode publique enregistrant les logs de la mise-à-jour d'un rendez-vous
    public function updateMeetingLogs($key_candidate) {
        $candidat = $this->searchcandidate($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour rendez-vous",
            "Mise-à-jour du rendez-vous de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname'])
        );
    }

    // ! Méthode à remplacer par public searchCandidate() déclarée dans Model.php
    /// Méthode protégée recherchant un candidat dans la base de données
    // private function searchCandidat($cle_candidat) {
    //     if(empty($cle_candidat) || !is_numeric($cle_candidat)) 
    //         throw new Exception('Erreur lors de la recherche du candidat. La clé candidat doit être un nombre entier positif !');
    // 
    //     // On initialise la requête
    //     $request = "SELECT * FROM Candidats WHERE Id_Candidats = :cle";
    //     $params = ['cle' => $cle_candidat];
    // 
    //     // On lance la requête
    //     return $this->get_request($request, $params, true, true);
    // }
}