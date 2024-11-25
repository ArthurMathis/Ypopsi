<?php 

require_once('View.php');

/**
 * Class representing the candidates' views
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 * 
 * TODO : renommer les méthodes en displayInscript/Edit 
 */
class CandidatsView extends View {
    /**
     * Public method returning the candidates list
     * 
     * @param String $titre The HTML Page titled
     * @param Array $items The array containing the candidates' data
     * @return View The HTML Page
     */
    public function getContent($titre, $items=[]) {
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
    public function displayContentCandidate($title, &$item=[]) {
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

        // $scripts = ['views/candidats-view.js'];
        // include(COMMON.DS.'import-scripts.php');

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
     * @param Array $offer The array containing the offer's data
     * @return View The HTML Page
     */
    public function displayInputOffers($title, $key_candidate, $jobs=[], $services=[], $establishments=[], $types_of_contracts=[], $offer=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');
        
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
    public function displayInputContracts($title, $key_candidate, $jobs=[], $services=[], $establishments=[], $types_of_contrats=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        $scripts = [
            'models/objects/AutoComplet.js',
            'views/form-view.js'
        ];
        include(COMMON.DS.'import-scripts.php');
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
    public function displayInputMeetings($title, $key_candidate, $user_establishment, $users=[], $establisments=[]) {
        $this->generateCommonHeader($title, [FORMS_STYLES.DS.'small-form.css']);
        $this->generateMenu(true, null);

        $scripts = ['models/objects/AutoComplet.js'];
        include(COMMON.DS.'import-scripts.php');

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
    public function displayEditRatings($candidate=[]) {
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
    public function displayEditCandidates($item=[], $qualifications=[], $helps=[], $employee=[]) {
        $this->generateCommonHeader('Ypopsi - Modification de ' . forms_manip::majusculeFormat($item['candidate']['Name']) . ' ' . $item['candidate']['Firstname'], [FORMS_STYLES.DS.'big-form.css']);
        $this->generateMenu(true, null);

        include EDIT_FORM.DS.'candidate.php';

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
    public function displayEditMeetings($meeting=[], $users=[], $establisments=[]) {
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
    public function getDashboard($item=[]) { include(MY_ITEMS.DS.'dashboard.php'); }

    /**
     * Protected method generating the candidate's contracts tab
     *
     * @param Array $contracts The array containing the candidate's contract
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getContractsBoard(&$contracts=[], $key_candidate) {  
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
     * @param Array $offers The array containing the candidate's offers
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getOffersBoard(&$offers, $key_candidate) {
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
     * @param Array $applications The array containing the candidate's applications
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getApplicationsBoard(&$applications, &$key_candidate) {
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
     * @param Array $meetings The array containing the candidate's meetings
     * @param Int $key_candidate The candidate's primary key
     * @return View The HTML Page
     */
    protected function getMeetingsBoard(&$meetings, $key_candidate) {
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
     * Protected method generating the candidate's rating tab
     *
     * @param Array $candidate The array containing the candidate's data
     * @return View The HTML Page
     */
    protected function getRatingsBoard(&$candidate) {
        echo '<section class="onglet">';
        include(MY_ITEMS.DS.'candidate_rating.php'); 
        echo "</section>";
    }

    /**
     * Protected method generating an contract bubble
     *
     * @param Array $item The contract's data array
     * @return HTMLElement
     */
    protected function getContractsBubble($item=[]) { include(MY_ITEMS.DS.'contracts_bubble.php'); }
    /**
     * Protected method generating an offer bubble
     *
     * @param Array $item The offer's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getOffersBubble($item=[], $key_candidate) { include(MY_ITEMS.DS.'offers_bubble.php'); }
    /**
     * Protected method generating an application bubble
     *
     * @param Array $item The application's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getApplicationsBubble($item=[], $key_candidate) { include(MY_ITEMS.DS.'applications_bubble.php'); }
    /**
     * Protected method generating an meeting bubble
     *
     * @param Array $item The meeting's data array
     * @param Int $key_candidate The candidate's primary key
     * @return HTMLElement
     */
    protected function getMeetingsBubble($item=[], $key_candidate) { include(MY_ITEMS.DS.'meetings_bubble.php'); }

    // * MAKE * //
    // ! Méthodes générant les listes du dashboard ; à ne plus utiliser ! //
    /**
     * Private method generating the list of the candidate's contracts
     *
     * @param Array $contrats The array containing the contracts to the list
     * @param Int $nb_items_max The maximum number of elements
     * @return Void
     */
    // private function makeContractsList($contracts=[], $nb_items_max) {
    //     if(empty($contracts)) 
    //         return;
    // 
    //     $contracts_bubbles = [];
    //     foreach($contracts as $c) if(!empty($c['signature'])){
    //         $date = Moment::currentMoment()->getDate();
    //         if($date < $c['date_debut'])
    //             $statut = "A venir";
    //         elseif($c['date_fin'] < ($date || $c['demission']))
    //             $statut = "Terminé";
    //         else    
    //             $statut = "En cours";
    // 
    //         $new_c = [
    //             'Statut' => $statut,
    //             'Poste' => $c['poste'],
    //             'Type de contrat' => $c['type_de_contrat']
    //         ];
    //         
    //         array_push($contracts_bubbles, $new_c);
    //     }
    // 
    //     if(empty($contracts_bubbles))
    //         return;
    // 
    //     $this->getBubble('Contrats', $contracts_bubbles, $nb_items_max, null, null);
    // }
    /**
     * Private method generating the list of the candidate's offers
     *
     * @param Array $offers The array containing the offers to the list
     * @param Int $nb_items_max The maximum number of elements
     * @return Void
     */
    // private function makeOffersList($offers=[], $nb_items_max) {
    //     if(empty($offers)) 
    //         return;
    // 
    //     $offers_bubbles = [];
    //     foreach($offers as $p) if(empty($p['signature'])) {
    //         $new_p = [
    //             'Statut' => empty($p['statut']) ? 'en attente' : 'refusée',
    //             'Poste' => $p['poste'],
    //             'Type de contrat' => $p['type_de_contrat']
    //         ];
    //         array_push($offers_bubbles, $new_p);
    //     }
    // 
    //     if(empty($offers_bubbles))
    //         return;
    // 
    //     $this->getBubble("Propositions d'embauche", $offers_bubbles, $nb_items_max, null, null);
    // }
    /**
     * Private method generating the list of the candidate's applications
     *
     * @param Array $offers The array containing the applications to the list
     * @param Int $nb_items_max The maximum number of elements
     * @return Void
     */
    // private function makeApplicationsList($applications=[], $nb_items_max) {
    //     if(empty($applications)) 
    //         return;
    // 
    //     $applications_bubbles = [];
    //     foreach($applications as $c) {
    //         $new_c = [
    //             'Poste' => $c['poste'],
    //             'Type de contrat' => $c['type_de_contrat']
    //         ];
    //         if($c['acceptee'])
    //             $new_c['Statut'] = ACCEPTED;
    //         elseif($c['refusee'])
    //             $new_c['Statut'] = REFUSED;
    //         array_push($applications_bubbles, $new_c);
    //     }
    // 
    //     if(empty($applications_bubbles))
    //         return;
    // 
    //     $this->getBubble("Candidatures", $applications_bubbles, $nb_items_max, null, null);
    // }
    /**
     * Private method generating the candidate's list of meetings
     *
     * @param Array $meetings Te array containing the candidate's meetings
     * @param Int $nb_items_max The maximum number of elements in the list
     * @return Void
     */
    // private function makeMeetingsList($meetings=[], $nb_items_max) {
    //     if(empty($meetings)) 
    //         return;
    // 
    //     $meetings_bubbles = [];
    //     foreach($meetings as $r) {
    //         $new_r = [
    //             'Recruteur' => forms_manip::majusculeFormat($r['nom']) . ' ' . $r['prenom'],
    //             'Date' => $r['date'],
    //             'Etablissement' => $r['etablissement']
    //         ];
    //         array_push($meetings_bubbles, $new_r);
    //     }
    // 
    //     if(empty($meetings_bubbles))
    //         return;
    // 
    //     $this->getBubble("Rendez-vous", $meetings_bubbles, $nb_items_max, null, null);
    // }
}