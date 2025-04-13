<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\UserRepository;
use App\Models\Action;
use App\Repository\ActionRepository;
use App\Repository\RoleRepository;
use App\Core\Moment;
use App\Exceptions\LoginExceptions;

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

        LoginController::initConnectionTime();

        $role_repo = new RoleRepository();
        $role = $role_repo->get($_SESSION['user']->getRole());
        $_SESSION['user_titled_role'] = $role->getTitled();

        $act_repo = new ActionRepository();                                         // Building the action
        $type = $act_repo->searchType("Connexion");

        $act = Action::create(
            $_SESSION['user']->getId(), 
            $type->getId()
        );

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
            $act_repo = new ActionRepository();
            $type = $act_repo->searchType("Déconnexion"); 

            $act = Action::create(                                                      // Building the action
                $_SESSION['user']->getId(), 
                $type->getId()
            );

            $act_repo->writeLogs($act);                                                 // Writing the logs   
        } 

        session_destroy();

        header("Location: " . APP_PATH . "/login/get");
    }

    // *  CONECTION TIME * //
    /**
     * Public static method returning the connection timestamp
     *
     * @return int The connection timestamp
     */
    public static function getConnectionTime(): int {
        return $_SESSION["connection_timestamp"];
    }
    /**
     * Public static method setting the connection timestamp
     *
     * @param int $time The connection timestamp
     * @return void
     */
    public static function setConnectionTime(int $time): void {
        $_SESSION["connection_timestamp"] = $time;
    }
    /**
     * Public static method initializing the connection timestamp
     *
     * @return void
     */
    public static function initConnectionTime(): void {
        $extension = Moment::hourToTimsetamp(getenv("APP_SECURITY_DATA_TIME"));
        $time = Moment::currentMoment()->getTimestamp() + $extension;
        LoginController::setConnectionTime($time);
    }
    /**
     * Public static method updating the connection timestamp and checking if the connexion is still valid or not
     *
     * @return void
     */
    public static function updateConnectionTime(): void {
        $delta = Moment::currentMoment()->getTimestamp() - LoginController::getConnectionTime();
        if($delta <= 0) {
            $extension = Moment::hourToTimsetamp(getenv("APP_SECURITY_DATA_INACTIVE_TIME"));
            $time = LoginController::getConnectionTime() + $extension;
            LoginController::setConnectionTime($time);
        } else {
            throw new LoginExceptions("Votre connexion a expiré. Veuillez vous reconnecter.");
        }
    } 
}