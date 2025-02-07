<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Repository\CandidateRepository;

class CandidatesController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() { $this->loadView('CandidatesView'); }

    // * DISPLAY * //
    /**
     * Public method generating the candidates' main page
     *
     * @return View HTML PAGE
     */
    public function display() {
        $fetch = (new CandidateRepository())->getList();

        $candidates = array_map(function($c) {
            return [
                'Cle'      => $c->getId(),
                'Nom'      => $c->getName(),
                'Prénom'   => $c->getFirstname(),
                'Email'    => $c->getEmail(),
                'Ville'    => $c->getCity(),
                'Notation' => $c->getRating()
            ];
        }, $fetch);

        $this->View->displayCandidatesList("Liste des candidats", $candidates);
    }

    /**
     * Public method displaying the candidate's profile
     *
     * @param Int $key_candidate The candidate's primary key
     * @return View HTML PAGE
     */
    public function displayCandidate(int $key_candidate) {
        echo "Bonjour";
    }

    /**
     * Public method returning the html form of inputing a meeting
     *
     * @param Int $key_candidate The candidate's primary ket
     * @return View HTML page
     */
    public function displayInputMeetings(int $key_candidate) {
        echo "bonjour";
    }
}