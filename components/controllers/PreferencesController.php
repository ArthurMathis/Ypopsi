<?php

require_once('Controller.php');

/**
 * Class representing the control page controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PreferencesController extends Controller {
    /**
     * Class' constructor
     */
    public function __construct() {
        $this->loadModel('PreferencesModel');
        $this->loadView('PreferencesView');
    }

    /**
     * Public method returning the user's profile 
     *
     * @param Int $key_user The user's primary key
     * @return View HTML Page
     */
    public function display($key_user) { return $this->View->displayProfile($this->Model->getProfil($key_user)); }
    /// Méthode publique retournant la page de modification du mot de passe
    public function displayEdit() {
        return $this->View->getEditpassword();
    }

    /**
     * Public method returning the user list HTML page
     *
     * @return View - HTML Page
     */
    public function displayUsers() {
        return $this->View->displayUsersContent(
            $this->Model->getUsers(),
            'index.php?preferences='
        );
    }
    /**
     * Public method returning the list of new users HTML Page
     *
     * @return View HTML Page
     */
    public function displayNewUsers() {
        return $this->View->displayNewUsersContent(
            $this->Model->getNewUsers(),
            'index.php?preferences='
        );
    }
    /**
     * Public method returning the logs history HTML Page
     *
     * @return View HTML Page
     */
    public function displayLogsHistory() { return $this->View->displayLogsHistoryContent($this->Model->getLogsHistory()); }
    /**
     * Public method returning the actions history HTML Page
     *
     * @return View HTML Page
     */
    public function displayActionsHistory() { return $this->View->displayActionsHistoryContent($this->Model->getActionsHistory()); }
    
    /**
     * Public method displaying the list of jobs
     *
     * @return View HTML Page
     */
    public function displayJobs() { return $this->View->displayJobsContent($this->Model->getJobs()); }
    /// Méthode publique retournant la page Services
    public function displayServices() {
        $poste = $this->Model->getServices();
        return $this->View->getServicesContent($poste);
    }
    /**
     * Public method displaying the list of establishments
     *
     * @return View HTML Page
     */
    public function displayEstablishments() { return $this->View->displayEstablishmentsContent($this->Model->getEstablishments()); }
    /**
     * Public method displaying the list of poles
     *
     * @return View HTML Page
     */
    public function displayPoles() { return $this->View->displayPolesContent($this->Model->getPoles()); }

    /// Méthode publique retournant le formulaire d'inscription d'un utilisateur
    public function displaySaisieUtilisateur() {
        return $this->View->getSaisieUtilisateur(
            $this->Model->getRoles(),
            $this->Model->getAutoCompletEtablissements()
        );
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau poste
    public function displaySaisiePoste() {
        return $this->View->getSaisiePoste();
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau service
    public function displaySaisieService() {
        return $this->View->getSaisieService(
            $this->Model->getAutoCompletEtablissements()
        );
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouvel établissement
    public function displaySaisieEtablissement() {
        return $this->View->getSaisieEtablissement(
            $this->Model->getPoles()
        );
    }
    /// Méthode publique retournant le formulaire de saisie d'un nouveau pole
    public function displaySaisiePole() {
        return $this->View->getSaisiePole();
    }
    /**
     * Public method displaying the user edit HTML form
     *
     * @param Int $user_key The suer's primary key
     * @return View HTML Page
     */
    public function displayEditUsers($user_key) {
        return $this->View->displayEditUsers(
            $this->Model->getEditProfile($user_key),
            $this->Model->getRoles()
        );
    }

    /// Méthode publique mettant à jour le mot de passe de l'utilisateur actuel
    public function updatePassword(&$password, &$new_password) {
        if($this->Model->verify_password($password)) {
            $this->Model->updatePassword($new_password);
            $this->Model->updatePasswordLogs();
            alert_manipulation::alert([
                'title' => 'Opération réussie',
                'msg' => "Votre mot de passe a bien été modifié !",
                'direction' => 'index.php'
            ]);

        } else 
            forms_manip::error_alert("Erreur lors de la mise à jour du mot de passe", "L'ancien mot de passe ne correspond pas !");
    }
    public function updateUser($cle_utilisateur, &$user=[]) {
        // On met-à-jour
        $this->Model->updateUser($cle_utilisateur, $user);
        $this->Model->updateUserLogs($cle_utilisateur);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "L'utilisateur a bien été modifié !",
            'direction' => 'index.php?preferences=' . $cle_utilisateur
        ]);
    }
    /// Méthode publique réinitialisant le mot de passe d'un utilisateur
    public function resetPassword($password, $cle_utilisateur) {
        // On réinitialise le mot de passe
        $this->Model->resetPassword($password, $cle_utilisateur);
        // On incrit les logs
        $this->Model->resetPasswordLogs($cle_utilisateur);
        // On redirige la page
        alert_manipulation::alert([
            'title' => 'Opération réussie',
                'msg' => "Le mot de passe a bien été réinitialisé !",
                'direction' => 'index.php?preferences=' . $cle_utilisateur
        ]);
    }

    /// Méthode publique générant un nouvel utilisateur
    public function createUtilisateur(&$infos=[]) {
        // On vérifie l'intégrité des données
        if($infos == null || empty($infos))
            throw new Exception("Erreur lors de l'inscription du nouvel utilisateur. Donnée manquante !");

        // On génère le nouvel utilisateur    
        else $this->Model->createUser($infos);

        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouvel utilisateur enregistré !",
            'direction' => 'index.php?preferences=list-new-users'
        ]);
    }
    /// Méthode publique générant un nouveau poste
    public function createPoste(&$infos=[]) {
        // On vérifie l'intégrité des données
        if(empty($infos)) 
            throw new Exception("Erreur lors de l'inscription du poste. Données manquantes lors de la génération du poste !");

        // On génère le nouveua poste
        else $this->Model->createPoste($infos);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau poste enregistré !",
            'direction' => 'index.php?preferences=list-jobs'
        ]);
    }
    /// Méthode publique générant un nouveau service
    public function createService(&$service, &$etablissement) {
        // On génère le nouveau poste
        $this->Model->createService($service, $etablissement);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau service enregistré !",
            'direction' => 'index.php?preferences=list-services'
        ]);
    }
    /// Méthode publique générant un nouvel établissement
    public function createEtablissement(&$infos=[]) {
        // On génère le nouvel établissement
        $this->Model->createEtablissement($infos);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau établissement enregistré !",
            'direction' => 'index.php?preferences=list-establishments'
        ]);
    }
    /// Méthode publique générant un nouveau pôle
    public function createPole(&$intitule, &$description) {
        // On génère le nouvel établissement
        $this->Model->createPole($intitule, $description);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau pôle enregistré !",
            'direction' => 'index.php?preferences=list-poles'
        ]);
    }
}