<?php

namespace App\Controllers;

define('MODELS_NAMESPACE', "App\\Models\\");
define('VIEWS_NAMESPACE', "App\\Views\\");

/**
 * Abstract class representing a controller
 * @author Arthur MATHIS - arthur.mathis@uha.fr
 */
abstract class Controller {
    /**
     * Protected attributes containing the controller's model
     */
    protected $Model;
    /**
     * Protected attributes containing the controller's view
     */
    protected $View;

    /**
     * Public method downloading the model into the controller
     * 
     * @param String $model The name of model file
     */
    public function loadModel(string $model) {
        $model = MODELS_NAMESPACE.$model;
        $this->Model = new $model();
    }
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