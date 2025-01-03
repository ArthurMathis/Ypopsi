<?php

require_once 'Controller.php';
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
    function displayLogin() { return $this->View->getContent(); }

    /**
     * Public method connecting one user to the application
     *
     * @param String $identifier THe user's id (ex: name.f)
     * @param String $pasword The user's password
     * @return Void
     */
    public function checkIdentification(string $identifier, string $pasword) {
        $this->Model->connectUser($identifier, $pasword);
        header('Location: index.php');
    }
    /**
     * Public method disconnecting the current user to the application
     *
     * @return Void
     */
    public function closeSession() {
        $this->Model->deconnectUser();
        header('Location: index.php?login=get_connexion');
    }
}