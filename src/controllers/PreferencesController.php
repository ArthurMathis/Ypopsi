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
        $first_log = $act_repo->getUserFirstConnection($user);
        $last_log = $act_repo->getUserLastConnection($user);

        $this->View->displayProfile(
            $user,
            $role,
            $establishment, 
            $first_log,
            $last_log,
            "home"
        );
    }
}