<?php

namespace App\Views;

use App\Views\View;

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
        $this->generateCommonHeader(
            'Connexion', 
            [
                FORMS_STYLES.DS.'small-form.css',
                FORMS_STYLES.DS.'connexion.css'
            ]
        );

        include FORMULAIRES.DS.'login.php';

        $this->generateCommonFooter();
    }
}