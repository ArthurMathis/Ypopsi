<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Action;
use App\Repository\ApplicationRepository;
use App\Repository\CandidateRepository;
use App\Repository\ContractRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\MeetingRepository;
use App\Repository\QualificationRepository;
use App\Repository\HelpRepository;
use App\Repository\UserRepository;
use App\Repository\ActionRepository;

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
        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);


        $cont_repo = new ContractRepository();
        $contracts = $cont_repo->getListFromCandidates($key_candidate);


        $app_repo = new ApplicationRepository();
        $applications = $app_repo->getListFromCandidates($key_candidate);


        $meet_repo = new MeetingRepository();
        $meetings = $meet_repo->getListFromCandidate($key_candidate);


        $qua_repo = new QualificationRepository();
        $fetch_qualifications = $qua_repo->getListFromCandidate($key_candidate);

        $qualifications = array_map(function($c) use ($qua_repo, $key_candidate) {
            $date = $qua_repo->searchdate($key_candidate, $c->getId());
    
            return [
                "qualification" => $c,
                "date"          => $date
            ];
        }, $fetch_qualifications);


        $help_repo = new HelpRepository();
        $helps = $help_repo->getListfromCandidates($key_candidate);

        $i = 0;
        $size = count($helps);
        $find = false;
        while(!$find && $i < $size) {
            if($helps[$i]->getTitled() === COOPTATION) {
                $find = true;
            }

            $i++;
        }

        $coopteur = null;
        if($find) {
            $coopt_id = $help_repo->searchCoopteurId($key_candidate)['Id'];
            $coopteur = $can_repo->get($coopt_id);
        }

        $this->View->displayCandidateProfile(
            "Candidat " . $candidate->getName() . ' ' . $candidate->getFirstname(), 
            $candidate, 
            $applications, 
            $contracts,
            $meetings, 
            $qualifications,
            $helps, 
            $coopteur
        );
    }

    //// DISPLAY INPUT ////
    /**
     * Public method returning the html form of inputing a meeting
     *
     * @param Int $key_candidate The candidate's primary ket
     * @return View HTML page
     */
    public function displayInputMeeting(int $key_candidate) {
        $user_repo = new UserRepository();
        $users = $user_repo->getAutoCompletion();
    
        $esta_repo = new EstablishmentRepository();
        $user_establishment = $esta_repo->get($_SESSION['user']->getEstablishment());
    
        $establishments = $esta_repo->getAutoCompletion();
    
        $this->View->displayInputMeetings(
            "Nouveau rendez-vous",
            $key_candidate,
            $user_establishment->getTitled(),
            $users,
            $establishments
        );
    }

    // * INSCRIPT * //
    /**
     * Public method registering a new meeting in the database
     * 
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function inscriptMeeting(int $key_candidate) {
        isUserOrMore();                                                                     // Verifying the user's role

        $meeting = new Meeting(                                                             // Creating the meeting
            null, 
            $_POST['date'] . " " . $_POST['time'], 
            null, 
            (int) $_POST['recruteur'], 
            $key_candidate, 
            (int) $_POST['etablissement']
        );

        (new MeetingRepository())->inscript($meeting);                                      // Registering in database

        $act_repo = new ActionRepository();                 
        
        $type = $act_repo->searchType("Nouveau rendez-vous")['Id']; 


        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type
        );             

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        header("Location: " . APP_PATH . "/candidates/" . $key_candidate);
    }
}