<?php 

require_once('Controller.php');

/**
 * Class representing the controller of candidates
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidatController extends Controller {
    /**
     * Class' constructor
     */
    public function __construct() {
        $this->loadModel('CandidatsModel');
        $this->loadView('CandidatsView');
    }

    // * DISPLAY * //
    /**
     * Public method generating the candidates' main page
     *
     * @return View HTML PAGE
     */
    public function displayContent() {
        return $this->View->getContent(
            'Candidats', 
            $this->Model->getContent()
        );
    }
    /**
     * Public method displaying the candidate's profile
     *
     * @param Int $Key_candidate The candidate's primary key
     * @return View HTML PAGE
     */
    public function displayCandidate(int $key_candidate) {
        $item = $this->Model->displayContentCandidate($key_candidate); 
        return $this->View->displayContentCandidate(
            "Candidat " . $item['candidate']['Name'] . ' ' . $item['candidate']['Firstname'], 
            $this->Model->displayContentCandidate($key_candidate)
        );
    }

    // * DISPLAY INPUT * //
    /**
     * Public method returning the html form of inputing a meeting
     *
     * @param Int $key_candidate The candidate's primary ket
     * @return View HTML page
     */
    public function displayInputMeetings(int $key_candidate) {
        return $this->View->displayInputMeetings(
            "Nouveau rendez-vous",
            $key_candidate,
            $this->Model->searchEstablishments($_SESSION['key_establishment'])['Titled'], 
            $this->Model->getUsersForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete()
        );
    }
    /**
     * Public method testing the candidate's data and returning the application's html form
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function displayInputApplications(int $key_candidate) { 
        $_SESSION['candidate'] = $this->Model->makeCandidate($key_candidate);
        header('Location: index.php?applications=input-applications');
    }
    /**
     * Public method returning the offer's HTML form
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int|Null $key_application The candidate's primary key
     * @param Int|Null $key_need The candidate's primary key
     * @return Void
     */
    public function displayInputOffers(int $key_candidate, int|null $key_application = null, int|null $key_need = null) {
        if(!empty($key_application)) 
            $offer = $this->Model->searchApplications($key_application);
        elseif(!empty($key_need))
            $offer = []; // Todo : à compléter si la feature 'besoins' est développée 

        if(isset($offer['Key_Jobs']) && is_numeric($offer['Key_Jobs']))
            $offer['Key_Jobs'] = $this->Model->searchJobs($offer['Key_Jobs'])['Titled'];
        if(isset($offer['Key_Services']) && is_numeric($offer['Key_Services']))
            $offer['Key_Services'] = $this->Model->searchServices($offer['Key_Services'])['Titled'];
        if(isset($offer['Key_Establishments']) && is_numeric($offer['Key_Establishments']))
            $offer['Key_Establishments'] = $this->Model->searchEstablishments($offer['Key_Establishments'])['Titled'];
        if(isset($offer['Key_Sources']) && is_numeric($offer['Key_Sources']))
            $offer['Key_Sources'] = $this->Model->searchSources($offer['Key_Sources'])['Titled'];
        if(isset($offer['Key_Types_of_contracts']) && is_numeric($offer['Key_Types_of_contracts']))
            $offer['Key_Types_of_contracts'] = $this->Model->searchTypesOfContracts($offer['Key_Types_of_contracts'])['Titled'];

        return $this->View->displayInputOffers(
            "Ypopsi - Nouvelle proposition", 
            $key_candidate,
            $this->Model->getJobsForAutoComplete(),
            $this->Model->getServicesForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete(),
            $this->Model->getTypesOfContractsForAutoComplete(), 
            $offer
        );
    }
    /**
     * Undocumented function
     *
     * @param [type] $key_candidate
     * @return void
     */
    public function displayInputContracts(int $key_candidate) {
        return $this->View->displayInputContracts(
            "Ypopsi - Nouveau contrat", 
            $key_candidate,
            $this->Model->getJobsForAutoComplete(),
            $this->Model->getServicesForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete(),
            $this->Model->getTypesOfContractsForAutoComplete()
        );
    }

    // * DISPLAY EDIT * //
    /**
     * Public method returning the HTML form to editing a candidate
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function displayEditCandidates(int $key_candidate) {
        return $this->View->displayEditCandidates(
            $this->Model->getEditCandidates($key_candidate),
            $this->Model->getQualificationsForAutoComplete(),
            $this->Model->getHelpsForAutoComplete(),
            $this->Model->getEmployeeForAutoComplete()
        );
    }
    /**
     * Public method returning the ratingd HTML form
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function displayEditRatings(int $key_candidate) {
        return $this->View->displayEditRatings($this->Model->searchCandidates($key_candidate));
    }
    /**
     * Méthode publique renvoyant le formulaire d'édition de la réunion
     *
     * @param Int $key_meeting The meeting's primary key
     * @return View HTML Page
     */
    public function displayEditMeetings(int $key_meeting) { 
        return $this->View->displayEditMeetings(
            $this->Model->getEditMeetings($key_meeting),
            $this->Model->getUsersForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete()
        ); 
    }
    
    // * CREATE * //
    /**
     * Public method generating a new meeting
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $meeting The array containing the meeting's data
     * @return Void
     */
    public function createMeetings(int $key_candidate, array &$meeting) {
        $this->Model->createMeetings($key_candidate, $meeting);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le rendez-vous a été ajouté avec succès.',
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method generating and registering an offer
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $offer The arrayu containing the offer's data
     * @param Int|Null $key_application The application's primary key (if the offer is made from an application)
     * @return Void
     */
    public function createOffers(int $key_candidate, array $offer, int|null $key_application = null) {
        if(!empty($key_application))
            $this->Model->setApplicationsAccepted($key_application);
        $this->Model->createOffers($key_candidate, $offer);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le proposition a été générée',
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method creating an contract
     * 
     * @param Int $key_candidate The candidate's primary key
     * @param Array $contract
     * @return Void
     */
    public function createContracts(int $key_candidate, array &$contract) {   
        $this->Model->createContracts($key_candidate, $contract);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le contrat a été généré',
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }

    // * UPDATE * //
    /**
     * Public method updating a candidte's rating
     *
     * @param Int $key_candidate
     * @param Array $rating
     * @return Void
     */
    public function updateRatings(int $key_candidate, array &$rating) {
        $this->Model->updateRatings($key_candidate, $rating['notation'], $rating['description'], $rating['a'], $rating['b'], $rating['c']);
        $this->Model->updateRatingsLogs($key_candidate);
        alert_manipulation::alert([
            'title' => "Candidat mise-à-jour",
            'msg' => "Vous avez mis-à-jour la notation du candidat",
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method updating the meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @param Int $key_candidate The candidate's key
     * @param Array $rdv
     * @return Void
     */
    public function updateMeetings(int $key_meeting, int $key_candidate, array &$meeting) {
        $this->Model->updateMeetings($key_meeting, $meeting['employee'], $key_candidate, $meeting['establishment'], $meeting['date'], $meeting['description']);
        $this->Model->updateMeetingsLogs($key_candidate);
        alert_manipulation::alert([
            'title' => "Rendez-vous mise-à-jour",
            'msg' => "Vous avez mis-à-jour le rendez-vous du candidat",
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method updating a candidate
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $data The array containing the candidate's new data
     * @return Void
     */
    public function updateCandidates(int $key_candidate, array &$data) {
        $this->Model->makeUpdateCandidates($key_candidate, $data);
        alert_manipulation::alert([
            'title' => "Candidat mise-à-jour",
            'msg' => "Vous avez mis-à-jour les données personnelles du candidat",
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }

    // * DELETE * //
    /**
     * Public method deleting a meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @param Int $key_candidate The candidate'sprimary key
     * @return Void 
     */
    public function deleteMeetings(int $key_meeting, int $key_candidate) {
        $this->Model->deletingMeetings($key_meeting);
        alert_manipulation::alert([
            'title' => "Rendez-vous annulé",
            'msg' => "Vous avez annulé le rendez-vous du candidat",
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }

    // * OTHER * //
    /**
     * Public method dismissing an application
     *
     * @param Int $key_applications The application's primary key
     * @return Void
     */
    public function dismissApplications(int $key_applications) {
        $this->Model->dismissApplications($key_applications);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La candidature a été rejettée',
            'direction' => 'index.php?candidates=' . $this->Model->searchCandidatesFromApplications($key_applications)['Id']
        ]);
    }
    /**
     * Public method rejecting an offer
     *
     * @param Int $key_offer The offer's primary key
     * @return Void
     */
    public function rejectOffers(int $key_offer) {
        $this->Model->rejectOffers($key_offer); 
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La proposition a été rejettée',
            'direction' => 'index.php?candidates=' . $this->Model->searchCandidatesFromContracts($key_offer)['Id']
        ]);
    }
    /**
     * Public method adding an signature to a contract
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_contract The contract's primary key
     * @return Void
     */
    public function signContracts(int $key_candidate, int $key_contract) {
        $this->Model->addSignatureToContract($key_candidate, $key_contract);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le contrat a été signé !',
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method adding a resignation to a contract
     *
     * @param Int $key_contract The contract's primary key
     * @return Void 
     */
    public function resignContracts(int $key_contract){
        $this->Model->setResignationToContract($key_contract);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le candidat a démissioné de son contrat',
            'direction' => 'index.php?candidates=' . $this->Model->searchCandidatesFromContracts($key_contract)['Id']
        ]);
    }
}