<?php

namespace App\Views;

use App\Views\View;
use App\Core\FormsManip;
use App\Models\Candidate;
use App\Models\Establishment;
use App\Models\Meeting;
use App\Models\User;

/**
 * Class representing the candidates' pages view
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidatesView extends View {
    // * DISPLAY * //
    /**
     * Public method returning the candidates list
     * 
     * @param string $titre The HTML Page titled
     * @param array $items The array containing the candidates' data
     * @return View The HTML Page
     */
    public function displayCandidatesList(string $titre, array $items) {
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css']);
        $this->generateMenu(false, APPLICATIONS);
        include BARRES.DS.'candidates.php';

        $this->getListItems($titre, $items, null, 'main-liste');

        $this->generateCommonFooter();
    }
    /**
     * Public method generating the candidte's profil page dashboards 
     *
     * @param string $title The title og the page
     * @param Candidate $candidate The candidate
     * @param array $applications The array containing the candidate's applications
     * @param ?array $contracts The array containing the candidate's contracts and job offers
     * @param ?array $meetings The array containing the candidate's meetings
     * @param ?array $qualifications The array containing the candidate's qualifications
     * @param ?array $helps The array containing the candidate's helps
     * @param ?Candidate $coopteur The employee that recommanded the candidate
     * @return View The HTML Page
     */
    public function displayCandidateProfile(string $title, Candidate $candidate, array $applications, ?array $contracts = null, ?array $meetings = null, ?array $qualifications = null, ?array $helps = null, ?Candidate $coopteur = null){
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);
        $this->generateMenu(false, NULL);

        $buttons = ['Tableau de bord', 'Contrats', 'Propositions', 'Candidatures', 'Rendez-vous'] ;

        echo "<content>";

        include(MY_ITEMS.DS.'candidate_profile.php');

        echo "<main>";

        include(BARRES.DS.'candidate_profile.php');
        $this->getDashboard($candidate, $applications, $contracts, $meetings, $qualifications, $helps, $coopteur);
        $this->getContractsBoard($candidate->getId(), $contracts);
        $this->getOffersBoard($candidate->getId(), $contracts);
        $this->getApplicationsBoard($candidate->getId(), $applications);
        $this->getMeetingsBoard($candidate->getId(), $meetings);

        echo "</main>";
        
        echo "</content>";

        $this->generateCommonFooter();
    }


    // * DISPLAY FORM * //
    /**
     * Public function displaying the meeting HTML form
     * 
     * @param string $title The method of the HTML form
     * @param string $action_method The method of the HTML form
     * @param string $action_value The value of the HTML form
     * @param bool $editable Boolean indicating if the pieces of information in the HTML form can be edited or not
     * @param ?Meeting $meeting The meeting
     * @param User $recruiter The user in charge of this recruitement
     * @param Establishment $establishment The establishment 
     * @param array $users_list The list of users for AutoComplet
     * @param array establishments_list The list of establishments for AutoComplet
     * @return void
     */
    public function displayMeetingForm(string $title, string $action_method, string $action_value, bool $editable, ?Meeting $meeting, User $recruiter, Establishment $establishment, array $users_list, array $establishments_list) {
        $this->generateCommonHeader("Ypopsi - {$title}", [ FORMS_STYLES.DS.'big-form.css' ]);

        $this->generateMenu(true, null);

        include FORMULAIRES.DS.'meeting.php';

        $this->generateCommonFooter();
    }

    // * DISPLAY INPUT * //
    /**
     * 
     */
    public function displayInputApplication(string $title, ?Candidate $candidate, array $jobs_list, array $services_list, array $establishments_list, array $type_of_contracts_list, array $sources_list) {
        $this->generateCommonHeader("Ypopsi - {$title}", [ FORMS_STYLES.DS.'big-form.css' ]);

        $this->generateMenu(true, null);

        include FORMULAIRES.DS.'application.php';

        $this->generateCommonFooter();
    }
    /**
     * Public function Returning the offers' html form 
     *
     * @param string $title The HTML Page title
     * @param int $key_candidate The candidate's primary key
     * @param array $jobs The array containing the jobs list
     * @param array $services The array containing the services list
     * @param array $establishments The array containing the establishments list
     * @param array $types_of_contracts The array containing the tupes of contracts list
     * @param ?array $offer The array containing the offer's data (if it is existing)
     * @return View The HTML Page
     */
    public function displayInputOffers(string $title, int $key_candidate, array $jobs, array $services, array $establishments, array $types_of_contracts, ?array $offer = null) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);
        
        include INSCRIPT_FORM.DS.'offer.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the HTML form to register an contract
     *
     * @param string $title The HTML page's title
     * @param int $key_candidate The candidate's primary key
     * @param array $jobs The array containing the list of jobs
     * @param array $services The array containing the list of services
     * @param array $establishments The array containing the list of establishments
     * @param array $types_of_contrats The array containing the list of types of contractss
     * @return View The HTML Page
     */
    public function displayInputContracts(string $title, int $key_candidate, array $jobs, array $services, array $establishments, array $types_of_contrats) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'contracts.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the meeting's HTML form
     *
     * @param Meeting $meeting The meeting
     * @param User recruiter The user in charge of the recruitement
     * @param Establishment $establishment The establishment 
     * @param array $users_list The array containing the list of users
     * @param array $establisments_list The array containing the list of establisments
     * @return void
     */
    public function displayInputMeeting(int $key_candidate, User $recruiter, Establishment $establishment, array $users_list, array $establishments_list) {
        $title = "Inscription d'un rendez-vous";

        $action_method = "inscript/{$key_candidate}";

        $action_value = "inscript_meeting";

        $editable = true;

        $this->displayMeetingForm(
            $title, 
            $action_method, 
            $action_value, 
            $editable, 
            null,
            $recruiter,
            $establishment,
            $users_list, 
            $establishments_list
        );
    }

    // * DISPLAY EDIT * //
    /**
     * Public method building the edit candidates'ratings HTML form 
     *
     * @param array $candidate The arrayu containing the candidate's data
     * @return View The HTML page
     */
    public function displayEditRatings(array $candidate) {
        $this->generateCommonHeader(
            'Ypopsi - Modification de la notation de ' . FormsManip::majusculeFormat($candidate['Name']) . ' ' . $candidate['Firstname'], 
            [FORMS_STYLES.DS.'small-form.css', FORMS_STYLES.DS.'edit-rating.css']
        );
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'rating.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method building the edit candidates HTML form 
     *
     * @param array $item The array containing the candidate's data
     * @param array $qualifications The array containing the list of qualifications
     * @param array $helps The array containing the list of helps
     * @param array $employee The array containing the the list of employee
     * @return View The HTML Page
     */
    public function displayEditCandidates(array $item, array $qualifications, array $helps, array $employee) {
        $this->generateCommonHeader('Ypopsi - Modification de ' . FormsManip::majusculeFormat($item['candidate']['Name']) . ' ' . $item['candidate']['Firstname'], [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'candidates.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method building the edit meetings HTML form 
     *
     * @param Meeting $meeting The meeting
     * @param User recruiter The user in charge of the recruitement
     * @param Establishment $establishment The establishment 
     * @param array $users_list The array containing the list of users
     * @param array $establisments_list The array containing the list of establisments
     * @return void
     */
    public function displayEditMeeting(Meeting $meeting, User $recruiter, Establishment $establishment, array $users_list, array $establishments_list) {
        $title = "Mise-à-jour rendez-vous";

        $action_method = "update/{$meeting->getCandidate()}/{$meeting->getId()}";

        $action_value = "update_meeting";

        $editable = time() <= strtotime($meeting->getDate());


        $this->displayMeetingForm(
            $title, 
            $action_method, 
            $action_value, 
            $editable, 
            $meeting,
            $recruiter,
            $establishment,
            $users_list, 
            $establishments_list
        );
    }

    // * GET * //
    /**
     * Public method generatiing one candidate's profil dashbord 
     * 
     * @param Candidate $candidate The candidate
     * @param array $applications The array containing the candidate's applications
     * @param ?array $contracts The array containing the candidate's contracts and job offers
     * @param ?array $meetings The array containing the candidate's meetings
     * @param ?array $qualifications The array containing the candidate's qualifications
     * @param ?array $helps The array containing the candidate's helps
     * @param ?Candidate $coopteur The employee that recommanded the candidate
     * @return View The HTML Page
     */
    public function getDashboard(Candidate $candidate, array $applications, ?array $contracts, ?array $meetings, ?array $qualifications = null, ?array $helps = null, ?Candidate $coopteur = null) { include(MY_ITEMS.DS.'dashboard.php'); }
    /**
     * Protected method generating the candidate's contracts tab
     *
     * @param int $key_candidate The candidate's primary key
     * @param ?array $contracts The array containing the candidate's contract (if he has)
     * @return View The HTML Page
     */
    protected function getContractsBoard(int $key_candidate, ?array &$contracts = null) {  
        echo '<section class="onglet">';

        $compt = 0; 
        $size = empty($contracts) ? 0 :count($contracts);

        for($i = 0; $i < $size; $i++) {
            if(!empty($contracts[$i]['signature'])){
                $this->getContractsBubble($contracts[$i]);
                $compt++;
            }
        }

        if($compt === 0) {
            echo "<h2>Aucun contrat enregistré</h2>";
        }

        $link = APP_PATH . "/candidates/contracts/input/" . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 

        echo "</section>";
    }
    /**
     * Protected method generating the candidate's offers tab
     *
     * @param ?array $offers The array containing the candidate's offers (if he has)
     * @param int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getOffersBoard(int $key_candidate, ?array &$offers = null) {
        echo '<section class="onglet">';

        if(!empty($offers)) {
            foreach($offers as $obj) {
                $this->getOffersBubble($obj, $key_candidate);
            }
        } else { 
            echo "<h2>Aucune proposition enregistrée </h2>"; 
        }
        
        $link = APP_PATH . "/candidates/offers/input/" . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 

        echo "</section>";
    }
    /**
     * Protected method generating the candidate's applications tab
     *
     * @param ?array $applications The array containing the candidate's applications (if he has)
     * @param int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getApplicationsBoard(int $key_candidate, ?array &$applications = null) {
        echo '<section class="onglet">';

        if(!empty($applications)) {
            foreach($applications as $obj) {
                $this->getApplicationsBubble($obj, $key_candidate);
            }
        } else {
            echo "<h2>Aucune candidature enregistrée </h2>";
        }

        $link = APP_PATH . "/candidates/applications/input/" . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php');  

        echo "</section>";
    }
    /**
     * Protected method generating the candidate's meetings tab
     *
     * @param ?array $meetings The array containing the candidate's meetings (if he has)
     * @param int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getMeetingsBoard(int $key_candidate, ?array &$meetings = null) {
        echo '<section class="onglet">';

        if(!empty($meetings)) {
            foreach($meetings as $obj) {
                $this->getMeetingsBubble($obj, $key_candidate);
            }
        } else { 
            echo "<h2>Aucun rendez-vous enregistré </h2>"; 
        }
        
        $link = APP_PATH . "/candidates/meeting/input/" . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 

        echo "</section>";
    }

    /**
     * Protected method generating an contract bubble
     *
     * @param array $item The contract's data array
     * @return HTMLElement
     */
    protected function getContractsBubble(array $item) { include(MY_ITEMS.DS.'contracts_bubble.php'); }
    /**
     * Protected method generating an offer bubble
     *
     * @param array $item The offer's data array
     * @param int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getOffersBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'offers_bubble.php'); }
    /**
     * Protected method generating an application bubble
     *
     * @param array $item The application's data array
     * @param int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getApplicationsBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'applications_bubble.php'); }
    /**
     * Protected method generating an meeting bubble
     *
     * @param array $item The meeting's data array
     * @param int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getMeetingsBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'meetings_bubble.php'); }
}