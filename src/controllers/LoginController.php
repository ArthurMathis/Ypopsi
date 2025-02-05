<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\UserRepository;

/**
 * Class representing the login controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginController extends Controller {
    /**
     * Class constructor
     */
    public function __construct() { $this->loadView('LoginView'); }


    // * DISPLAY * //
    /**
     * Public method returning the login form
     *
     * @return Void
     */
    function display() { return $this->View->getContent(); }


    // * LOG * //
    /**
     * Public method connecting one user to the application
     *
     * @return Void
     */
    public function login() {
        (new UserRepository())->connectUser(
            $_POST['identifiant'], 
            $_POST['motdepasse']
        );

        header("Location: " . APP_PATH);
    }
    /**
     * Public method disconnecting the current user to the application
     *
     * @return Void
     */
    public function logout() {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId())) {
            // Todo : logs
        } 

        session_destroy();

        header("Location: " . APP_PATH . "/login/get");
    }
}