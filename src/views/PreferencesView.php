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

    public function displayProfile(
        User &$user, 
        Role &$role, 
        Establishment &$establishment, 
        Action $first_log,
        Action $last_log,
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
}