<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\ApplicationRepository;
use App\Repository\ContractRepository;
use App\Repository\MeetingRepository;

/**
 * Class representing the home page controller
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeController extends Controller {
    /**
     *  Class constructor
     */
    public function __construct() { $this->loadView('HomeView'); }

    /**
     *  Public function returning the home page 
     * @return Void
     */
    public function display() {
        $items = (new ApplicationRepository())->getNonTraiteeList();

        $dashboard = [
            [
                'titre' => 'Propositions en Attente', 
                'content' => (new ContractRepository())->getReductProposition(), 
                'nb_item_max' => 6,
                'link_add' => null,
                'link_consult' => null
            ],
            [
                'titre' => 'Rendez-vous programmés', 
                'content' => (new MeetingRepository())->getReductList(), 
                'nb_item_max' => 6,
                'link_add' => null,
                'link_consult' => null
            ]
        ];
        
        return $this->View->displayHomePage($items, $dashboard);
    }
}