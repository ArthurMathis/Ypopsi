<?php

namespace App\Views;

use App\Views\View;
use App\Models\User;
use App\Models\Role;
use App\Models\Establishment;
use App\Models\Action;

class PreferencesView extends View {
    /**
     * Public method displaying the main page of the preferences menu
     *
     * @return void
     */
    public function display(string $tab = null): void {
        $this->generateCommonHeader('Préférences', [PAGES_STYLES.DS.'preferences.css']);
        $this->generateMenu(false, PREFERENCES);

        echo "<content>";
        include(MY_ITEMS.DS.'preferences.php');
        echo "</content>";

        $this->generateCommonFooter();
    }

    /**
     * Display the user profile in the preferences menu
     *
     * @param User $user The user
     * @param Role $roleThe user's role
     * @param Establishment $establishment The user's establishment
     * @param int $nb_connexions The count of user's connections
     * @param int $nb_actions The count of user's actions
     * @param int $nb_applications The count of user's applications
     * @param int $nb_offers The count of user's offers
     * @param int $nb_contracts The count of user's contracts
     * @param int $nb_meetings The count of user's meetings
     * @param ?Action $first_log The first connection of the user
     * @param ?Action $last_log The last connection of the user
     * @param ?Action $first_password_change The first password change of the user
     * @param ?Action $last_password_change The last password change of the user
     * @param string $tab
     * @return void
     */
    public function displayProfile(
        User &$user, 
        Role &$role, 
        Establishment &$establishment, 
        int $nb_connexions,
        int $nb_actions, 
        int $nb_applications, 
        int $nb_offers, 
        int $nb_contracts, 
        int $nb_meetings,
        ?Action $first_log = null,
        ?Action $last_log = null,
        ?Action $first_password_change = null,
        ?Action $last_password_change = null,
        string $tab = "null"
    ): void {
        $this->generateCommonHeader('Préférences', [PAGES_STYLES.DS.'preferences.css']);
        $this->generateMenu(false, PREFERENCES);

        echo "<content>";
        include(MY_ITEMS.DS.'preferences.php');
        echo "<main id=\"user_profile\">";
        include(MY_ITEMS.DS.'user_profile.php');
        echo "</main>";
        echo "</content>";

        $this->generateCommonFooter();
    }

    // * DISPLAY FORM * //
    /**
     * Public function displaying the user HTML form page
     *
     * @param array $establishments_list The list of establishments
     * @param array $role_list The list of roles
     * @param ?User $user The user
     * @param ?Role $role The user's role
     * @param ?Establishment $establishment Thue user's establishment
     * @param ?string $tab
     * @return void
     */
    public function displayUserForm(
        array &$establishments_list,
        array &$role_list,
        ?User $user =  null, 
        ?Role $role = null,
        ?Establishment $establishment = null
    ): void {
        $completed = $user && $role && $establishment;

        $this->generateCommonHeader('Préférences', [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        include(FORMULAIRES.DS.'user.php');

        $this->generateCommonFooter();
    }

    // * DISPLAY INPUT * //
    /**
     * Public function displaying the input user HTML form page
     *
     * @param array $establishments_list The list of establishments
     * @param array $role_list The list of roles
     * @return void
     */
    public function displayInputUser(
        array &$establishments_list,
        array &$role_list
    ): void {
        $this->displayUserForm($establishments_list, $role_list);
    }  

    // * DISPLAY EDIT * //
    /**
     * Public function displaying the edit user HTML form page
     *
     * @param array $establishments_list The list of establishments
     * @param array $role_list The list of roles
     * @param User $user The user
     * @param Role $role The user's role
     * @param Establishment $establishment Thue user's establishment
     * @return void
     */
    public function displayEditUser(
        array &$establishments_list,
        array &$role_list,
        User $user, 
        Role $role,
        Establishment $establishment
    ): void {
        $this->displayUserForm($establishments_list, $role_list, $user, $role, $establishment);
    }
    /**
     * Public function displaying the edit password HTML form page
     *
     * @param User $user The user
     * @return void
     */
    public function displayEditPassword(User &$user): void {
        $this->generateCommonHeader('Préférences', [FORMS_STYLES.DS.'small-form.css', FORMS_STYLES.DS.'valid-input.css']);
        $this->generateMenu(true, null);

        include(FORMULAIRES.DS.'password.php');

        $this->generateCommonFooter();
    }
}