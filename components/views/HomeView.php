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
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Welcome', [PAGES_STYLES.DS.'index.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(false, false);
        // On ajoute le contenu de la page
        echo "<content>";
        $this->getListesItems("Candidatures non-traitées", $items, null, 'main-liste');
        echo "<aside>";
        $this->getDashboard($dashboard);
        echo "</aside>";
        echo "</content>";
        
        // On importe les scripts JavaScript
        $scripts = [
            'models/objects/Liste.js',
            'views/liste-view.js',
            'models/liste-model.js',
            'controllers/home-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
}