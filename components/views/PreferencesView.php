<?php 

require_once('View.php');

/**
 *  Class générant les pages du menu préférences
 */
class PreferencesView extends View {
    /// Méthode publique retournant la page principale du menu préférences
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
        $this->getProfil($items);
        $this->getUtilisateurHistorique($items);
        echo '</main>';
        echo '</content>';

        $this->generateCommonFooter();
    }
    /// Méthode privée retournant leprofil de l'utilisateur
    private function getProfil(&$items=[]) {
        echo "<div class='left'>";
        include(MY_ITEMS.DS.'user_profile.php');
        echo "</div>";
    }
    /// Méthode privée retournant la page d'historique d'un utilisateur
    private function getUtilisateurHistorique(&$items=[]) {
        echo "<div class='right'>"; 
        $this->getBubble("Historique d'actions", $items['actions'], 8, null, null);
        $this->getBubble("Historique de connexions", $items['connexions'], 4, null, null);
        echo "</div>";
    }
    /// Méthod epublique retournant la page de modification du mot de passe
    public function getEditpassword() {
        $this->generateCommonHeader('Ypopsi - Préférences', [
            PAGES_STYLES.DS.'preferences.css', 
            FORMS_STYLES.DS.'edit-user.css'
        ]);
        $this->generateMenu(true, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main>';
        include(EDIT_FORM.DS.'mot-de-passe.php');
        echo '</amin>';
        echo '</content>';

        $this->generateCommonFooter();
    } 
    public function getEditUtilisateur($user=[], $role=[]) {
        $this->generateCommonHeader("Mise-à-jour de l'utilisateur", [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, PREFERENCES);

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

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
            PAGES_STYLES.DS.'utilisateurs.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="liste-utilisateurs">';
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
            PAGES_STYLES.DS.'utilisateurs.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="liste-utilisateurs">';
        include BARRES.DS.'users.php';
        // include BARRES.DS.'new-users.php';
        $this->getListItems("Nouveaux utilisateurs", $items, null, "main-liste", null, $direction);
        echo '</main>';
        echo '</content>';

        // On ajoute le pied de page  
        $this->generateCommonFooter();
    }
    /**
     * Public method returning thelogs history HTML Page 
     *
     * @param Array $items The list of connexions
     * @return View HTML Page
     */
    public function getConnexionHistoriqueContent($items=[]) {
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
    /// Méthode publique retournant la vue Historique d'actions
    public function getActionHistoriqueContent($items) {
        $this->generateCommonHeader('Ypopsi - Liste utilisateurs', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'action-historique.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'action-historique.php';
        $this->getListItems("Historique d'actions", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/action-historique-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des postes
    public function getPostesContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste postes', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'postes.php';
        $this->getListItems("Postes", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/poste-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la liste des services
    public function getServicesContent($items=[]) {
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
    /// Méthode publique retournant la liste des établissements
    public function getEtablissementsContent($items=[]) {
        $this->generateCommonHeader('Ypopsi - Liste établissements', [
            PAGES_STYLES.DS.'preferences.css', 
            PAGES_STYLES.DS.'liste-page.css',
            PAGES_STYLES.DS.'etablissements.css'
        ]);
        $this->generateMenu(false, PREFERENCES);

        echo '<content>';
        include(MY_ITEMS.DS.'preferences.php');
        echo '<main id="historique">';
        include BARRES.DS.'etablissements.php';
        $this->getListItems("Etablissements", $items, null, "main-liste");
        echo '</main>';
        echo '</content>';

        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/etablissement-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }
    public function getPolesContent($items=[]) {
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

        $scripts = [
            'views/liste-view.js',
            'models/liste-model.js',
            'models/objects/Liste.js',
            'controllers/pole-controller.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        $this->generateCommonFooter();
    }

    /// Méthode publique retournant la vue saisie utilisateur
    public function getSaisieUtilisateur($role, $etablissements=[]) {
        $this->generateCommonHeader('Ypopsi - Inscription', [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, PREFERENCES);

        $scripts = [
            'models/objects/AutoComplet.js'
        ];
        include(COMMON.DS.'import-scripts.php');

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'utilisateur.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode publique retournant la vue saisie d'une poste
    public function getSaisiePoste() {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Inscription poste', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, PREFERENCES);

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'poste.php';

        // On ajoute le pied de page
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
    /// Méthode pubique retournant la vue de siasise d'un établissement
    public function getSaisieEtablissement($poles=[]) {
        // On ajoute l'entete de page
        $this->generateCommonHeader('Ypopsi - Inscription établissement', [FORMS_STYLES.DS.'small-form.css']);

        // On ajoute la barre de navigation
        $this->generateMenu(true, PREFERENCES);

        // On ajoute le formulaire de'inscription
        include INSCRIPT_FORM.DS.'etablissements.php';

        // On ajoute le pied de page
        $this->generateCommonFooter();
    }
    /// Méthode pubique retournant la vue de siasie d'un établissement
    public function getSaisiePole() {
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