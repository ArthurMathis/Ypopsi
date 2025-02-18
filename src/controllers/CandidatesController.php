<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Action;
use App\Core\AlertsManipulation;
use App\Core\FormsManip;
use App\Repository\ApplicationRepository;
use App\Repository\CandidateRepository;
use App\Repository\ContractRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\MeetingRepository;
use App\Repository\QualificationRepository;
use App\Repository\HelpRepository;
use App\Repository\UserRepository;
use App\Repository\ActionRepository;
use App\Repository\JobRepository;
use App\Repository\ServiceRepository;
use App\Repository\SourceRepository;
use App\Repository\TypeOfContractsRepository;

class CandidatesController extends Controller {
    /**
     * Constructor class
     */
    public function __construct() { $this->loadView('CandidatesView'); }

    // * DISPLAY * //
    /**
     * Public method generating the candidates' main page
     *
     * @return void
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
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function displayCandidate(int $key_candidate) {
        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);                                                                // Fetching the candidate 


        $cont_repo = new ContractRepository();
        $contracts = $cont_repo->getListFromCandidates($key_candidate);                                             // Fetching the candidate's contracts


        $app_repo = new ApplicationRepository();
        $applications = $app_repo->getListFromCandidates($key_candidate);                                           // Fetching the candidate's applications


        $meet_repo = new MeetingRepository();
        $meetings = $meet_repo->getListFromCandidate($key_candidate);                                               // Fetching the candidate's meetings


        $qua_repo = new QualificationRepository();
        $fetch_qualifications = $qua_repo->getListFromCandidate($key_candidate);                                    // Fetching the candidate's qualifications

        $qualifications = array_map(function($c) use ($qua_repo, $key_candidate) {
            $date = $qua_repo->searchdate($key_candidate, $c->getId());
    
            return [
                "qualification" => $c,
                "date"          => $date
            ];
        }, $fetch_qualifications);


        $help_repo = new HelpRepository();
        $helps = $help_repo->getListfromCandidates($key_candidate);                                                 // Fetching the candidate's helps

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
            $coopt_id = $help_repo->searchCoopteurId($key_candidate);
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


    // * ACCEPT * //
    public function acceptApplication(int $key_candidate, int $key_application) {

    }

    /**
     * Public method refusing an application
     * 
     * @param int $key_candidate The candidate's primary key
     * @param int $key_application The primari key of the application
     * @return void
     */
    public function rejectApplication(int $key_candidate, int $key_application) {
        $app_repo = new ApplicationRepository();

        $application = $app_repo->get($key_application);                                                    // Fetching the application

        $app_repo->reject($key_application);                                                                // Refusing the application


        $candidate = (new CandidateRepository())->get($key_candidate);                                      // Fetching the candidate


        $job = (new JobRepository())->get($application["Key_Jobs"]);                                        // Fetching the job 

        $str_job = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();


        $act_repo = new ActionRepository();                 
        
        $type = $act_repo->searchType("Refus candidature"); 

        $desc = "Refus de la candidature de {$candidate->getFirstname()} {$candidate->getName()} au poste de {$str_job}";

        $act = Action::create(                                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        

        $act_repo->writeLogs($act);                                                                         // Registering the action in logs

        AlertsManipulation::alert([
            'title'     => 'Action enregistrée',
            'msg'       => 'La candidature a été refusée avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }



    // * INPUT * //
    /**
     * Public method returning the HTML form of inputing an application
     * 
     * @param ?int $key_candidate The candidate's primary key
     * @return void
     */
    public function inputApplication(?int $key_candidate = null) {
        isUserOrMore();                                                                     // Verifying the user's role


        if(!empty($key_candidate)) {                                                        // Fetching the candidate
            $candidate = (new CandidateRepository())->get($key_candidate);
        }


        $jobs_list = (new JobRepository())->getAutoCompletion($candidate->getGender() ?? true);

        $services_list = (new ServiceRepository())->getAutoCompletion();

        $establishments_list = (new EstablishmentRepository())->getAutoCompletion();

        $type_of_contracts_list = (new TypeOfContractsRepository())->getAutoCompletion();

        $sources_list = (new SourceRepository())->getAutoCompletion();


        $this->View->displayInputApplication(
            "Nouvelle candidature", 
            $candidate, 
            $jobs_list, 
            $services_list,
            $establishments_list, 
            $type_of_contracts_list,
            $sources_list
        );
    }
    /**
     * Public method returning the HTML form of inputing a meeting
     *
     * @param int $key_candidate The candidate's primary ket
     * @return void
     */
    public function inputMeeting(int $key_candidate) {
        isUserOrMore();                                                                     // Verifying the user's role


        $recruiter = $_SESSION['user'];                                                     // Getting the recruiter

        $users_list = (new UserRepository())->getAutoCompletion();                          // Fetching the list of users

    
        $esta_repo = new EstablishmentRepository();

        $establishment = $esta_repo->get($recruiter->getEstablishment());                   // Fetching the establishment
    
        $establishments_list = $esta_repo->getAutoCompletion();                             // Fetching the list of establishments
    
    
        $this->View->displayInputMeeting(
            $key_candidate, 
            $recruiter, 
            $establishment, 
            $users_list, 
            $establishments_list
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


        $can_repo = new CandidateRepository();

        $candidate = $can_repo->get($key_candidate);                                        // Fetching the candidate 


        $meeting = Meeting::create(                                                         // Creating the meeting
            $_POST['date'] . " " . $_POST['time'], 
            (int) $_POST['recruiter'], 
            $key_candidate, 
            (int) $_POST['establishment'],
            $_POST['description']
        );

        (new MeetingRepository())->inscript($meeting);                                      // Registering in database


        $act_repo = new ActionRepository();                 
        
        $type = $act_repo->searchType("Nouveau rendez-vous"); 

        $desc = "Nouveau rendez-vous avec " 
                . strtoupper($candidate->getName()) . " " 
                . FormsManip::nameFormat($candidate->getFirstname()) 
                . ", le " . date('Y m d', strtotime($meeting->getDate()));

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le rendez-vous a été ajouté avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }


    // * EDIT * //
    /**
     * Public method displaying the edit meeting HTML form
     * 
     * @param int $key_meeting The primary key of the meeting
     * @return void
     */
    public function editMeeting(int $key_meeting) {
        isUserOrMore();                                                                     // Verifying the user's role


        $meeting = (new MeetingRepository())->get($key_meeting);                            // Fetching the meeting


        $user_repo = new UserRepository();
        
        $recruiter = $user_repo->get($meeting->getUser());                                  // Fetching the recruiter
        
        $users_list = $user_repo->getAutoCompletion();                                      // Fetching the list of users
        
        
        $esta_repo = new EstablishmentRepository();
        
        $establishment = $esta_repo->get($meeting->getEstablishment());                     // Fetching the establishment
        
        $establishments_list = $esta_repo->getAutoCompletion();                             // Fetching the list of establishements


        $this->View->displayEditMeeting(
            $meeting, 
            $recruiter, 
            $establishment, 
            $users_list, 
            $establishments_list
        );
    }


    // * UPDATE * //
    /**
     * Public method updating one meeting
     * 
     * @param int $key_candidate The candidate's primary key
     * @param int $key_meeting The primary key of the meeting
     * @return void
     */
    public function updateMeeting(int $key_candidate, int $key_meeting) {
        isUserOrMore();                                                                     // Verifying the user's role


        $meeting = new Meeting(                                                             // Building the meeting
            $key_meeting,
            $_POST['date'] . " " . $_POST['time'], 
            $_POST['description'] ?? null,
            (int) $_POST['recruiter'], 
            $key_candidate, 
            (int) $_POST['establishment']
        );

        (new MeetingRepository())->update($meeting);                                        // Registering in database


        $candidate = (new CandidateRepository())->get($key_candidate);                      // Fetching the candidate 


        $act_repo = new ActionRepository();                 
        
        $type = $act_repo->searchType("Mise-à-jour rendez-vous"); 

        $desc = "Mise-à-jour du rendez-vous de " 
                . strtoupper($candidate->getName()) . " " 
                . FormsManip::nameFormat($candidate->getFirstname());

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManipulation::alert([
            'title' => 'Rendez-vous mise-à-jour',
            'msg' => 'Le rendez-vous a été mis-à-jour avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }


    // * DELETE * //
    /**
     * Public method deleting a meeting from the database
     * 
     * @param int $key_meeting The primary key of the meeting
     * @return void
     */
    public function deleteMeeting(int $key_meeting) {
        isUserOrMore();                                                                     // Verifying the user's role


        $meet_repo = new MeetingRepository();

        $meeting = $meet_repo->get($key_meeting);                                           // Fetching the meeting


        $can_repo = new CandidateRepository();

        $candidate = $can_repo->get($meeting->getCandidate());                              // Fetching the candidate 

        $meet_repo->delete($meeting);                                                       // Deleting the meeting


        $act_repo = new ActionRepository();                 
        
        $type = $act_repo->searchType("Annulation rendez-vous"); 

        $desc = strtoupper($candidate->getName()) . " " 
                . FormsManip::nameFormat($candidate->getFirstname()) 
                . " a annulé son rendez-vous du " 
                . date('Y m d', strtotime($meeting->getDate()));

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );             


        $act_repo->writeLogs($act);                                                         // Writing logs

        AlertsManipulation::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Vous avez annulé le rendez-vous.',
            'direction' => APP_PATH . "/candidates/" . $candidate->getId()
        ]);
    }
}