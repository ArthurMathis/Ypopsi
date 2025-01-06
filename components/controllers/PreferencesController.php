<?php

require_once('Controller.php');

/**
 * Class representing the control page controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PreferencesController extends Controller {
    /**
     * Protected and constante attribute containing the url for preferences pages
     * 
     * @var string
     */
    protected const URL = 'index.php?preferences=';


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
    public function display(int $key_user) { return $this->View->displayProfile($this->Model->getProfile($key_user)); }
    
    //// List ////
    /**
     * Public method returning the user list HTML page
     *
     * @return View - HTML Page
     */
    public function displayUsers() { return $this->View->displayUsersContent($this->Model->getUsers(), self::URL); }
    /**
     * Public method returning the list of new users HTML Page
     *
     * @return View HTML Page
     */
    public function displayNewUsers() { return $this->View->displayNewUsersContent($this->Model->getNewUsers(), self::URL); }
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
            $this->Model->getRolesForAutoComplete(),
            $this->Model->getEstablishmentsForAutoComplete()
        );
    }
    /**
     * Public method displaying the jobs HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputJobs() { return $this->View->displayInputJobs(); }
    /**
     * Public method displaying the qualifications HTML input form
     *
     * @return View HTML Page
     */
    public function displayInputQualifications() { return $this->View->displayInputQualifications(); }
    /**
     * Public method dislaying the service HTML input form
     *
     * @return View HTML Page
     */
    public function displaySaisieService() { return $this->View->displayInputServices($this->Model->getEstablishmentsForAutoComplete()); }
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
    public function displayEditUsers(int $user_key) {
        return $this->View->displayEditUsers(
            $this->Model->getEditProfile($user_key),
            $this->Model->getRolesForAutoComplete()
        );
    }

    // * CREATE * //
    /**
     * Public method creating a new user
     *
     * @param Array $data
     * @return Void
     */
    public function createUsers(array &$data) {
        $this->Model->createUsers($data);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouvel utilisateur enregistré !",
            'direction' => 'index.php?preferences=list-new-users'
        ]);
    }
    /**
     * Public method creating a new jobs
     *
     * @param Array<String> $data The array containing the new jobs data
     * @return Void
     */
    public function createJobs(array &$data) {
        $this->Model->createJobs($data);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouveau poste enregistré !",
            'direction' => 'index.php?preferences=list-jobs'
        ]);
    }
    /**
     * Public method creating a new qualification
     *
     * @param String $titled The titled of the new qualification
     * @param Boolean $medical_staff Boolean showing if the new qualification is for medical jobs or not
     * @param String|Null $abbreviation The abbreviation of the titled
     * @return Void
     */
    public function createQualifications(string $titled, bool $medical_staff = false, ?string $abbreviation = null) {
        $this->Model->createQualifications($titled, $medical_staff, $abbreviation);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouveau diplome enregistré !",
            'direction' => 'index.php?preferences=list-jobs'
        ]);
    }
    /**
     * Public method creatng a  new service
     *
     * @param String $service The titled of the new service
     * @param Array<Int> $establishments The array containing th primary key of the establishments containing the new service
     * @param String|Null $description The description of the new service
     * @return Void
     */
    public function createServices(string $service, array $establishments, ?string $description) {
        $this->Model->createServices($service, $establishments, $description);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouveau service enregistré !",
            'direction' => 'index.php?preferences=list-services'
        ]);
    }
    /**
     * Public method creating a new establishment
     *
     * @param Array $data
     * @return Void
     */
    public function createEstablishments(array &$data) {
        $this->Model->createEstablishments($data);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouveau établissement enregistré !",
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
    public function createPoles(string &$titled, string &$description) {
        $this->Model->createPoles($titled, $description);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Nouveau pôle enregistré !",
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
    public function updateUsers(int $key_users, array &$user) {
        $this->Model->updateUsers($key_users, $user['name'], $user['firstname'], $user['email'], $user['role']);
        $this->Model->updateUsersLogs($key_users);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "L'utilisateur a bien été modifié !",
            'direction' => 'index.php?preferences=' . $key_users
        ]);
    }
    /**
     * Public method updating the current user's password
     *
     * @param String $password The previous password
     * @param String $new_password The new password
     * @return Void
     */
    public function updatePassword(string &$password, string &$new_password) {
        if($this->Model->verify_password($password)) {
            $this->Model->updatePassword($new_password);
            $this->Model->updatePasswordLogs();
            alert_manipulation::alert([
                'title'     => 'Opération réussie',
                'msg'       => "Votre mot de passe a bien été modifié !",
                'direction' => 'index.php'
            ]);

        } else forms_manip::error_alert(['msg' => "Erreur lors de la mise à jour du mot de passe, L'ancien mot de passe ne correspond pas !"]);
    }

    // * RESET * // 
    /**
     *Public method for resetting a user's password
     *
     * @param String $password
     * @param Int $key_users
     * @return Void
     */
    public function resetPassword(string $password, int $key_users) {
        $this->Model->resetPassword($password, $key_users);
        $this->Model->resetPasswordLogs($key_users);
        alert_manipulation::alert([
            'title'     => 'Opération réussie',
            'msg'       => "Le mot de passe a bien été réinitialisé !",
            'direction' => 'index.php?preferences=' . $key_users
        ]);
    }
}