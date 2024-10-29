<?php 

require_once('Controller.php');

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
        $items = $this->Model->getContent();
        return $this->View->getContent('Candidats', $items);
    }
    /**
     * Public method displaying the candidate's profile
     *
     * @param Int $Key_candidate The candidate's primary key
     * @return View HTML PAGE
     */
    public function displayCandidate($Key_candidate) { 
        $item = $this->Model->getContentCandidate($Key_candidate);
        return $this->View->getContentCandidate("Candidat " . $item['candidate']['Name'] . ' ' . $item['candidate']['Firstname'], $item);
    }

    // * GET * //
    /**
     * Public method returning the html form of inputing a meeting
     *
     * @param Int $key_candidate The candidate's primary ket
     * @return View HTML page
     */
    public function getInputMeetings($key_candidate) {
        return $this->View->GetContentMeeting(
            "Nouveau rendez-vous",
            $key_candidate,
            $this->Model->searchEstablishments($_SESSION['key_establishment'])['Titled'], 
            $this->Model->getAutoCompUsers(),
            $this->Model->getAutoCompEstablishments()
        );
    }
    /**
     * Public method testing the candidate's data and returning the application's html form
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function getInputApplications($key_candidate) { 
        $_SESSION['candidate'] = $this->Model->makeCandidate($key_candidate);
        header('Location: index.php?applications=input-applications');
    }
    /**
     * Public method returning the offer's HTML form
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int|NULL $key_application The candidate's primary key
     * @param Int|NULL $key_need The candidate's primary key
     * @return Void
     */
    public function getInputOffers($key_candidate, $key_application=null, $key_need=null) {
        if(!empty($key_application)) 
            $offer = $this->Model->searchApplications($key_application);
        elseif(!empty($key_need))
            $offer = [];
        else 
            $offer = [];

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

        return $this->View->getOffersContent(
            "Ypopsi - Nouvelle proposition", 
            $key_candidate,
            $this->Model->getAutoCompJobs(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompEstablishments(),
            $this->Model->getAutoCompTypesOfContracts(), 
            $offer
        );
    }
    /**
     * Undocumented function
     *
     * @param [type] $key_candidate
     * @return void
     */
    public function getInputContracts($key_candidate) {
        return $this->View->getContractsContent(
            "Ypopsi - Nouveau contrat", 
            $key_candidate,
            $this->Model->getAutoCompJobs(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompEstablishments(),
            $this->Model->getAutoCompTypesOfContracts()
        );
    }

    // TODO : Remanier la méthode
    /// Méthode publique affichant le formulaire d'édition d'un candidat
    public function getEditCandidates($cle_candidat) {
        return $this->View->getEditCandidates(
            $this->Model->getEditCandidatesContent($cle_candidat)
        );
    }
    /**
     * Public method returning the ratingd HTML form
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Void
     */
    public function getEditRatings($key_candidate) {
        return $this->View->getEditRatings($this->Model->searchCandidates($key_candidate));
    }
    /**
     * Méthode publique renvoyant le formulaire d'édition de la réunion
     *
     * @param Int $key_meeting The meeting's primary key
     * @return View HTML Page
     */
    public function getEditMeetings($key_meeting) { 
        return $this->View->getEditMeeting(
            $this->Model->getEditMeetingContent($key_meeting),
            $this->Model->getAutoCompUsers(),
            $this->Model->getAutoCompEstablishments()
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
    public function createMeeting($key_candidate, &$meeting=[]) {
        $this->Model->createMeeting($key_candidate, $meeting);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le rendez-vous a été générée',
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    /**
     * Public method generating and registering an offer
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Array $offer The arrayu containing the offer's data
     * @param Int|NULL $key_application The application's primary key (if the offer is made from an application)
     * @return Void
     */
    public function createOffer($key_candidate, $offer, $key_application = null) {
        if(!empty($key_application))
            $this->Model->setApplicationsAccepted($key_application);

        $this->Model->createOffer($key_candidate, $offer);
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
    public function createContracts($key_candidate, &$contract=[]) {
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
    public function updateRating($key_candidate, &$rating=[]) {
        $this->Model->updateRating($key_candidate, $rating);
        $this->Model->updateRatingLogs($key_candidate);
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
    public function updateMeeting($key_meeting, $key_candidate, &$meeting=[]) {
        $this->Model->updateMeeting(
            $key_meeting, 
            $this->Model->searchUsers($meeting['employee'])['Id'], 
            $key_candidate, 
            $this->Model->searchEstablishments($meeting['establishment'])['Id'], 
            $meeting['date'], 
            $meeting['description']
        );
        $this->Model->updateMeetingLogs($key_candidate);

        alert_manipulation::alert([
            'title' => "Rendez-vous mise-à-jour",
            'msg' => "Vous avez mis-à-jour le rendez-vous du candidat",
            'direction' => 'index.php?candidates=' . $key_candidate
        ]);
    }
    // TODO : Méthode à remanier
    /// Méthode publique mettant à jour le profil d'un candidat
    public function updateCandidat($cle_candidat, &$candidat=[]) {
        // On met à jour le candidat
        $this->Model->makeUpdateCandidat($cle_candidat, $candidat);

        // On enregistre les logs
        $this->Model->updateCandidateLogs($cle_candidat);

        // On redirige la page
        alert_manipulation::alert([
            'title' => "Candidat mise-à-jour",
            'msg' => "Vous avez mis-à-jour les données personnelles du candidat",
            'direction' => 'index.php?candidates=' . $cle_candidat
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
    public function deleteMeeting($key_meeting, $key_candidate) {
        $this->Model->deletingMeeting($key_meeting);
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
    public function dismissApplications($key_applications) {
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
    public function rejectOffer($key_offer) {
        $this->Model->rejectOffer($key_offer); 
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
    public function signContract($key_candidate, $key_contract) {
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
    public function resignContract($key_contract){
        $this->Model->setResignationToContract($key_contract);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le candidat a démissioné de son contrat',
            'direction' => 'index.php?candidates=' . $this->Model->searchCandidatesFromContracts($key_contract)['Id']
        ]);
    }
}