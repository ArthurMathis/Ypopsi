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

    /**
     * Public method generating the candidates' main page
     *
     * @return Void
     */
    public function displayContent() {
        $items = $this->Model->getContent();
        $this->View->getContent('Candidats', $items);
    }
    /// Méthode publique affichant la page candidat
    public function displayCandidat($Key_candidate) {
        $item = $this->Model->getContentCandidatee($Key_candidate);
        return $this->View->getContentCandidate("Candidat " . $item['candidate']['name'] . ' ' . $item['candidate']['firstname'], $item);
    }

    /// Méthode publique affichant le formulaire de saisie d'une candidature
    public function getSaisieCandidature($cle_candidat) { 
        // On vérifie l'intégrité du candidat
        $_SESSION['candidat'] = $this->Model->makeCandidat($cle_candidat);
        // On redirige la page
        header('Location: index.php?candidatures=saisie-candidature');
    }
    /// Méthode publique affichant le formulaire de saisie d'une proposition
    public function getSaisieProposition($cle_candidat) {
        return $this->View->getContentProposition(
            "Ypopsi - Nouvelle proposition", 
            $cle_candidat,
            $this->Model->getAutoCompPostes(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompTypesContrat()
        );
    }
    /// Méthode publique affichant le formulaire de saisie d'une proposition depuis une candidature
    public function getSaisiePropositionFromCandidature($cle_candidature) {
        return $this->View->getContentPropositionFromCandidatures(
            "Ypopsi - Nouvelle proposition", 
            $cle_candidature, 
            $this->Model->getTypeContrat($cle_candidature)
        );
    }
    /// Méthode publique affichant le formulaire de saisie d'une proposition depuis une candidature vide
    public function getSaisiePropositionFromEmptyCandidature($cle_candidature) {
        return $this->View->getContentPropositionFromEmptyCandidatures(
            "Ypopsi - Nouvelle proposition depuis une candidature", 
            $cle_candidature, 
            $this->Model->getTypeContrat($cle_candidature),
            $this->Model->getAutoCompServices()
        );
    }
    /// Méthode publique affichant le formulaire de saisie d'un contrat
    public function getSaisieContrats($cle_candidat) {
        return $this->View->getContentContrats(
            "Ypopsi - Nouveau contrat", 
            $cle_candidat,
            $this->Model->getAutoCompPostes(),
            $this->Model->getAutoCompServices(),
            $this->Model->getAutoCompTypesContrat()
        );
    }
    /**
     * Public method returning the html form of inputing a meeting
     *
     * @param Int $key_candidate The candidate's primary ket
     * @return View HTML page
     */
    public function getInputMeeting($key_candidate) {
        return $this->View->GetContentMeeting(
            "Nouveau rendez-vous",
            $key_candidate,
            $this->Model->searchEstablishment($_SESSION['key_establishment'])['Titled'], 
            $this->Model->getAutoCompUsers(),
            $this->Model->getAutoCompEstablishments()
        );
    }
    /// Méthode publique affichant le formulaire d'édition d'une notation
    public function getEditNotation($cle_candidat) {
        return $this->View->getEditNotation(
            $this->Model->getCandidats($cle_candidat)
        );
    }
    /// Méthode publique affichant le formulaire d'édition d'un candidat
    public function getEditCandidat($cle_candidat) {
        return $this->View->getEditCandidat(
            $this->Model->getEditCandidatContent($cle_candidat)
        );
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

    /// Méthode publique donnant le statut acceptée à une candidature
    public function acceptCandidature($cle) {
        $this->Model->setCandidatureStatut('Acceptée', $cle);
    }
    /// Méthode publique donnant le statut refusée à une candidature
    public function rejectCandidature($cle) {
        // On refuse la candidature
        $this->Model->rejectCandidature($cle);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La candidature a été rejettée',
            'direction' => 'index.php?candidates=' . $this->Model->searchCandidatFromCandidature($cle)['Id_Candidats']
        ]);
    }

    /// Méthode publique donnant le statut acceptée à une candidature
    public function acceptProposition($cle) {
        // Ajouter la signature
        $this->Model->addSignature($cle);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La proposition a été acceptée',
            'direction' => 'index.php?candidates=' . $this->Model->searchcandidatFromContrat($cle)['Id_Candidats']
        ]);
    }
    /// Méthode publique donnant le statut refusée à une candidature
    public function rejectProposition($cle) {
        // $this->Model->setPropositionStatut($cle);
        $this->Model->rejectProposition($cle);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La proposition a été rejettée',
            'direction' => 'index.php?candidates=' . $this->Model->searchcandidatFromContrat($cle)['Id_Candidats']
        ]);
    }
    /// Méthode publique ajoutant une demissione à un contrat
    public function demissioneContrat($cle) {
        $this->Model->addDemission($cle);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le candidat a démissioné de son contrat',
            'direction' => 'index.php?candidates=' . $this->Model->searchcandidatFromContrat($cle)['Id_Candidats']
        ]);
    }


    /// Méthode publique générant une proposition et l'inscrivant dans la base de donnés
    public function createProposition($cle, $propositions) {
        $this->Model->createPropositions($cle, $propositions);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le proposition a été générée',
            'direction' => 'index.php?candidates=' . $cle
        ]);
    }
    /// Méthode publique préparant les données d'une candidature pour la génération d'une porposition d'embauche 
    public function createPropositionFromCandidature($cle_candidature, $propositions=[]) {
        $cle_candidat = null;
        // On récupère les données du futur contrat
        $this->Model->createPropositionsFromCandidature($cle_candidature, $propositions, $cle_candidat);
        
        // On assigne le nouveau statut à la candidature
        $this->acceptCandidature($cle_candidature);
        // On génère la proposition
        $this->createProposition($cle_candidat, $propositions);
    }
    /// Méthode publique préparant les données d'une candidature pour la génération d'une porposition d'embauche
    public function createPropositionFromEmptyCandidature($cle_candidature, $propositions=[]) {
        $cle_candidat = null;
        // On récupère les données du futur contrat
        $this->Model->createPropositionsFromEmptyCandidature($cle_candidature, $propositions, $cle_candidat);
        
        // On assigne le nouveau statut à la candidature
        $this->acceptCandidature($cle_candidature);
        // On génère la proposition
        $this->createProposition($cle_candidat, $propositions);
    }
    /// Méthode publique inscrivant un contrat dans la base de données
    public function createContrat($cle_candidat, &$contrats=[]) {
        $this->Model->createContrats($cle_candidat, $contrats);
        alert_manipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le contrat a été générée',
            'direction' => 'index.php?candidates=' . $cle_candidat
        ]);
    }
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

    /// Méthode publique mettant à jour la notation d'un candidat
    public function updateNotation($cle_candidat, &$notation=[]) {
        $this->Model->updateNotation($cle_candidat, $notation);
        $this->Model->updateNotationLogs($cle_candidat);
        // header('Location: index.php?candidates=' . $cle_candidat);
        alert_manipulation::alert([
            'title' => "Candidat mise-à-jour",
            'msg' => "Vous avez mis-à-jour la notation du candidat",
            'direction' => 'index.php?candidates=' . $cle_candidat
        ]);
    }
    /// Méthode publique mettant à jour le profil d'un candidat
    public function updateCandidat($cle_candidat, &$candidat=[]) {
        // On met à jour le candidat
        $this->Model->makeUpdateCandidat($cle_candidat, $candidat);

        // On enregistre les logs
        $this->Model->updateCandidatLogs($cle_candidat);

        // On redirige la page
        alert_manipulation::alert([
            'title' => "Candidat mise-à-jour",
            'msg' => "Vous avez mis-à-jour les données personnelles du candidat",
            'direction' => 'index.php?candidates=' . $cle_candidat
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
            $this->Model->searchUser($meeting['employee'])['Id'], 
            $key_candidate, 
            $this->Model->searchEstablishment($meeting['establishment'])['Id'], 
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

    /// Méthode publique annulant un rendez-vous
    public function annulationRendezVous($cle_candidat, $cle_utilisateur, $cle_instant) {
        $this->Model->annulationRendezVous($cle_utilisateur, $cle_candidat, $cle_instant);
        alert_manipulation::alert([
            'title' => "Rendez-vous annulé",
            'msg' => "Vous avez annulé le rendez-vous du candidat",
            'direction' => 'index.php?candidates=' . $cle_candidat
        ]);
    }
}