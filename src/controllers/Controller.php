<?php

namespace App\Controllers;

define('VIEWS_NAMESPACE', "App\\Views\\");

/**
 * Abstract class representing a controller
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
abstract class Controller {
    /**
     * Protected attributes containing the controller's view
     */
    protected $View;
    
    /**
     * Public method downloading the view into the controller
     * 
     * @param $view The name of view file
     */
    public function loadView(string $view) {
        $view = VIEWS_NAMESPACE.$view;
        $this->View = new $view();
    }
}