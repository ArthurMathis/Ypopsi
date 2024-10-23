<?php

require_once 'View.php';

/**
 * Class representing the login view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginView extends View {
    /**
     * Public method returning the login form
     *
     * @return void
     */
    public function getContent() {
        $this->generateCommonHeader('Ypopsi - Connexion', [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, false, false);

        include FORMULAIRES.DS.'connexion.php';
        include FORMULAIRES.DS.'waves.php';

        $this->generateCommonFooter();
    }
}