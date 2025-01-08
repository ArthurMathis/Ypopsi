<?php

require_once 'View.php';

/**
 * Class representing the home page view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeView extends View {
    /**
     * Public function returning the home page 
     * 
     * @param Array $items The array containing the applications data 
     * @param Array $dashboard The array containing the dashboard data 
     * @return Void
     */
    public function displayHomePage(array $items, array $dashboard) {
        $this->generateCommonHeader('Ypopsi - Welcome', [PAGES_STYLES.DS.'index.css']);
        $this->generateMenu(false, HOME);

        echo "<content>";
        $this->getListItems("Candidatures non-traitées", $items, null, 'main-liste');
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        echo "</content>";

        $scripts = ['home-controller.mjs'];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
}