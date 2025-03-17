<?php

namespace App\Views;

use App\Views\View;

class PreferencesView extends View {
    /**
     * Public method displaying the main page of the preferences menu
     *
     * @return void
     */
    public function display(): void {
        $tab = "home";

        $this->generateCommonHeader('Préférences', [PAGES_STYLES.DS.'preferences.css']);
        $this->generateMenu(false, PREFERENCES);

        echo "<content>";
        include(MY_ITEMS.DS.'preferences.php');
        echo "</content>";

        $this->generateCommonFooter();
    }
}