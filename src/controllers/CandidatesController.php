<?php

namespace App\Controllers;

use Exception;
use App\Controllers\Controller;
use App\Core\Tools\AlertsManip;
use App\Core\Tools\DataFormatManager;
use App\Core\Tools\TimeManager;
use App\Models\Action;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Contract;
use App\Models\GetQualification;
use App\Models\HaveTheRightTo;
use App\Models\Meeting;
use App\Repository\ActionRepository;
use App\Repository\ApplicationRepository;
use App\Repository\CandidateRepository;
use App\Repository\ContractRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\GetQualificationRepository;
use App\Repository\HaveTheRightToRepository;
use App\Repository\HelpRepository;
use App\Repository\JobRepository;
use App\Repository\MeetingRepository;
use App\Repository\QualificationRepository;
use App\Repository\ServiceRepository;
use App\Repository\SourceRepository;
use App\Repository\TypeOfContractsRepository;
use App\Repository\UserRepository;

/**
 * Class representing the candidate page controller
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
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
    public function display(): void {
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
    public function displayCandidate(int $key_candidate): void {
        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);                                                                // Fetching the candidate 
        
        
        $cont_repo = new ContractRepository();
        $contracts = $cont_repo->getListFromCandidates($key_candidate);                                             // Fetching the candidate's contracts
        
        
        $app_repo = new ApplicationRepository();
        $applications = $app_repo->getListFromCandidates($key_candidate, $candidate->getGender());                                           // Fetching the candidate's applications

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

    // * INPUT * //
    /**
     * Public method returning the HTML form of inputing a candidate
     *
     * @return void
     */
    public function inputCandidate(): void {
        $qualifications_list = (new QualificationRepository())->getAutoCompletion();        // Fetching the list of qualifications
        $helps_list = (new HelpRepository())->getAutoCompletion();                          // Fetching the list of helps
        $employee_list = (new CandidateRepository())->getAutoCompletion();                  // Fetching the list of employees

        $this->View->displayInputCandidate(
            $qualifications_list,
            $helps_list,
            $employee_list
        );
    }
    /**
     * Public method displaying the input contract's HTML form
     *
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function inputContract(int $key_candidate): void {
        $candidate = (new CandidateRepository())->get($key_candidate);

        $jobs_list = (new JobRepository())->getAutoCompletion($candidate->getGender() ?? true);
        $services_list = (new ServiceRepository())->getAutoCompletion();
        $establishments_list = (new EstablishmentRepository())->getAutoCompletion();
        $type_of_contracts_list = (new TypeOfContractsRepository())->getAutoCompletion();

        $this->View->displayInputContract(
            "Nouveau contrat", 
            "/candidates/contracts/inscript",
            "new_contract",
            "Nouveau contrat",
            $candidate,
            $jobs_list,
            $services_list,
            $establishments_list,
            $type_of_contracts_list
        );
    }
    /**
     * Public method returning the HTML form of inputing an offer
     * 
     * @param int $key_candidate The candidate's primary key
     * @param ?int $key_application The primary key of the application
     * @return void
     */
    public function inputOffer(int $key_candidate, ?int $key_application = null): void {
        $candidate = (new CandidateRepository())->get($key_candidate);                                          // Fetching the candidate

        $application = null;
        $job = null;
        $service = null;
        $establishment = null;
        $type_of_contract = null;
        if(!empty($key_application)) {
            $application = (new ApplicationRepository())->get($key_application);                                // Fetching the application

            $job = (new JobRepository())->get($application->getJob());                                          // Fetching the job

            if(!empty($application->getService())) {
                $service = (new ServiceRepository())->get($application->getService());                          // Fetching the service
            }

            if(!empty($application->getEstablishment())) {
                $establishment = (new EstablishmentRepository())->get($application->getEstablishment());        // Fetching the establishment
            }

            if(!empty($application->getType())) {
                $type_of_contract = (new TypeOfContractsRepository())->get($application->getType());            // Fetching the type of contract
            }
        }

        $jobs_list = (new JobRepository())->getAutoCompletion($candidate->getGender() ?? true);
        $services_list = (new ServiceRepository())->getAutoCompletion();
        $establishments_list = (new EstablishmentRepository())->getAutoCompletion();
        $type_of_contracts_list = (new TypeOfContractsRepository())->getAutoCompletion();

        $this->View->displayInputContract(
            "Nouvelle proposition", 
            "/candidates/offers/inscript",
            "new_offer",
            "Nouvelle proposition",
            $candidate,
            $jobs_list,
            $services_list,
            $establishments_list,
            $type_of_contracts_list,
            $key_application,
            $job,
            $service,
            $establishment,
            $type_of_contract
        );
    }
    /**
     * Public method returning the HTML form of inputing an application
     * 
     * @param ?int $key_candidate The candidate's primary key
     * @return void
     */
    public function inputApplication(?int $key_candidate = null): void {
        $candidate = null;
        $gender = true;
        if(!empty($key_candidate)) {                                                        // Fetching the candidate
            $candidate = (new CandidateRepository())->get($key_candidate);
            $gender = $candidate->getGender();
        }

        $jobs_list = (new JobRepository())->getAutoCompletion($gender);                     // Fetching the list of jobs

        $services_list = (new ServiceRepository())->getAutoCompletion();                    // Fetching the list of services

        $establishments_list = (new EstablishmentRepository())->getAutoCompletion();        // Fetching the list of establishments

        $type_of_contracts_list = (new TypeOfContractsRepository())->getAutoCompletion();   // Fetching the list of type of contracts

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
    public function inputMeeting(int $key_candidate): void {
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
     * Public method creating and registering a new candidate
     *
     * @return void
     */
    public function inscriptCandidate(): void {
        $_SESSION["candidate"] = Candidate::create(                                                                             // Creating the candidate
            $_POST["name"], 
            $_POST["firstname"], 
            $_POST["gender"],
            $_POST["email"],
            $_POST["phone"],
            $_POST["address"],
            $_POST["city"],
            $_POST["postcode"]
        );

        if(!empty($_POST["qualifications"]) && !empty($_POST["qualificationsDate"])) {
            if(count($_POST["qualifications"]) !== count($_POST["qualificationsDate"])) {
                throw new Exception("Une qualification doit être saisie avec sa date d'obtetion pour être enregistrée !");
            }

            $_SESSION["qualifications"] = array_map(function($qua, $date){                                                      // Creating the qualifications           
                return new GetQualification(null, $qua, $date);
            }, $_POST["qualifications"], $_POST["qualificationsDate"]);
        }

        if(!empty($_POST["helps"])) {
            $_SESSION["helps"] = array_map(function($c) {                                                                       // Creating the helps   
                return new HaveTheRightTo(null, $c, $c == 3 ? $_POST["employee"] : null);
            }, $_POST["helps"] ?? null);
        }

        header("Location: " . APP_PATH . "/candidates/applications/input");                                                     // Redirecting to the application form
    }
    /**
     * Public method registering a new contract in the database
     * 
     * @return void
     */
    public function inscriptContract(int $key_candidate): void {
        $contract = Contract::create(                                                           // Creating the offer
            $key_candidate, 
            (int) $_POST["job"],
            (int) $_POST["service"],
            (int) $_POST["establishment"],
            (int) $_POST["type_of_contrat"],
            $_POST["start_date"],
            $_POST["end_date"] ?? null,
            (int) $_POST["salary"] ?? null,
            (int) $_POST["hourly_rate"] ?? null,
            (bool) !empty($_POST["night_work"]) ?? false,
            (bool) !empty($_POST["wk_work"]) ?? false,
            TimeManager::currentTimeManager()->getDate()
        );

        (new ContractRepository())->inscript($contract);                                        // Registering the offer

        $candidate = (new CandidateRepository())->get($key_candidate);                          // Fetching the candidate

        $job = (new JobRepository())->get($contract->getJob());
        $job_titled = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Nouveau contrat");
        $desc = "Nouveau contrat pour " . $candidate->getCompleteName()
                . " au poste de " . $job_titled;

        $act = Action::create(                                                                  // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          
        $act_repo->writeLogs($act);                                                             // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La contrat a été ajouté avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method registering a new offre in the database
     * 
     * @param int $key_candidate The candidate's primary key
     * @param ?int $key_application The primary key of the application
     * @return void
     */
    public function inscriptOffer(int $key_candidate, ?int $key_application = null): void {
        if(!empty($key_application)) {
            $app_repo = new ApplicationRepository();
            $app_repo->accept($key_application);                                            // Accepting the application
        }

        $offer = Contract::create(                                                          // Creating the offer
            $key_candidate, 
            (int) $_POST["job"],
            (int) $_POST["service"],
            (int) $_POST["establishment"],
            (int) $_POST["type_of_contrat"],
            $_POST["start_date"],
            $_POST["end_date"] ?? null,
            (int) $_POST["salary"] ?? null,
            (int) $_POST["hourly_rate"] ?? null,
            (bool) !empty($_POST["night_work"]) ?? false,
            (bool) !empty($_POST["wk_work"]) ?? false
        );

        (new ContractRepository())->inscript($offer);                                       // Registering the offer

        $candidate = (new CandidateRepository())->get($key_candidate);                      // Fetching the candidate

        $job = (new JobRepository())->get($offer->getJob());
        $job_titled = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Nouvelle proposition");
        $desc = "Nouvelle proposition de contrat pour " . $candidate->getCompleteName() 
                . " au poste de " . $job_titled;

        $act = Action::create(                                                              // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'La proposition a été ajoutée avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method creating and registering a new application
     * 
     * @param ?int $key_candidate The candidate's primary key
     * @return void
     */
    public function inscriptApplication(?int $key_candidate = null): void {
        //// CANDIDATE ////
        $candidate = null;
        $can_repo = new CandidateRepository();
        switch(true) {
            // Existing candidate
            case isset($key_candidate): 
                $candidate = $can_repo->get($key_candidate);
                break;

            // New candidate
            case isset($_SESSION["candidate"]):
                $candidate = $_SESSION["candidate"];
                $candidate_id = (new CandidateRepository())->inscript($candidate);                                  // Registering the new candidate and his informations
                $candidate->setId($candidate_id); 

                if(isset($_SESSION["qualifications"])) {                                                            // Adding the qualifications to the candidate
                    $qua_repo = new GetQualificationRepository();
                    
                    foreach($_SESSION["qualifications"] as $obj) {
                        $obj->setCandidate($candidate->getId());
                        $qua_repo->inscript($obj);
                    }

                    // unset($_SESSION["qualifications"]); // todo
                }

                if(isset($_SESSION["helps"])) {                                                                     // Adding the helps to the candidate
                    $help_repo = new HaveTheRightToRepository();
                    
                    foreach($_SESSION["helps"] as $obj) {
                        $obj->setCandidate($candidate->getId());
                        $help_repo->inscript($obj);
                    }

                    // unset($_SESSION["helps"]); // todo
                }
                break;

            // Error
            default: throw new Exception("Il est impossible d'inscrire une candidature sans candidat.");
        }
        
        //// APPLICATION ////
        $application = Application::create(                                                                     // Creating the application
            candidate    : $candidate->getId(),
            job          : (int) $_POST["job"],
            source       : (int) $_POST["source"],
            type         : $_POST["type_of_contract"] ? (int) $_POST["type_of_contract"] : null,
            establishment: $_POST["establishment"] ? (int) $_POST["establishment"] : null,
            service      : $_POST["service"] ? (int) $_POST["service"] : null
        );

        (new ApplicationRepository())->inscript($application);                                                  // Registering the application

        $job = (new JobRepository())->get($application->getJob());                                              // Fetching the job
        $job = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();

        $type = $act_repo->searchType("Nouvelle candidature");
        $desc = "Nouvelle candidature de " . strtoupper($candidate->getName()) . " " 
                . DataFormatManager::nameFormat($candidate->getFirstname()) . " au poste de {$job}.";
        $action = Action::create(                                                                               // Creating the action
            $_SESSION["user"]->getId(),
            $type->getId(), 
            $desc
        );

        $act_repo->writeLogs($action);                                                                          // Registering the action

        AlertsManip::alert([
            "title" => "Action enregistrée",
            "msg" => "La candidature a été ajoutée avec succès.",
            "direction" => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method registering a new meeting in the database
     * 
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function inscriptMeeting(int $key_candidate): void {
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
                . DataFormatManager::nameFormat($candidate->getFirstname()) 
                . ", le " . date('Y m d', strtotime($meeting->getDate()));

        $act = Action::create(                                                              // Creating the action
            $_SESSION["user"]->getId(), 
            $type->getId(),
            $desc
        );          

        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Le rendez-vous a été ajouté avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }


    // * EDIT * //
    /**
     * Public method displaying the edit candidate HTML form
     *
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function editCandidate(int $key_candidate): void {
        $qualifications_list = (new QualificationRepository())->getAutoCompletion();                                // Fetching the list of qualifications
        $helps_list = (new HelpRepository())->getAutoCompletion();                                                  // Fetching the list of helps
        $employee_list = (new CandidateRepository())->getAutoCompletion();                                          // Fetching the list of employees

        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);                                                                // fetching the candidate

        $users_qualifications = null;
        $fetch_qualifications = (new QualificationRepository())->getListFromCandidate($key_candidate);              // Fetching the candidate's qualifications
        if(!empty($fetch_qualifications)) {
            $qua_repo = new getQualificationRepository();
            $users_qualifications = array_map(function($c) use ($qua_repo, $key_candidate) {
                return array(
                    "qualification"     => $c,
                    "get_qualification" => $qua_repo->get($key_candidate, $c->getId())
                );
            }, $fetch_qualifications);
        }
        
        $help_repo = new HelpRepository();
        $users_helps = $help_repo->getListfromCandidates($key_candidate);                                           // Fetching the candidate's helps
        
        $i = 0;
        $size = count($users_helps);
        $find = false;
        while(!$find && $i < $size) {
            if($users_helps[$i]->getTitled() === COOPTATION) {                                                      // Searching if there is a coopter or not
                $find = true;
            }
            $i++;
        }

        $employee = null;
        if($find) {
            $coopt_id = $help_repo->searchCoopteurId($key_candidate);                                               // fetching the coopter
            $employee = $can_repo->get($coopt_id);
        }

        $this->View->displayEditCandidate(
            $candidate,
            $users_qualifications,
            !empty($users_helps) ? $users_helps : null,
            $employee,
            $qualifications_list,
            $helps_list,
            $employee_list
        );
    }
    /**
     * Public method displaying the edit candidate's rating HTML form
     *
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function editRating(int $key_candidate): void { $this->View->displayEditRatings((new CandidateRepository())->get($key_candidate)); }
    /**
     * Public method displaying the edit meeting HTML form
     * 
     * @param int $key_meeting The primary key of the meeting
     * @return void
     */
    public function editMeeting(int $key_meeting): void {
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
     * Public method updating a candidate
     *
     * @param int $key_candidate The canddate's primary key
     * @return void
     */
    public function updateCandidate(int $key_candidate): void {
        //// CANDIDATE ////
        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);                                                        // Fetching the candidate
        
        $candidate->setName($_POST["name"]);
        $candidate->setFirstname($_POST["firstname"]);
        $candidate->setGender($_POST["gender"]);
        $candidate->setEmail($_POST["email"] ?? null);
        $candidate->setPhone($_POST["phone"] ?? null);
        
        $candidate->setAddress($_POST["address"] ?? null);
        $candidate->setCity($_POST["city"] ?? null);
        $candidate->setPostcode($_POST["postcode"] ?? null);
        
        $can_repo->update($candidate);

        //// QUALIFICATIONS ////
        $get_repo = new GetQualificationRepository();
        $qualifications = $get_repo->getListFromCandidate($key_candidate);  

        $changed = false;
        $nb_qualifications = isset($_POST["qualifications"]) ? count($_POST["qualifications"]) : 0;
        if(count($qualifications) !== $nb_qualifications) {
            $changed = true;
        } elseif(!empty($_POST["qualifications"])) {
            foreach($_POST["qualifications"] as $index => $obj) {
                if($obj !== $qualifications[$index]->getQualification()) {
                    $changed = true;
                }
            }
        }

        if($changed) {
            $changed = false;
            foreach($qualifications as $obj) {
                $id = $obj->getQualification();
                $get_repo->delete($obj);
            }

            if(isset($_POST["qualifications"])) {
                foreach($_POST["qualifications"] as $index => $obj) {
                    $get = new GetQualification($key_candidate, (int) $obj, (string) $_POST["qualificationsDate"][$index]);
                    $get_repo->inscript($get);
                }
            }
        }
        unset($qualifications);

        //// HELPS ////
        $have_repo = new HaveTheRightToRepository();
        $helps = $have_repo->getListFromcandidate($key_candidate);

        if(count($helps) !== count($_POST["helps"])) {                                                   // Checking if data have changed
            $changed = true;
        } elseif(!empty($_POST["helps"])) {
            foreach($_POST["helps"] as $index => $obj) {
                if($obj !== $helps[$index]->getHelp()) {
                    $changed = true;
                }
            }
        }

        if($changed) {                                                                                  // Updating the helps
            foreach($helps as $obj) {
                $have_repo->delete($obj);
            } 

            foreach($_POST["helps"] as $obj) {
                $help = new HaveTheRightTo($key_candidate, $obj, $obj == 3 ? $_POST["employee"] : null);
                $have_repo->inscript($help);
            }
        }

        AlertsManip::alert([
            'title' => 'Candidat Mise à jour',
            'msg' => 'Le candidat a été mis-à-jour avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method updating a candidate'"s rating
     *
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    public function updateRating(int $key_candidate): void {
        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($key_candidate);

        $candidate->setRating(max($_POST["rating"]));
        $candidate->setDescription($_POST["description"]);
        $candidate->setA(isset($_POST["a"]));
        $candidate->setB(isset($_POST["b"]));
        $candidate->setC(isset($_POST["c"]));

        $can_repo->update($candidate);

        $act_repo = new ActionRepository();                 
        $type = $act_repo->searchType("Mise à jour notation"); 
        $desc = "Mise à jour dla notation de " . $candidate->getCompleteName();

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );
        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Rendez-vous notation',
            'msg' => 'La notation a été mis-à-jour avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method updating one meeting
     * 
     * @param int $key_candidate The candidate's primary key
     * @param int $key_meeting The primary key of the meeting
     * @return void
     */
    public function updateMeeting(int $key_candidate, int $key_meeting): void {
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
        $type = $act_repo->searchType("Mise à jour rendez-vous"); 
        $desc = "Mise à jour du rendez-vous de " . $candidate->getCompleteName();

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        $act_repo->writeLogs($act);                                                         // Registering the action in logs

        AlertsManip::alert([
            'title' => 'Rendez-vous Mise à jour',
            'msg' => 'Le rendez-vous a été mis-à-jour avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }

    // * MANAGE * //
    /**
     * Public method signing a contract
     */
    public function signContract(int $key_candidate, int $key_offer): void {
        $cont_repo = new ContractRepository();
        $contract = $cont_repo->get($key_offer);                                                                // Fetching the contract
        $contract->addSignature();      

        $cont_repo->sign($contract);                                                                            // Signing the contract

        $candidate = (new CandidateRepository())->get($key_candidate);                                          // Fetching the candidate

        $job = (new JobRepository())->get($contract->getJob());                                                 // Fetching the job 
        $str_job = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Nouveau contrat"); 
        $desc = "Signature du contrat de {$candidate->getFirstname()} {$candidate->getName()} au poste de {$str_job}";

        $act = Action::create(                                                                                  // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        
        $act_repo->writeLogs($act);                                                                             // Registering the action in logs

        AlertsManip::alert([
            'title'     => 'Action enregistrée',
            'msg'       => 'La signature a été enregistrée avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method dimissins to a contract
     * 
     * @param int $key_contract The primary key of the contract
     * @return void
     */
    public function dismissContract(int $key_contract): void {$con_repo = new ContractRepository();
        $contract = $con_repo->get($key_contract);                                                              // Fetching the contract
        $contract->addResignation();

        $con_repo->dismiss($contract);                                                                          // Dismissing the contract

        $candidate = (new CandidateRepository())->get($contract->getCandidate());                               // Fetching the candidate

        $job = (new JobRepository())->get($contract->getJob());                                                 // Fetching the job 
        $str_job = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();
        $type = $act_repo->searchType("Démission"); 
        $desc = "Refus de la proposition de {$candidate->getFirstname()} {$candidate->getName()} au poste de {$str_job}";

        $act = Action::create(                                                                                  // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        
        $act_repo->writeLogs($act);                                                                             // Registering the action in logs

        AlertsManip::alert([
            'title'     => 'Action enregistrée',
            'msg'       => 'La démission a été enregistrée avec succès.',
            'direction' => APP_PATH . "/candidates/" . $candidate->getId()
        ]);
    }
    /**
     * Public method refusing an offer
     * 
     * @param int $key_candidate The candidate's primary key
     * @param int $key_offer The primary key of the offer
     * @return void
     */
    public function rejectOffer(int $key_candidate, int $key_offer): void {
        $cont_repo = new ContractRepository();
        $contract = $cont_repo->get($key_offer);                                                                // Fetching the contract
        $cont_repo->reject($contract);                                                                          // Rejecting the contract

        $candidate = (new CandidateRepository())->get($key_candidate);                                          // Fetching the candidate

        $job = (new JobRepository())->get($contract->getJob());                                                 // Fetching the job 
        $str_job = $candidate->getGender() ? $job->getTitled() : $job->getTitledFeminin();

        $act_repo = new ActionRepository();                 
        $type = $act_repo->searchType("Refus candidature"); 
        $desc = "Refus de la proposition de {$candidate->getFirstname()} {$candidate->getName()} au poste de {$str_job}";

        $act = Action::create(                                                                                  // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );          
        
        $act_repo->writeLogs($act);                                                                             // Registering the action in logs

        AlertsManip::alert([
            'title'     => 'Action enregistrée',
            'msg'       => 'La candidature a été refusée avec succès.',
            'direction' => APP_PATH . "/candidates/" . $key_candidate
        ]);
    }
    /**
     * Public method refusing an application
     * 
     * @param int $key_candidate The candidate's primary key
     * @param int $key_application The primari key of the application
     * @return void
     */
    public function rejectApplication(int $key_candidate, int $key_application): void {
        $app_repo = new ApplicationRepository();
        $application = $app_repo->get($key_application);                                                    // Fetching the application
        $app_repo->reject($application);                                                                    // Refusing the application

        $candidate = (new CandidateRepository())->get($key_candidate);                                      // Fetching the candidate

        $job = (new JobRepository())->get($application->getJob());                                          // Fetching the job 
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

        AlertsManip::alert([
            'title'     => 'Action enregistrée',
            'msg'       => 'La candidature a été refusée avec succès.',
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
    public function deleteMeeting(int $key_meeting): void {
        $meet_repo = new MeetingRepository();
        $meeting = $meet_repo->get($key_meeting);                                           // Fetching the meeting

        $can_repo = new CandidateRepository();
        $candidate = $can_repo->get($meeting->getCandidate());                              // Fetching the candidate 
        $meet_repo->delete($meeting);                                                       // Deleting the meeting

        $act_repo = new ActionRepository();                 
        $type = $act_repo->searchType("Annulation rendez-vous"); 
        $desc = strtoupper($candidate->getName()) . " " 
                . DataFormatManager::nameFormat($candidate->getFirstname()) 
                . " a annulé son rendez-vous du " 
                . date('Y m d', strtotime($meeting->getDate()));

        $act = Action::create(                                                              // Creating the action
            $_SESSION['user']->getId(), 
            $type->getId(),
            $desc
        );             

        $act_repo->writeLogs($act);                                                         // Writing logs

        AlertsManip::alert([
            'title' => 'Action enregistrée',
            'msg' => 'Vous avez annulé le rendez-vous.',
            'direction' => APP_PATH . "/candidates/" . $candidate->getId()
        ]);
    }
}