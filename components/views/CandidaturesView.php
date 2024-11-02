<?php

require_once 'View.php';

/**
 * Class representing the applications' views
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidaturesView extends View {
    /**
     * Public method returning the application's HTML page 
     *
     * @param String $title The HTML page's title
     * @param Array $items The array containing the list of applications
     * @param Int $nb_items_max
     * @return View HTML Page
     */
    public function getContent($title, $items = [], $nb_items_max=null) {
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'candidatures.css']);
        $this->generateMenu();

        include BARRES.DS.'candidatures.php';
        $this->getListItems($title, $items, $nb_items_max, 'main-liste');

        $scripts = ['controllers/applications.mjs'];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }

    /// Méthode publique retournant le formulaire de saisie d'un candidat
    public function getInputCandidatesContent($title, $diplome=[], $aide=[], $employer=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu();

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        include INSCRIPT_FORM.DS.'candidates.php';
        include FORMULAIRES.DS.'waves.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method generating and returning the application's HTML form
     * 
     * @param String $title The HTML page's title
     * @param Array $job The array containing the list of jobs
     * @param Array $establishment The array containing the list of establishments
     * @param Array $typeOfContract The array containing the list of types of contracts
     * @param Array $source The array containing the list of sources
     * @return View - HTML Page
     */
    public function displayInputApplicationsContent($title, $job=[], $service=[], $establishment=[], $typeOfContract=[], $source=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu();

        include INSCRIPT_FORM.DS.'applications.php';
        include FORMULAIRES.DS.'waves.php';

        $this->generateCommonFooter();
    }
}