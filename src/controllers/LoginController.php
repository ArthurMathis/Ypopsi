<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\UserRepository;
use App\Models\Action;
use App\Repository\ActionRepository;
use App\Repository\RoleRepository;

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
        (new UserRepository())->connectUser(                                        // Connecting the user
            $_POST['identifiant'], 
            $_POST['motdepasse']
        );

        $role_repo = new RoleRepository();
        $role = $role_repo->searchById($_SESSION['user']->getRole());
        $_SESSION['user_titled_role'] = $role->getTitled();

        $act_repo = new ActionRepository();                                         // Building the action
        $type = $act_repo->searchType("Connexion")['Id'];

        $act = Action::createAction($_SESSION['user']->getId(), $type);

        $act_repo->writeLogs($act);                                                 // Writing the logs                

        header("Location: " . APP_PATH);
    }
    /**
     * Public method disconnecting the current user to the application
     *
     * @return Void
     */
    public function logout() {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId())) {
            $act_repo = new ActionRepository();                                         // Building the action
            $type = $act_repo->searchType("Déconnexion")['Id'];

            $act = Action::createAction($_SESSION['user']->getId(), $type);
            
            $act_repo->writeLogs($act);                                                 // Writing the logs   
        } 

        session_destroy();

        header("Location: " . APP_PATH . "/login/get");
    }
}