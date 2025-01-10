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
     * @return Void
     */
    public function getContent() {
        $this->generateCommonHeader(
            'Ypopsi - Connexion', 
            [
                FORMS_STYLES.DS.'small-form.css',
                FORMS_STYLES.DS.'connexion.css'
            ]
        );

        include FORMULAIRES.DS.'connexion.php';

        $this->generateCommonFooter();
    }
}