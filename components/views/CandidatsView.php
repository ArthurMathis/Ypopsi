<?php 

require_once('View.php');

/**
 * Class representing the candidates' views
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidatsView extends View {
    /**
     * Public method returning the candidates list
     * 
     * @param String $titre The HTML Page titled
     * @param Array $items The array containing the candidates' data
     * @return View The HTML Page
     */
    public function getContent(string $titre, array $items) {
        $this->generateCommonHeader('Ypopsi - Candidatures', [PAGES_STYLES.DS.'liste-page.css']);
        $this->generateMenu(false, APPLICATIONS);
        include BARRES.DS.'candidates.php';

        $this->getListItems($titre, $items, null, 'main-liste');

        $this->generateCommonFooter();
    }
    /**
     * Public method generating the candidte's profil page dashboards 
     *
     * @param String $title The page's title
     * @param Array $item The candidate's data
     * @return View The HTML Page
     */
    public function displayContentCandidate(string $title, array $item) {
        $this->generateCommonHeader($title, [PAGES_STYLES.DS.'candidats.css']);
        $this->generateMenu(false, NULL);

        echo "<content>";
        include(MY_ITEMS.DS.'candidate_profile.php');
        echo "<main>";
        $buttons = ['Tableau de bord', 'Contrats', 'Propositions', 'Candidatures', 'Rendez-vous'] ;
        include(BARRES.DS.'candidate_profile.php');
        $this->getDashboard($item);
        $this->getContractsBoard($item['contracts'], $item['candidate']['Id']);
        $this->getOffersBoard($item['contracts'], $item['candidate']['Id']);
        $this->getApplicationsBoard($item['applications'], $item['candidate']['Id']);
        $this->getMeetingsBoard($item['meeting'], $item['candidate']['Id']);
        echo "</main>";
        echo "</content>";

        $this->generateCommonFooter();
    }

    // * DISPLAY INPUT * //
    /**
     * Public function Returning the offers' html form 
     *
     * @param String $title The HTML Page title
     * @param Int $key_candidate The candidate's primary key
     * @param Array $jobs The array containing the jobs list
     * @param Array $services The array containing the services list
     * @param Array $establishments The array containing the establishments list
     * @param Array $types_of_contracts The array containing the tupes of contracts list
     * @param Array|Null $offer The array containing the offer's data (if it is existing)
     * @return View The HTML Page
     */
    public function displayInputOffers(string $title, int $key_candidate, array $jobs, array $services, array $establishments, array $types_of_contracts, array|null $offer = null) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);
        
        include INSCRIPT_FORM.DS.'offer.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method returning the HTML form to register an contract
     *
     * @param String $title The HTML page's title
     * @param Int $key_candidate The candidate's primary key
     * @param Array $jobs The array containing the list of jobs
     * @param Array $services The array containing the list of services
     * @param Array $establishments The array containing the list of establishments
     * @param Array $types_of_contrats The array containing the list of types of contractss
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
     * @param String $title The HTML page's title
     * @param Int $key_candidate The candidate's primary key
     * @param String $user_establishment The user's establishment
     * @param Array $users
     * @param Array $establisments
     * @return View The HTML Page
     */
    public function displayInputMeetings(string $title, int $key_candidate, string $user_establishment, array $users, array $establisments) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        include INSCRIPT_FORM.DS.'meeting.php';

        $this->generateCommonFooter();
    }

    // * DISPLAY EDIT * //
    /**
     * Public method building the edit candidates'ratings HTML form 
     *
     * @param Array $candidate The arrayu containing the candidate's data
     * @return View The HTML page
     */
    public function displayEditRatings(array $candidate) {
        $this->generateCommonHeader(
            'Ypopsi - Modification de la notation de ' . forms_manip::majusculeFormat($candidate['Name']) . ' ' . $candidate['Firstname'], 
            [FORMS_STYLES.DS.'small-form.css', FORMS_STYLES.DS.'edit-rating.css']
        );
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'rating.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method building the edit candidates HTML form 
     *
     * @param Array $item The array containing the candidate's data
     * @param Array $qualifications The array containing the list of qualifications
     * @param Array $helps The array containing the list of helps
     * @param Array $employee The array containing the the list of employee
     * @return View The HTML Page
     */
    public function displayEditCandidates(array $item, array $qualifications, array $helps, array $employee) {
        $this->generateCommonHeader('Ypopsi - Modification de ' . forms_manip::majusculeFormat($item['candidate']['Name']) . ' ' . $item['candidate']['Firstname'], [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'candidates.php';

        $this->generateCommonFooter();
    }
    /**
     * Public method building the edit meetings HTML form 
     *
     * @param Array $meeting The array containing the meeting's data
     * @param Array $users The array containing the list of users
     * @param Array $establisments The array containing the list of establisments
     * @return View The HTML Page
     */
    public function displayEditMeetings(array $meeting, array $users, array $establisments) {
        $this->generateCommonHeader('Ypopsi - Mise-à-jour rendez-vous', [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'meeting.php';

        $this->generateCommonFooter();
    }

    // * GET * //
    /**
     * Public method generatiing one candidate's profil dashbord 
     *
     * @param Array $item The array containing the candidate's data
     * @return View The HTML Page
     */
    public function getDashboard(array $item) { include(MY_ITEMS.DS.'dashboard.php'); }

    /**
     * Protected method generating the candidate's contracts tab
     *
     * @param Array|Null $contracts The array containing the candidate's contract (if he has)
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getContractsBoard(array|null &$contracts, int $key_candidate) {  
        echo '<section class="onglet">';
        $compt = 0; 
        $size = empty($contracts) ? 0 :count($contracts);
        for($i = 0; $i < $size; $i++) {
            if(!empty($contracts[$i]['signature'])){
                $this->getContractsBubble($contracts[$i]);
                $compt++;
            }
        }

        if($compt === 0)
            echo "<h2>Aucun contrat enregistré</h2>";
        $link = 'index.php?candidates=input-contracts&key_candidate=' . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }
    /**
     * Protected method generating the candidate's offers tab
     *
     * @param Array|Null $offers The array containing the candidate's offers (if he has)
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getOffersBoard(array|null &$offers, int $key_candidate) {
        echo '<section class="onglet">';
        if(!empty($offers)) 
            foreach($offers as $obj) 
                $this->getOffersBubble($obj, $key_candidate);
        else 
            echo "<h2>Aucune proposition enregistrée </h2>"; 
        
        $link = 'index.php?candidates=input-offers&key_candidate=' . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }
    /**
     * Protected method generating the candidate's applications tab
     *
     * @param Array|Null $applications The array containing the candidate's applications (if he has)
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getApplicationsBoard(array|null &$applications, int $key_candidate) {
        echo '<section class="onglet">';
        if(!empty($applications)) foreach($applications as $obj)
            $this->getApplicationsBubble($obj, $key_candidate);
        else echo "<h2>Aucune candidature enregistrée </h2>";
        
        $link = 'index.php?candidates=input-applications&key_candidate=' . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php');  
        echo "</section>";
    }
    /**
     * Protected method generating the candidate's meetings tab
     *
     * @param Array|Null $meetings The array containing the candidate's meetings (if he has)
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getMeetingsBoard(array|null &$meetings, int $key_candidate) {
        echo '<section class="onglet">';
        if(!empty($meetings)) 
            foreach($meetings as $obj)
                $this->getMeetingsBubble($obj, $key_candidate);
        else 
            echo "<h2>Aucun rendez-vous enregistré </h2>"; 
        
        $link = 'index.php?candidates=input-meetings&key_candidate=' . $key_candidate;
        include(MY_ITEMS.DS.'add_button.php'); 
        echo "</section>";
    }

    /**
     * Protected method generating an contract bubble
     *
     * @param Array $item The contract's data array
     * @return HTMLElement
     */
    protected function getContractsBubble(array $item) { include(MY_ITEMS.DS.'contracts_bubble.php'); }
    /**
     * Protected method generating an offer bubble
     *
     * @param Array $item The offer's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getOffersBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'offers_bubble.php'); }
    /**
     * Protected method generating an application bubble
     *
     * @param Array $item The application's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getApplicationsBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'applications_bubble.php'); }
    /**
     * Protected method generating an meeting bubble
     *
     * @param Array $item The meeting's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getMeetingsBubble(array $item, int $key_candidate) { include(MY_ITEMS.DS.'meetings_bubble.php'); }
}