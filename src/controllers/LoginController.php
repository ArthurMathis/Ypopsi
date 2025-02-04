<?php 

namespace App\Controllers;

use App\Controllers\Controller;

/**
 * Class representing the login controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginController extends Controller {
    /**
     * Class constructor
     */
    public function __construct() {
        $this->loadModel('LoginModel');
        $this->loadView('LoginView');
    }

    /**
     * Public method returning the login form
     *
     * @return Void
     */
    function display() { return $this->View->getContent(); }

    /**
     * Public method connecting one user to the application
     *
     * @return Void
     */
    public function login() {
        $this->Model->connectUser($_POST['identifiant'], $_POST['motdepasse']);
        header("Location: " . APP_PATH);
    }
    /**
     * Public method disconnecting the current user to the application
     *
     * @return Void
     */
    public function logout() {
        $this->Model->deconnectUser();
        header("Location: " . APP_PATH . "/login/get");
    }
}