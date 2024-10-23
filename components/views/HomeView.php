<?php

require_once 'View.php';

/**
 * Class representing the home page view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeView extends View {
    /**
     * Public function returning the home page 
     */
    public function getContent($items=[], $dashboard=[]) {
        $this->generateCommonHeader('Ypopsi - Welcome', [PAGES_STYLES.DS.'index.css']);

        $this->generateMenu(false, false);
        echo "<content>";
        $this->getListItems("Candidatures non-traitées", $items, null, 'main-liste');
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        echo "</content>";
        
        $scripts = [
            'models/objects/Liste.js',
            'views/liste-view.js',
            'models/liste-model.js',
            'controllers/home-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
}