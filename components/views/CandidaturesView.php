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
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css', PAGES_STYLES.DS.'applications.css']);
        $this->generateMenu(false, APPLICATIONS);

        include BARRES.DS.'applications.php';
        $this->getListItems($title, $items, $nb_items_max, 'main-liste');

        $this->generateCommonFooter();
    }

    /**
     * Public method returning the candidate's HTML form
     *
     * @param String $title The HTML page title
     * @param Array<String> $diplome The list of qualifications
     * @param Array<String> $aide The list of helps
     * @param Array<String> $employer The list of employees
     * @return void
     */
    public function displayInputCandidatesContent($title, $diplome=[], $aide=[], $employer=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'candidates.php';

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
     * @return View HTML Page
     */
    public function displayInputApplicationsContent($title, $job=[], $service=[], $establishment=[], $typeOfContract=[], $source=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'applications.php';

        $this->generateCommonFooter();
    }
}