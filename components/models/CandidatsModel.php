<?php 

require_once('Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Contract.php');


class CandidatsModel extends Model {
    // * GET * //
    /**
     * Public method returning the list of candidates 
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
    /**
     * Public method searching and returning the candidate's data
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array
     */
    public function getEditCandidates($key_candidate) {
        $candidate = $this->searchCandidates($key_candidate);
        $candidate['qualifications'] = $this->getQualificationsFromCandidates($key_candidate);
        $candidate['helps'] = $this->getHelpsFromCandidates($key_candidate);

        return [
            'candidate' => $candidate,
            'employee' => $this->searchCoopter($key_candidate),
            'helps' => $this->getHelps(),
            'qualifications' => $this->getQualifications()
        ];
    }
    /**
     * Public method search and returning the meeting's data
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Array
     */
    public function getEditMeetings($key_meeting): Array {
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
    public function displayContentCandidate($key_candidate): Array {
        $candidate = $this->searchCandidates($key_candidate);
        $candidate['qualifications'] = $this->getQualificationsFromCandidates($key_candidate);

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
     * Private method that searches and returns a candidate's qualifications based on its primary key
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    private function getQualificationsFromCandidates($key_candidate): ?Array {
        $request = "SELECT 
        q.Titled AS titled, 
        g.Date AS date
    
        FROM candidates AS c
        INNER JOIN Get_qualifications AS g ON c.Id = g.Key_Candidates
        INNER JOIN Qualifications AS q on g.Key_Qualifications = q.Id
        
        WHERE c.Id = :key";
        $params = ['key' => $key_candidate];
    
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
        app.IsAccepted AS acceptee, 
        app.IsRefused AS refusee, 
        s.titled AS source, 
        t.titled AS type_de_contrat,
        app.moment AS date,
        j.titled AS poste,
        serv.titled AS service,
        e.titled AS etablissement
        
        FROM Applications AS app
        INNER JOIN Sources AS s ON app.key_sources = s.Id
        INNER JOIN Jobs AS j ON app.key_jobs = j.Id
        LEFT JOIN Types_of_contracts AS t ON app.Key_Types_of_contracts = t.Id
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
        t.titled AS type_de_contrat,
        c.StartDate AS date_debut,
        c.EndDate AS date_fin,
        c.PropositionDate AS proposition,
        c.SignatureDate AS signature,
        c.ResignationDate AS demission,
        c.IsRefused AS statut, 
        c.Salary AS salaire,
        c.HourlyRate AS heures,
        c.NightWork AS nuit,
        c.WeekEndWork AS week_end

        FROM Contracts as c
        INNER JOIN Jobs AS j ON c.Key_Jobs = j.Id
        INNER JOIN Services AS s ON c.Key_services = s.Id
        INNER JOIN Establishments AS e ON c.Key_Establishments = e.Id
        INNER JOIN Types_of_contracts AS t ON c.Key_Types_of_contracts = t.Id

        WHERE c.Key_Candidates = :key
        
        ORDER BY c.Id DESC";
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
        helps.Titled AS intitule,
        c.Id AS id


        FROM Have_the_right_to AS have
        INNER JOIN helps ON helps.Id = have.Key_Helps
        LEFT JOIN Candidates AS c ON have.Key_Employee = c.Id
        WHERE have.Key_Candidates = " . $key_candidate;

        $result = $this->get_request($request);
    
        return $this->get_request($request);
    }

    // * CREATE * //
    /**
     * Public method generating a new meeting
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $meeting The array containing the meeting's data
     * @return Void
     */
    public function createMeetings($key_candidate, &$meeting=[]) {
        $this->inscriptMeetings(
            $this->searchUsers($meeting['recruteur'])['Id'], 
            $key_candidate, 
            $this->searchEstablishments($meeting['etablissement'])['Id'], 
            (new DateTime($meeting['date'] . ' ' . $meeting['time'], new DateTimeZone('Europe/Paris')))->getTimestamp()
        );

        $candidate = $this->searchCandidates($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau rendez-vous", 
            "Nouveau rendez-vous avec " . strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . ", le " . $meeting['date']
        );
    }
    /**
     * Public method building and registering an offer
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $offer The array containing the offer's data
     * @return Void
     */
    public function createOffers($key_candidate, $offer=[]) {
        $offer['poste'] = $this->searchJobs($offer['poste'])['Id'];
        $offer['service'] = $this->searchServices($offer['service'])['Id'];
        $offer['etablissement'] = $this->searchEstablishments($offer['etablissement'])['Id'];
        if(!$this->verifyServices($offer['service'], $offer['etablissement']))
            throw new Exception("Ce service n'existe pas dans l'établissement sélectionné...");

        $this->inscriptContracts(
            $key_candidate,
            $offer['poste'],
            $offer['service'],
            $offer['etablissement'],
            $this->searchTypesOfContracts($offer['type_de_contrat'])['Id'],
            $offer['date debut'], 
            isset($offer['date fin']) ? $offer['date fin'] : null, 
            null,
            isset($offer['salaire']) ? $offer['salaire'] : null,
            isset($offer['taux horaire']) ? $offer['taux horaire'] : null,
            isset($offer['travail nuit']) ? $offer['travail nuit'] : null,
            isset($offer['travail wk']) ? $offer['travail wk'] : null
        );
        $candidat = $this->searchCandidates($key_candidate);
        $this-> writeLogs(
            $_SESSION['user_key'],
            "Nouvelle proposition",
            "Nouvelle proposition de contrat pour " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname']) . " au poste de " . forms_manip::nameFormat($this->searchJobs($offer['poste'])['Titled'])
        );
    }
    /**
     * Public method creating and registering and contract and the logs
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $contract The array containing the contract's data
     * @return Void
     */
    public function createContracts($key_candidate, &$contract=[]) {
        $contract['candidate'] = $key_candidate;
        $contract['job'] = $this->searchJobs($contract['job'])['Id'];
        $contract['service'] = $this->searchServices($contract['service'])['Id'];
        $contract['establishment'] = $this->searchEstablishments($contract['establishment'])['Id'];
        $contract['type'] = $this->searchTypesOfContracts($contract['type'])['Id'];
        $contract['start_date'] = Moment::fromDate($contract['start_date']);
        $contract['end_date'] = Moment::fromDate($contract['end_date']);
        $contract['signature'] = Moment::currentMoment();

        if(!$this->verifyServices($contract['service'], $contract['establishment']))
            throw new Exception("Ce service n'existe pas dans l'établissement sélectionné...");
        $contract = Contract::makeContract($contract);
        $this->inscriptContracts(
            $key_candidate,
            $contract->getJob(),
            $contract->getService(),
            $contract->getEstablishment(),
            $contract->getType(),
            date('Y-m-d H:i:s', $contract->getStartDate()->getTimestamp()),
            date('Y-m-d H:i:s', $contract->getEndDate()->getTimestamp()),
            date('Y-m-d H:i:s', $contract->getSignature()->getTimestamp()),
            $contract->getHourlyRate(),
            $contract->getNightWork(),
            $contract->getWeekEndWork()
        ); 
        
        $candidate = $this->searchCandidates($contract->getCandidate());
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Nouveau contrat", 
            "Nouveau contrat de " . strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . " au poste de " . $this->searchJobs($contract->getJob())['Titled']
        );
    }

    // * SEARCH * //
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
    
    /**
     * Public method building an candidate from his primary key
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Candidate
     */
    public function makeCandidate($key_candidate): Candidate {
        $result = $this->searchCandidates($key_candidate);
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

    // * OTHER * // 
    /**
     * Public function deleting a meeting and registering the linked logs
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Void
     */
    public function deletingMeetings($key_meeting) {
        $meeting = $this->searchMeetings($key_meeting);
        $candidate = $this->searchCandidates($meeting['Key_Users']); 
        $this->deleteMeetings($key_meeting);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Annulation rendez-vous",
            strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . " a annulé son rendez-vous du " . date('Y m d', strtotime($meeting['Date']))
        );
    }
    /**
     * Public method settin IsAccepted on TRUE
     *
     * @param Int $key_application The application's primary key
     * @return Void
     */
    public function setApplicationsAccepted($key_application) {
        $request = "UPDATE Applications SET IsAccepted = TRUE AND IsRefused = FALSE WHERE Id = :key_application";
        $params = ['key_application' => $key_application];

        $this->post_request($request, $params);
    }
    /**
     * Public method settin IsRefused on TRUE
     *
     * @param Int $key_application The application's primary key
     * @return Void
     */
    public function setApplicationsRefused($key_application) {
        $request = "UPDATE Applications SET IsAccepted = FALSE, IsRefused = TRUE WHERE Id = :key_application";
        $params = ['key_application' => $key_application];

        $this->post_request($request, $params);
    }
    /**
     * Public method setting an status to the offer
     *
     * @param Int $key_offer The offer's primary key
     * @param Bool $status The new offer's satus (TRUE: refused offer ; FALSE, not refused offer)
     * @return Void
     */
    public function setOfferStatus($key_offer, $status = true) {
        $request = "UPDATE Contracts SET IsRefused = :status WHERE Id = :key_offer";
        $params = [
            'key_offer' => $key_offer,
            'status' => $status
        ];
        
        $this->post_request($request, $params);
    }

    /**
     * Public method dismissing an application and registering the logs
     *
     * @param Int $key_application The application's primary key
     * @return Void
     */
    public function dismissApplications(&$key_application) {
        $this->setApplicationsRefused($key_application);
        $candidat = $this->searchCandidatesFromApplications($key_application);
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Refus candidature", 
            "Refus de la candidature de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname']) . 
            " au poste de " . forms_manip::nameFormat($this->searchJobs($this->searchApplications($key_application)['Key_Jobs'])['Titled'])
        );
    }
    /**
     * Public method rejecting an offer and registerng the logs
     *
     * @param Int $key_offer Tyhe offer's primary key
     * @return Void
     */
    public function rejectOffers(&$key_offer) {
        $this->setOfferStatus($key_offer); 
        $contract = $this->searchContracts($key_offer); 
        $candidate = $this->searchCandidates($contract['Key_Candidates']); 
        $this->writeLogs(
            $_SESSION['user_key'], 
            "Refus proposition", 
            strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . " refuse la proposition d'embauche au poste de " . forms_manip::nameFormat($this->searchJobs($contract['Key_Jobs'])['Titled'])
        ); 
    }

