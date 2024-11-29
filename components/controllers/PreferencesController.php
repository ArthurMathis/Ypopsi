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

    // * DISPLAY * //
    /**
     * Public method returning the user's profile 
     *
     * @param Int $key_user The user's primary key
     * @return View HTML Page
     */
    public function display($key_user) { return $this->View->displayProfile($this->Model->getProfile($key_user)); }
    
    //// List ////
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
    /**
     * Public method displaying the list of qualifications
     *
     * @return View HTML Page
     */
    public function displayQualifications() { return $this->View->displayQualificationsContent($this->Model->getQualifications()); }
    /**
     * Public method displaying the list of services
     *
     * @return View HTML Page
     */
    public function displayServices() { return $this->View->displayServicesContent($this->Model->getServices()); }
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

    //// Input ////
    /**
     * Public method displaying the users html input form
     *
     * @return View HTML Page
     */
    public function displayInputUsers() {
        return $this->View->displayInputUsers(
            $this->Model->getRoles(),
            $this->Model->getEstablishments()
        );
    }
    /**
     * Public method displaying the jobs HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputJobs() { return $this->View->getInputJobs(); }
    /**
     * Public method displaying the qualifications HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputQualifications() { return $this->View->getInputJobs(); }
    /**
     * Public method dislaying the establishment HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputEstablishments() { return $this->View->displayInputEstablishments($this->Model->getPoles()); }
    /**
     * Public method displaying the hubs HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputPoles() { return $this->View->displayInputPoles(); }

    //// Edit ////
        /**
     * Public method displaying the password HTML edit form
     *
     * @return View HTML Page
     */
    public function displayEditPassword() { return $this->View->displayEditPassword(); }
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

    // * CREATE * //
    /**
     * Public method creating a new user
     *
     * @param Array $data
     * @return Void
     */
    public function createUsers(&$data=[]) {
        if($data == null || empty($data))
            throw new Exception("Erreur lors de l'inscription du nouvel utilisateur. Donnée manquante !");
        else $this->Model->createUsers($data);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouvel utilisateur enregistré !",
            'direction' => 'index.php?preferences=list-new-users'
        ]);
    }
    /**
     * Public method creating a new jobs
     *
     * @param Array<String> $data The array containing the new jobs data
     * @return Void
     */
    public function createJobs(&$data=[]) {
        $this->Model->createJobs($data);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau poste enregistré !",
            'direction' => 'index.php?preferences=list-jobs'
        ]);
    }
    /**
     * Public method creating a new establishment
     *
     * @param Array $data
     * @return Void
     */
    public function createEstablishments(&$data=[]) {
        $this->Model->createEstablishments($data);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau établissement enregistré !",
            'direction' => 'index.php?preferences=list-establishments'
        ]);
    }
    /**
     * Public method creating a new poles
     *
     * @param String $titled The poles' titled 
     * @param String $description The poles' description
     * @return Void
     */
    public function createPoles(&$titled, &$description) {
        $this->Model->createPoles($titled, $description);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "Nouveau pôle enregistré !",
            'direction' => 'index.php?preferences=list-poles'
        ]);
    } 

    // * UPDATE * //
    /**
     * Undocumented function
     *
     * @param Int $key_users The user's primary key
     * @param Array $user The user's data
     * @return Void
     */
    public function updateUsers($key_users, &$user=[]) {
        $this->Model->updateUsers($key_users, $user);
        $this->Model->updateUsersLogs($key_users);
        alert_manipulation::alert([
            'title' => 'Opération réussie',
            'msg' => "L'utilisateur a bien été modifié !",
            'direction' => 'index.php?preferences=' . $key_users
        ]);
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

    // * RESET * // 
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

    // ! OTHERS ! //

    /// Méthode publique retournant le formulaire de saisie d'un nouveau service
    // Todo : remake
    public function displaySaisieService() {
        return $this->View->getSaisieService(
            $this->Model->getAutoCompletEtablissements()
        );
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
}