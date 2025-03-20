<?php 

namespace App\Views;

use App\Views\View;

/**
 * Class representing the applications' pages view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class ApplicationsView extends View {
    /**
     * Public method returning the application's HTML page 
     *
     * @param string $title The HTML page's title
     * @param array $items The array containing the list of applications
     * @param ?int $nb_items_max
     * @return void
     */
    public function displayApplicationsList(string $title, array $items, ?int $nb_items_max = null) {
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'applications.css']);
        $this->generateMenu(false, APPLICATIONS);

        include BARRES.DS.'applications.php';
        $this->getListItems($title, $items, $nb_items_max ? $nb_items_max : null, 'main-liste');

        // todo : ajout d'un array de critère : [ index de la colonne ; array du code couleu [ valeur de détection ; class du code couelur ] ]

        $this->generateCommonFooter();
    }
}