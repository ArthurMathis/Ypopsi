<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Tools\AlertsManip;
use App\Core\Tools\PasswordsManip;
use App\Models\Action;
use App\Repository\ActionRepository;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use App\Repository\EstablishmentRepository;
use Exception;

class PreferencesController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() {
        $this->loadView('PreferencesView');
    }

    // * DISPLAY * //
    /**
     * Public method displaying the preferences' page
     *
     * @return void
     */
    public function display(): void {
        $this->View->display();
    }

    /**
     * Public method displaying the user's profile page
     *
     * @return void
     */
    public function displayProfile(int $key_user): void {
        $user = (new UserRepository())->get($key_user);
        $role = (new RoleRepository())->get($user->getRole());
        $establishment = (new EstablishmentRepository())->get($user->getEstablishment());

        $act_repo = new ActionRepository();
        $first_log = $act_repo->getUserFirstUserConnection($user); 
        $last_log = $act_repo->getUserLastUserConnection($user);
        $first_password_change = $act_repo->getUserFirstUserPasswordChange($user);
        $last_password_change = $act_repo->getUserLastUserPasswordChange($user);
        $nb_connexions = $act_repo->getNumberOfUserConnexions($user);
        $nb_actions = $act_repo->getNumberOfUserActions($user);
        $nb_applications = $act_repo->getNumberOfUserApplications($user);
        $nb_offers = $act_repo->getNumberOfUserOffers($user);
        $nb_contracts = $act_repo->getNumberOfUserContracts($user);
        $nb_meetings = $act_repo->getNumberOfUserMeetings($user);

        $this->View->displayProfile(
            $user,
            $role,
            $establishment, 
            $nb_connexions, 
            $nb_actions,
            $nb_applications,
            $nb_offers,
            $nb_contracts,
            $nb_meetings,
            $first_log,
            $last_log,
            $first_password_change,
            $last_password_change,
            "home"
        );
    }

    /**
     * Public method displaying the connections logs
     *
     * @return void
     */
    public function displayLogs(): void {
        $act_repo = new ActionRepository();
        $logs = $act_repo->getConnectionList();
        $this->View->displayLogs($logs);
    }

    /**
     * Public method displaying the actions displayLogs
     * 
     * @return void
     */
    public function displaysLogAction(): void {
        $act_repo = new ActionRepository();
        $logs = $act_repo->getActionList();
        $this->View->displayActionLogs($logs);
    }

    /**
     * Public method displaying the the cuser's connections logs
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function displayUserLogs(int $key_user): void {
        $act_repo = new ActionRepository();
        $logs = $act_repo->getUserConnectionList($key_user);
        $this->View->displayProfileLogs($logs);
    }

    /**
     * Public method displaying the the cuser's actions logs
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function displaysUserLogAction(int $key_user): void {
        $act_repo = new ActionRepository();
        $logs = $act_repo->getUserActionList($key_user);
        $this->View->displayProfileActionLogs($logs);
    }

    // * EDIT  * // 
    /**
     * Public method returning the user edit HTML form page
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function editUser(int $key_user): void {
        $user = (new UserRepository())->get($key_user);

        $esta_repo = new EstablishmentRepository();
        $establishment = $esta_repo->get($user->getEstablishment());
        $list_establishment = $esta_repo->getAutoCompletion();

        $role_repo = new RoleRepository();
        $role = $role_repo->get($user->getRole());
        $list_role = $role_repo->getList();

        $this->View->displayEditUser(
            $list_establishment, 
            $list_role,
            $user,
            $role,
            $establishment
        );
    }

    /**
     * Public method returning the user edit password HTML form page
     *
     * @param int $key_user
     * @return void
        */
    public function editPassword(int $key_user): void {
        $user = (new UserRepository())->get($key_user);
        $this->View->displayEditPassword($user);
    }

    /**
     * Public method returning the reste user's password notification
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function fetchResetPassword(int $key_user): void {
        $_SESSION["password"] = PasswordsManip::random_password();                             // Generating a new password
        AlertsManip::alert([
            "title"         => "Information importante",
            "msg"           => "Le mot de passe va être réinitialisé et <b>il ne pourra plus être consulté</b>. Mémorisez-le avant de valider ou revenez en arrière.<br>"
                                . "Le nouveau mot de passe est : <b> " . $_SESSION["password"]. "</b>",
            "direction"     => APP_PATH . "/preferences/users/reset_password/" . $key_user,
            "confirm"       => "Réinitialiser le mot de passe",
            "confirmButton" => "Réinitialiser",
            "deleteButton"  => "Annuler"
        ]);
    }

    // * UPDATE * //
    /**
     * Public method updating the user in the database
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function updateUser(int $key_user): void {
        $user_repo = new UserRepository();                                                  // Fetching the user
        $user = $user_repo->get($key_user);

        $user->setName($_POST['name']);
        $user->setFirstname($_POST['firstname']);
        $user->setEmail($_POST['email']);
        $user->setEstablishment($_POST['establishment']);
        $user->setRole($_POST['role']);

        $user_repo->update($user);                                                          // Updating the user 

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Mise à jour utilisateur");
        $desc = "Mise à jour utilisateur de  " . $user->getCompleteName();

        $act = Action::create(                                                              // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La mise a jour a été effectuée avec succès.',
            'direction' => APP_PATH . "/preferences/users/profile/" . $key_user
        ]);
    }

    /**
     * Public method updating the user password in the database
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function updatePassword(int $key_user): void {
        $password = $_POST['password'];                                                         // Getting the password
        $new_password = $_POST['new-password']; 

        $user_repo = new UserRepository();
        $user = $user_repo->get($key_user);                                                     // Fetching the user

        $user->setPassword($new_password);                                                      // Updating the password
        $user_repo->updatePassword($user); 

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Mise à jour mot de passe");
        $desc = "Mise à jour du mot de passe de  " . $user->getCompleteName();

        $act = Action::create(                                                              // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La mot de passe a été mis à jour avec succès.',
            'direction' => APP_PATH . "/preferences/users/profile/" . $key_user
        ]);
    }

    /**
     * Public method updating the user password in the database
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function resetPassword(int $key_user): void {
        $user_repo = new UserRepository();                                                      // fFetching the user
        $user = $user_repo->get($key_user);

        $user->setPassword($_SESSION["password"]);                                              // Updating the password
        $user_repo->updateResetPassword($user); 
        unset($_SESSION["password"]);

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Réinitialisation mot de passe");
        $desc = "Réinitialisation du mot de passe de  " . $user->getCompleteName();

        $act = Action::create(                                                                  // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          

        $act_repo->writeLogs($act);                                                             // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La mot de passe a été réinitialisé avec succès.',
            'direction' => APP_PATH . "/preferences/users/profile/" . $key_user
        ]);
    }
}