    /**
     * Public method adding an signature to a contract and registering the logs
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_contract The contract's primary key
     * @return Void
     */
    public function addSignatureToContract($key_candidate, $key_contract) {
        $request = "UPDATE Contracts SET SignatureDate = :date WHERE Id = :key_contract";
        $params = [
            'date'         => date('Y-m-d H:i:s', Moment::currentMoment()->getTimestamp()),
            'key_contract' => $key_contract
        ];
        $this->post_request($request, $params);

        $candidate = $this->searchCandidates($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau contrat", 
            "Nouveau contrat de " . strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Name']) . " au poste de " . $this->searchJobs($this->searchContracts($key_contract)['Key_Jobs'])['Titled']
        );
    }
    /**
     * Public method adding an resignation to a contract and registering the logs
     *
     * @param Int $key_contract The contract's primary key
     * @return Void
     */ 
    public function setResignationToContract($key_contract) {
        $request = "UPDATE Contracts SET ResignationDate = :date WHERE Id = :key_contract";
        $params = [
            'date'         => date('Y-m-d H:i:s', Moment::currentMoment()->getTimestamp()),
            'key_contract' => $key_contract
        ];
        $this->post_request($request, $params);

        $candidate = $this->searchCandidatesFromContracts($key_contract);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Démission",
            strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname']) . " a démissioné de son travail de " . forms_manip::nameFormat($this->searchJobs($this->searchContracts($key_contract)['Key_Jobs'])['Titled'])
        );
    }

    // * UPDATE * // 

    /**
     * Undocumented function

     * 
     * @param Int $key_candidate
     * @param array $data
     * @return void
     */
    public function makeUpdateCandidates($key_candidate, $data=[]) {
        $this->updateCandidates(
            $key_candidate,
            $data['name'],
            $data['firstname'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['city'],
            $data['post_code']
        );

        $temp = $this->searchGetQualificationsFromCandidates($key_candidate);
        if(!empty($temp)) {
            foreach($temp as $obj) {
                $this->deleteGetQualifications($key_candidate, $obj['Key_Qualifications']);
            }
        }
        unset($temp);
        if(!empty($data['qualifications'])) {
            foreach($data['qualifications'] as $obj) {
                $this->inscriptGetQualifications($key_candidate, $this->searchQualifications($obj['qualification'])['Id'], $obj['date']);
            }
        }
        
        $temp = $this->searchHaveTheRightToFromCandidate($key_candidate);
        if(!empty($temp)) {
            foreach($temp as $obj) {
                $this->deleteHaveTheRightTo($key_candidate, $obj['Key_Helps']);
            } 
        }
        unset($temp);
        if(!empty($data['helps'])) {
            foreach($data['helps'] as $obj) {
                $this->inscriptHaveTheRightTo($key_candidate, $obj, $obj == $this->searchHelps(COOPTATION)['Id'] ? $data['coopteur'] : null);
            }
        }

        $candidate = $this->searchCandidates($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour candidat",
            "Mise-à-jour du profil de " . strtoupper($candidate['Name']) . " " . forms_manip::nameFormat($candidate['Firstname'])
        );
    }

    // * UPDATE LOGS * //
    /**
     * Public function registering the update candidte's rating logs
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function updateRatingsLogs($key_candidate) {
        $candidat = $this->searchCandidates($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour notation",
            "Mise-à-jour de la notation de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname'])
        );
    }
    /**
     * Public method registering one meeting update in the logs 
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function updateMeetingsLogs($key_candidate) {
        $candidat = $this->searchCandidates($key_candidate);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour rendez-vous",
            "Mise-à-jour du rendez-vous de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname'])
        );
    }
}