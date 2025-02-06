<?php

namespace App\Controllers;

use App\Controllers\Controller;

/**
 *  Class representing the home page controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeController extends Controller {
    /**
     *  Class constructor
     */
    public function __construct() {
        $this->loadView('HomeView');
    }

    /**
     *  Public function returning the home page 
     * @return Void
     */
    public function display() {
        var_dump($_SESSION['user']); exit;

        // $items = (new )->getNonTraiteeCandidatures();
        // $dashboard = [
        //     [
        //         'titre' => 'Propositions en Attente', 
        //         'content' => $this->Model->getReductProposition(), 
        //         'nb_item_max' => 6,
        //         'link_add' => null,
        //         'link_consult' => null
        //     ],
        //     [
        //         'titre' => 'Rendez-vous programmés', 
        //         'content' => $this->Model->getReductRendezVous(), 
        //         'nb_item_max' => 6,
        //         'link_add' => null,
        //         'link_consult' => null
        //     ]
        // ];
        // 
        // return $this->View->displayHomePage($items, $dashboard);
    }
}