<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\ApplicationRepository;

/**
 * Class representing the applications page controller
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ApplicationsController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() { $this->loadView('ApplicationsView'); }


    // * DISPLAY * //
    /**
     * Public method generating the applications' main page
     *
     * @return void
     */
    public function display() { 
        $applications = (new ApplicationRepository())->getList();

        $this->View->displayApplicationsList("Liste des candidatures", $applications);
    }
}