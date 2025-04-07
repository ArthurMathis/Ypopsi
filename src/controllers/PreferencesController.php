<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\ActionRepository;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use App\Repository\EstablishmentRepository;

class PreferencesController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() {
        $this->loadView('PreferencesView');
    }

    // * DISPLAY * //
    /**
     * Undocumented function
     *
     * @param int $key_user The user's primary key
     * @return void
     */
    public function display(): void {
        $this->View->display();
    }
    /**
     * Undocumented function
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
            $first_log,
            $last_log,
            $nb_connexions, 
            $nb_actions,
            $nb_applications,
            $nb_offers,
            $nb_contracts,
            $nb_meetings,
            $first_password_change,
            $last_password_change,
            "home"
        );
    }
}