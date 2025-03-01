<?php 

require_once('View.php');

/**
 *  Class générant les pages du menu préférences
 */
class PreferencesView extends View {
    /**
     * Public method displaying the user's profile
     *
     * @param Array $items The array containing the user's data
     * @return View HTML Page
     */
    public function displayProfile($items=[]) {
        $this->generateCommonHeader('Ypopsi - Préférences', [PAGES_STYLES.DS.'preferences.css']);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="profil-user">';
        echo "<div class='left'>";
        include(MY_ITEMS.DS.'user_profile.php');
        echo "</div>";
        echo "<div class='right'>"; 
        $this->getBubble("Historique d'actions", $items['actions'], 10, null, null);
        $this->getBubble("Historique de connexions", $items['logs'], 6, null, null);
        echo "</div>";
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method displaying the edit password HTML form
     *
     * @return View HTML Page
     */
    public function displayEditPassword() {
        $this->generateCommonHeader('Ypopsi - Préférences', [
            PAGES_STYLES.DS.'preferences.css', 
            FORMS_STYLES.DS.'edit-user.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main>';
        include(EDIT_FORM.DS.'password.php');
        echo '</amin>';
        echo '</content>';

        $this->generateCommonFooter();
    } 
    /**
     * Public method displaying the edit user HTML form
     *
     * @return View HTML Page
     */
    public function displayEditUsers($user=[], $role=[]) {
        $this->generateCommonHeader("Mise-à-jour de l'utilisateur", [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'user.php';

        $this->generateCommonFooter();
    }

    /**
     * Public method returning the list of users HTML Page 
     *
     * @param Array $items The list of users
     * @param String $direction The redirection link to the user profile
     * @return View HTML Page
     */
    public function displayUsersContent($items=[], $direction) {
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css', 
            PAGES_STYLES.DS.'users.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="list-users">';
        include BARRES.DS.'users.php';
        $this->getListItems("Utilisateurs", $items, null, "main-liste", null, $direction);
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of new users HTML Page 
     *
     * @param Array $items The list of users
     * @param String $direction The redirection link to the user profile
     * @return View HTML Page
     */
    public function displayNewUsersContent($items=[], $direction) {
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'users.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="list-users">';
        include BARRES.DS.'users.php';
        // include BARRES.DS.'new-users.php';
        $this->getListItems("Nouveaux utilisateurs", $items, null, "main-liste", null, $direction);
        echo '</main>';
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /**
     * Public method returning the logs history HTML Page 
     *
     * @param Array<String> $items The list of connexions
     * @return View HTML Page
     */
    public function displayLogsHistoryContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'log-history.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'log-history.php';
        $this->getListItems("Historique de connexions", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the actions history HTML Page 
     *
     * @param Array<String> $items The list of connexions
     * @return View HTML Page
     */
    public function displayActionsHistoryContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'action-history.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'action-history.php';
        $this->getListItems("Historique d'actions", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of jobs HTML Page 
     *
     * @param Array<String> $items The list of jobs
     * @return View HTML Page
     */
    public function displayJobsContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste postes', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'jobs.php';
        $this->getListItems("Postes", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of qualifications HTML Page 
     *
     * @param Array<String> $items The list of qualifications
     * @return View HTML Page
     */
    public function displayQualificationsContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste postes', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'qualifications.php';
        $this->getListItems("Qualifications", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of services HTML Page 
     *
     * @param Array<String> $items The list of services
     * @return View HTML Page
     */
    public function displayServicesContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste services', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'services.php';
        $this->getListItems("Services", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/service-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of establishments HTML Page 
     *
     * @param Array<String> $items The list of establishments
     * @return View HTML Page
     */
    public function displayEstablishmentsContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste établissements', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'establishments.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'etablissements.php';
        $this->getListItems("Etablissements", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the list of poles HTML Page 
     *
     * @param Array<String> $items The list of poles
     * @return View HTML Page
     */
    public function displayPolesContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste pôles', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'poles.php';
        $this->getListItems("Pôles", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }

    /**
     * Public method displaying the users html input form
     *
     * @param Array $roles
     * @param Array $establishments
     * @return View HTML Page
     */
    public function displayInputUsers($roles=[], $establishments=[]) {
        $this->generateCommonHeader('Ypopsi - Inscription', [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'users.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method displaying the jobs input HTML form
     *
     * @return View HTML Page
     */
    public function getInputJobs() {
        $this->generateCommonHeader('Ypopsi - Inscription poste', [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'jobs.php';

        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue saisie d'un service
    public function getSaisieService($etablissements=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Inscription service', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, PREFERENCES);

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'service.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /**
     * Public method displaying the establishments HTML input form
     *
     * @param Array $poles The list of poles
     * @return View HTML Page
     */
    public function displayInputEstablishments($poles=[]) {
        $this->generateCommonHeader('Ypopsi - Inscription établissement', [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'establishments.php';

        $this->generateCommonFooter();
    }
    /// Méthode pubique retournant la vue de siasie d'un établissement
    public function displayInputPoles() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Inscription pôle', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, PREFERENCES);

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'pole.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
}