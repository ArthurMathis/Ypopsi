<?php

require_once('define.php');
require_once(COMPONENTS.DS.'AlertManipulation.php');
require_once(COMPONENTS.DS.'FormsManip.php');
require_once(CONTROLLERS.DS.'LoginController.php');
require_once(CONTROLLERS.DS.'HomeController.php');
require_once(CONTROLLERS.DS.'CandidaturesController.php');
require_once(CONTROLLERS.DS.'CandidatsController.php');
require_once(CONTROLLERS.DS.'PreferencesController.php');

session_start();
env_start();

if (!isset($_GET['login']) && (!isset($_SESSION['user_key']) || empty($_SESSION['user_key']))) {
    (new LoginController())->displayLogin();
    exit;

} elseif(isset($_SESSION['first_log_in']) && $_SESSION['first_log_in'] === true) {
    unset($_SESSION['first_log_in']);
    alert_manipulation::alert([
        'title' => "Information importante",
        'msg' => "<p>Bienvenue, c'est votre première connexion !</p><p>Vous devez <b>modifier votre mot de passe</b> au plus vite.</p>",
        'icon' => 'warning',
        'direction' => 'index.php?preferences=edit-password',
        'button' => true
    ]);
    
}

switch(true) {
    case isset($_GET['login']):
        $login = new LoginController();
        switch($_GET['login']) { 
            case 'connexion' : 
                $erreur = "Erreur d'identification";
                try {
                    if(empty($_POST["identifiant"])) 
                        throw new Exception("Le champs identifiant doit être rempli !");
                    elseif(empty($_POST["motdepasse"])) 
                        throw new Exception("Le champs mot de passe doit être rempli !"); 

                    $identifiant = $_POST["identifiant"];
                    $motdepasse = $_POST["motdepasse"];

                    $login->checkIdentification($identifiant, $motdepasse);

                } catch(Exception $e){
                    forms_manip::error_alert([
                        'title' => $erreur,
                        'msg' => $e
                    ]);
                }
                break;  

            case 'deconnexion' :
                $login->closeSession();
                break;

            case 'get_connexion' :
                $login->displayLogin(); 
                break;   

            default : 
                $login->displayLogin();
                break;
        }
        exit;
        
    case isset($_GET['applications']):
        $applications = new CandidaturesController();
        try {
            switch($_GET['applications']) {
                case 'home' :
                    $applications->dispayCandidatures();
                    break; 

                case 'input-candidates': 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $applications->displayInputCandidate();
                    break;

                case 'input-applications' : 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $applications->displayInputApplications();
                    break;

                case 'inscript-candidates' : 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST["nom"]))
                            throw new Exception("Le champs nom doit être rempli par une chaine de caractères !");
                        elseif(empty($_POST["prenom"]))
                            throw new Exception("Le champs prenom doit être rempli par une chaine de caractères !");
                        elseif(empty($_POST["diplome"])) {
                            if(!empty($_POST["diplomeDate"])) 
                                throw new Exception("Le nombre de diplômes et de dates de diplômes ne correspond pas.");
                        } elseif(empty($_POST["diplomeDate"]))
                            throw new Exception("Le nombre de diplômes et de dates de diplômes ne correspond pas.");
                        elseif(count($_POST["diplome"]) !== count($_POST["diplomeDate"]))
                            throw new Exception("Le nombre de diplômes et de dates de diplômes ne correspond pas.");
                        elseif (empty($_POST["diplome"]) && empty($_POST["diplomeDate"]) || count($_POST["diplome"]) !== count($_POST["diplomeDate"])) 
                            throw new Exception("Les champs diplôme et date de diplôme doivent être remplis et correspondre !");

                        $candidate = [
                            'name'          => forms_manip::nameFormat($_POST["nom"]), 
                            'firstname'     => forms_manip::nameFormat($_POST["prenom"]), 
                            'gender'        => $_POST['genre'],
                            'email'         => $_POST["email"], 
                            'phone'         => !empty($_POST["telephone"]) ? forms_manip::numberFormat($_POST["telephone"]) : null, 
                            'address'       => !empty($_POST["adresse"]) ? $_POST["adresse"] : null,
                            'city'          => forms_manip::nameFormat($_POST["ville"]), 
                            'post code'     => !empty($_POST['code-postal']) ? $_POST['code-postal'] : null
                        ];

                        if(isset($_POST['diplomeDate'])) foreach ($_POST["diplomeDate"] as $date) 
                            if (empty($date)) 
                                throw new Exception("Chaque diplôme doit avoir une date d'obtention !");
                        $qualifications = array_map(
                            function($qualification, $date) { return ['qualification' => $qualification, 'date' => $date]; }, 
                            isset($_POST["diplome"]) ? $_POST["diplome"] : [], 
                            isset($_POST["diplomeDate"]) ? $_POST["diplomeDate"] : []
                        );

                        $helps          = isset($_POST["aide"]) ? $_POST["aide"] : null;
                        $coopteur       = isset($_POST["coopteur"]) ? $_POST['coopteur'] : null;
                        $medical_visit  = isset($_POST["visite_medicale"]) ? $_POST["visite_medicale"] : null;

                        $applications->checkCandidate($candidate, $qualifications, $helps, $medical_visit, $coopteur);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription du candidat",
                            'msg' => $e
                        ]);
                    }
                    break;

                case 'inscript-applications' :
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try { 
                        if(empty($_POST["poste"])) 
                            throw new Exception("Le champs poste doit être rempli par une chaine de caractères");
                        elseif(empty($_POST["disponibilite"])) 
                            throw new Exception("Le champs disponibilité doit être rempli par une chaine de caractères");
                        elseif(empty($_POST["source"])) 
                            throw new Exception("Le champs source doit être rempli par une chaine de caractères");

                        $applications->createApplications(
                            $_SESSION['candidate'],
                            [
                                'job'              => $_POST["poste"],
                                'service'          => !empty($_POST["service"]) ? $_POST["service"] : null,
                                'establishment'    => !empty($_POST["etablissement"]) ?  $_POST["etablissement"] : null,
                                'type of contract' => !empty($_POST["type_de_contrat"]) ?  $_POST["type_de_contrat"] : null,
                                'availability'     => $_POST["disponibilite"],
                                'source'           => $_POST["source"]
                            ],
                            isset($_SESSION['qualifications']) && !empty($_SESSION['qualifications']) ? $_SESSION['qualifications'] : null,
                            isset($_SESSION['helps']) && !empty($_SESSION['helps']) ? $_SESSION['helps'] : null,
                            isset($_SESSION['coopteur']) && !empty($_SESSION['coopteur']) ? $_SESSION['coopteur'] : null
                        );

                        $candidate = $_SESSION['candidate'];
                        unset($_SESSION['candidate']);
                        unset($_SESSION['qualifications']);
                        unset($_SESSION['helps']);
                        unset($_SESSION['coopteur']);
                        
                        alert_manipulation::alert([
                            'title' => 'Candidat inscript !',
                            'msg' => strtoupper($candidate->getName()) . " " . forms_manip::nameFormat($candidate->getFirstname()) . " a bien été inscrit(e).",
                            'direction' => "index.php?candidates=" . $candidate->getKey()
                        ]);
            
                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription de la candidature",
                            'msg' => $e
                        ]);
                    }
                    break;
            
                default : 
                    $applications->dispayCandidatures();
                    break;
            }

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        exit;
        
    case isset($_GET['candidates']):
        $candidates = new CandidatController();
        if(is_numeric($_GET['candidates'])) 
            $candidates->displayCandidate($_GET['candidates']);

        else try { 
            switch($_GET['candidates']) {
                case 'home':
                    $candidates->displayContent();
                    break;

                case 'input-meetings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                        $candidates->displayInputMeetings($_GET['key_candidate']);
                    else 
                        throw new Exception("La clé candidat n'a pas pu être récupérée !");
                    break;

                case 'input-applications': 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                        $candidates->displayInputApplications($_GET['key_candidate']);
                    else 
                        throw new Exception("La clé candidat n'a pas pu être réceptionné");
                    break;

                case 'input-offers' :
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(is_numeric($_GET['key_candidate'])) {
                        $application = empty($_GET['key_application']) ? null : $_GET['key_application'];
                        $need = empty($_GET['key_need']) ? null : $_GET['key_need'];

                        $candidates->displayInputOffers($_GET['key_candidate'], $application, $need);
                    } else 
                        throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                    break;

                case 'input-contracts':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                        $candidates->displayInputContracts($_GET['key_candidate']);
                    else 
                        throw new Exception("La clé candidat n'a pas pu être récupérée !");
                    break;   

                case 'inscript-meetings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(!isset($_GET['key_candidate']) || !is_numeric($_GET['key_candidate']))
                        throw new Exception("La clé candidat est introuvale !");

                    try {
                        $data = [
                            'recruteur' => $_POST['recruteur'],
                            'etablissement' => $_POST['etablissement'],
                            'date' => $_POST['date'],
                            'time' => $_POST['time']
                        ];

                        if(empty($data['recruteur']))
                            throw new Exception("Le champs recruteur doit être rempli !");
                        elseif(empty($data['etablissement']))
                            throw new Exception("Le champs etablissement doit être rempli !");
                        elseif(empty($data['date']))
                            throw new Exception("Le champs date doit être rempli !");
                        elseif(empty($data['time']))
                            throw new Exception("Le champs horaire doit être rempli !");

                        $candidates->createMeetings($_GET['key_candidate'], $data);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'msg' => $e
                        ]);
                    }
                    break;     
                
                case 'inscript-offers':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    
                    try {
                        if(empty($_POST['poste']))
                            throw new Exception("Le champs poste doit être rempli !");
                        elseif(empty($_POST['service']))
                            throw new Exception("Le champs service doit être rempli !");
                        elseif(empty($_POST['etablissement']))
                            throw new Exception("Le champs service doit être rempli !");
                        elseif(empty($_POST['type_contrat']))
                            throw new Exception("Le champs type de contrat doit être rempli !");
                        elseif(empty($_POST['date_debut']))
                            throw new Exception('Le champs date de début doit être rempli !');
                        if($_POST['type_contrat'] == 'CDI' && !empty($_POST['date_fin'])) 
                            throw new Exception("La date de fin ne peut pas être remplie pour un CDI !");
                        elseif($_POST['type_contrat'] != 'CDI' &&empty($_POST['date_fin'])) 
                                throw new Exception("La date de fin doit être remplie !");

                        $data = [
                            'poste' => $_POST['poste'],
                            'service' => $_POST['service'],
                            'etablissement' => $_POST['etablissement'],
                            'type_de_contrat' => $_POST['type_contrat'],
                            'date debut' => $_POST['date_debut'],
                        ];

                        if(!empty($_POST['date_fin']))
                            $data['date fin'] = $_POST['date_fin'];
                        if(!empty($_POST['salaire_mensuel']))
                            $data['salaire'] = intval($_POST['salaire_mensuel']);
                        if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                            $data['taux horaire'] = $_POST['taux_horaire_hebdomadaire'];
                        if(isset($_POST['travail_nuit']))
                            $data['travail nuit'] = true;
                        if(isset($_POST['travail_wk']))
                            $data['travail nuit'] = true;
        
                        if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate'])) 
                            $candidates->createOffers(
                                $_GET['key_candidate'],
                                $data, 
                                isset($_GET['key_application']) && is_numeric($_GET['key_application']) ? $_GET['key_application'] : NULL
                            );
                        else 
                            throw new Exception("Clé candidat introuvable !");  

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription de la proposition",
                            'msg' => $e
                        ]);
                    }
                    break; 
                    
                case 'inscript-contracts':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(!isset($_GET['key_candidate']) || !is_numeric($_GET['key_candidate']))
                        throw new Exception("La clé candidat est inrouvale !"); 

                    if(isset($_GET['key_offer']) && is_numeric($_GET['key_offer'])) 
                        $candidates->signContracts($_GET['key_candidate'], $_GET['key_offer']);
                        
                    else try {
                        if(empty($_POST['poste']))
                            throw new Exception("Le champs poste doit être rempli !");
                        elseif(empty($_POST['service']))
                            throw new Exception("Le champs service doit être rempli !");
                        elseif(empty($_POST['etablissement']))
                            throw new Exception("Le champs etablissement doit être rempli !");
                        elseif(empty($_POST['type_contrat']))
                            throw new Exception("Le champs type de contrat doit être rempli !");
                        elseif(empty($_POST['date_debut']))
                            throw new Exception('Le champs date de début doit être rempli !');

                        $data = [
                            'job' => $_POST['poste'],
                            'service' => $_POST['service'],
                            'establishment' => $_POST['etablissement'],
                            'type' => $_POST['type_contrat'],
                            'start_date' => $_POST['date_debut']
                        ];

                        if(!empty($_POST['date_fin']))
                            $data['end_date'] = $_POST['date_fin'];
                        if(!empty($_POST['salaire_mensuel']))
                            $data['salary'] = intval($_POST['salaire_mensuel']);
                        if(!empty($_POST['taux_horaire_hebdomadaire'])) 
                            $data['hourly_rate'] = $_POST['taux_horaire_hebdomadaire'];
                        if(isset($_POST['travail_nuit']))
                            $data['night_work'] = true;
                        if(isset($_POST['travail_wk']))
                            $data['week_end_work'] = true;
                        
                        $candidates->createContracts($_GET['key_candidate'], $data);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription du contrat",
                            'msg' => $e
                        ]);
                    }
                    break;  
                    
                case 'edit-meetings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    else 
                        $candidates->displayEditMeetings($_GET['key_meeting']); 
                    break;  

                case 'edit-ratings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                        $candidates->displayEditRatings($_GET['key_candidate']);
                    else 
                        throw new Exception("La clé candidat est introuvable !");
                    break;  

                case 'edit-candidates':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['key_candidate']))
                        $candidates->displayEditCandidates($_GET['key_candidate']);
                    else 
                        throw new Exception("La clé candidat est introuvable !");
                    break;  

                case 'update-ratings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        $rating = [
                            'notation' => max($_POST['notation']),
                            'a' => isset($_POST['a']) ? 1 : 0,
                            'b' => isset($_POST['b']) ? 1 : 0,
                            'c' => isset($_POST['c']) ? 1 : 0,
                            'description' => $_POST['description']
                        ];
                        if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                            $candidates->updateRatings($_GET['key_candidate'], $rating);
                        else 
                            throw new Exception("La clé candidat est introuvable !");

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de la mise-à-jour du candidat",
                            'msg' => $e
                        ]);
                    }

                    break;  
                    
                case 'update-candidates':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        $data = [
                            'name'                => forms_manip::nameFormat($_POST['nom']),
                            'firstname'           => forms_manip::nameFormat($_POST['prenom']),
                            'email'               => !empty($_POST['email']) ? forms_manip::numberFormat($_POST['email']) : null,
                            'phone'               => !empty($_POST['telephone']) ? forms_manip::numberFormat($_POST['telephone']) : null,
                            'address'             => $_POST['adresse'],
                            'city'                => forms_manip::nameFormat($_POST['ville']),
                            'post_code'           => $_POST['code-postal'],
                            'qualifications'      => array_map(
                                                        function($qualification, $date) { return ['qualification' => $qualification, 'date' => $date]; }, 
                                                        isset($_POST["diplome"]) ? $_POST["diplome"] : [], 
                                                        isset($_POST["diplomeDate"]) ? $_POST["diplomeDate"] : []
                                                    ),
                            'helps'               => isset($_POST["aide"]) ? $_POST["aide"] : null,
                            'coopteur'            => isset($_POST["coopteur"]) ? $_POST['coopteur'] : null,
                            'medical_visit'       => isset($_POST["visite_medicale"]) ? $_POST["visite_medicale"] : null
                        ];

                        if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                            $candidates->updateCandidates($_GET['key_candidate'], $data);
                        else 
                            throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'msg' => $e
                        ]);
                    }
                    break;  

                case 'update-meetings':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST['recruteur']))
                            throw new Exception("Le champs recruteur doit être rempli !");
                        elseif(empty($_POST['etablissement']))
                            throw new Exception("Le champs etablissement doit être rempli !");
                        elseif(empty($_POST['date']))
                            throw new Exception("Le champs date doit être rempli !");
                        elseif(empty($_POST['time']))
                            throw new Exception("Le champs horaire doit être rempli !");
                            
                        $meeting = [
                            'employee' => $_POST['recruteur'],
                            'establishment' => $_POST['etablissement'],
                            'date' => Moment::getTimestampFromDate($_POST['date'], $_POST['time']),
                            'description' => $_POST['description'], 
                        ];

                        if(Moment::currentMoment()->isTallerThan(Moment::fromDate($_POST['date'], $_POST['time'])->getTimestamp()))
                            throw new Exception("La date du rendez-vous est antérieure à aujourd'hui.");

                        $candidates->updateMeetings($_GET['key_meeting'], $_GET['key_candidate'], $meeting);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'msg' => $e
                        ]);
                    }

                    break;
                    
                case 'delete-meetings': 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    else
                        $candidates->deleteMeetings($_GET['key_meeting'], $_GET['key_candidate']);
                    break;  
                    
                case 'dismiss-applications':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(!isset($_GET['key_applications']) || !is_numeric($_GET['key_applications']))
                        throw new Exception("Clé de candidature est introuvable !");
                    else
                        $candidates->dismissApplications($_GET['key_applications']);
                    break;  

                case 'reject-offers':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    $candidates->rejectOffers($_GET['key_offer']);
                    break;    
                    
                case 'resignations':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(!isset($_GET['key_contract']) || !is_numeric($_GET['key_contract']))
                        throw new Exception("La clé de contrat est introuvable !");
                    else
                        $candidates->resignContracts($_GET['key_contract']);
                    break; 

                default: 
                    throw new Exception("L'action n'a pas pu être identifiée !");
            } 

        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        exit;    

    case (isset($_GET['preferences'])):
        $preferences = new PreferencesController();
        if(is_numeric($_GET['preferences'])) {
            if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
            
            if($_GET['preferences'] == $_SESSION['user_key']) 
                header('Location: index.php?preferences=home');
            else 
                $preferences->display($_GET['preferences']);

        } else try {
            switch($_GET['preferences']) {
                case 'home':
                    $preferences->display($_SESSION['user_key']); 
                    break;    

                case 'edit-users':
                    if(isset($_GET['user_key']) && !empty($_GET['user_key']) && is_numeric($_GET['user_key'])) {
                        $preferences->displayEditUsers($_GET['user_key']);

                    } else 
                        throw new Exception ('La clé utilisateur est nécessaire pour la mise-à-jour de son rôle !');
                    break;

                case 'update-users':
                    if(isset($_GET['user_key']) && !empty($_GET['user_key']) && is_numeric($_GET['user_key'])) {
                        try {
                            if(empty( $_POST['nom'])) 
                                throw new Exception('Le champs nom doit être rempli !');
                            elseif(empty( $_POST['prenom'])) 
                                throw new Exception('Le champs prénom doit être rempli !');
                            elseif(empty( $_POST['email'])) 
                                throw new Exception('Le champs email doit être rempli !');
                            elseif(empty( $_POST['role'])) 
                                throw new Exception('Le champs rôle doit être rempli !');

                            $user = [
                                'name' => $_POST['nom'],
                                'firstname' => $_POST['prenom'],
                                'email' => $_POST['email'],
                                'role' => $_POST['role']
                            ];

                        } catch(Exception $e) {
                            forms_manip::error_alert([
                                'msg' => $e
                            ]);
                        }
                        
                        $preferences->updateUsers($_GET['user_key'], $user);

                    } else 
                        throw new Exception ('La clé utilisateur est nécessaire pour la mise-à-jour !');
                    break;    

                case 'edit-password':
                    $preferences->displayEditPassword();
                    break; 

                case 'update-password':
                    try {
                        if(empty($_POST['password']) || empty($_POST['new-password']) || empty($_POST['confirmation']))
                            throw new Exception('Tous les champs doivent être rempli pour mettre le mot de passe à jour !');
                        elseif($_POST['new-password'] != $_POST['confirmation'])
                            throw new Exception('Le nouveau mot de passe et sa confirmation doivent être identiques !');
        
                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de la mise-à-jour du mot de passe", 
                            'msg' => $e
                        ]);
                    }

                    $preferences->updatePassword($_POST['password'], $_POST['new-password']);
                    break; 
                    
                case 'display-reset-password':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['user_key']) && !empty($_GET['user_key']) && is_numeric($_GET['user_key'])) {
                        $_SESSION['password'] = PasswordGenerator::random_password();
                        alert_manipulation::alert([
                            'title' => "Information importante",
                            'msg' => "Le mot de passe va être réinitialisé. Le nouveau mot de passe est : <br><b> ". $_SESSION['password'] . "</b><br>Ce mot de passe ne pourra plus être consulté. Mémorisez-le avant de valider ou revenez en arrière.",
                            'direction' => 'index.php?preferences=reset-password&user_key=' . $_GET['user_key'],
                            'confirm' => true
                        ]);

                    } else 
                        throw new Exception ('La clé utilisateur est nécessaire pour la réinitialisation du mot de passe !');
                    break;

                case 'reset-password':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    if(isset($_GET['user_key']) && !empty($_GET['user_key']) && is_numeric($_GET['user_key'])) {
                        $preferences->resetPassword($_SESSION['password'], $_GET['user_key']);
                        unset($_SESSION['password']);

                    } else 
                        throw new Exception ('La clé utilisateur est nécessaire pour la réinitialisation du mot de passe !');
                    break;

                case 'list-users':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayUsers();
                    break;

                case 'list-new-users':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayNewUsers();
                    break;

                case 'list-jobs':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayJobs();
                    break;

                case 'list-qualifications': 
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayQualifications();
                    break;

                case 'list-poles':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayPoles();
                    break;

                case 'list-establishments':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayEstablishments();
                    break;

                case 'list-services':
                    if($_SESSION['user_role'] == INVITE)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayServices();
                    break;

                case 'input-users':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayInputUsers();
                    break; 

                case 'input-jobs':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayInputJobs();
                    break;  

                case 'input-qualifications':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayInputQualifications();
                    break;   

                case 'input-poles':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayInputPoles();
                    break;

                case 'input-establishments':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayInputEstablishments();
                    break;  

                case 'input-services': 
                    $preferences->displaySaisieService();
                    break;

                case 'get-inscript-users':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST['identifiant']))
                            throw new Exception("Le champs identifiant doit être rempli.");
                        elseif(empty($_POST['nom']))
                            throw new Exception("Le champs nom doit être rempli.");
                        elseif(empty($_POST['prenom']))
                            throw new Exception("Le champs prenom doit être rempli.");
                        elseif(empty($_POST['email']))
                            throw new Exception("Le champs email doit être rempli.");
                        elseif(empty($_POST['etablissement']))
                            throw new Exception("Le champs étabissement doit être rempli.");
                        elseif(empty($_POST['role']))
                            throw new Exception("Le champs role doit être rempli.");

                        $data = [
                            'identifier' => $_POST['identifiant'],
                            'name' => forms_manip::nameFormat($_POST['nom']  ),
                            'firstname' => forms_manip::nameFormat($_POST['prenom']),
                            'email' => $_POST['email'],
                            'establishment' => $_POST['etablissement'],
                            'role' => $_POST['role']
                        ];

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'incription du nouvel utilisateur", 
                            'msg' => $e
                        ]);
                    }

                    $data['password'] = PasswordGenerator::random_password();
                    $_SESSION['new user data'] = $data;
                    alert_manipulation::alert([
                        'title' => "Information importante",
                        'msg' => "Le nouvel utilisateur va être créé avec le mot de passe suivant : <br><b> ". $data['password'] . "</b><br>Ce mot de passe ne pourra plus être consulté. Mémorisez-le avant de valider la création du compte ou revenez en arrière.",
                        'direction' => 'index.php?preferences=inscript-users',
                        'confirm' => true
                    ]);
                    break;  
                
                case 'inscript-users':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(isset($_SESSION['new user data']) && !empty($_SESSION['new user data'])) {
                            $preferences->createUsers($_SESSION['new user data']);
                            unset($_SESSION['new user data']);
                        } else 
                            throw new Exception('Erreur lors de la récupération des informations du candidat, des informations sont manquantes.');
                        
                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'incription du nouvel utilisateur", 
                            'msg' => $e,
                            'direction' => "index.php?preferences=input-users"
                        ]);
                    } 
                    break;

                case 'inscript-jobs':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST['titled']) || empty($_POST['titled-feminin']))
                            throw new Exception("Tous les champs doivent être remplis !");

                        $data = [
                            'titled' => $_POST['titled'],
                            'titled feminin' => $_POST['titled-feminin']
                        ];
                        
                        $preferences->createJobs($data);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription du nouveau poste", 
                            'msg' => $e
                        ]);
                    }
                    break;

                case 'inscript-qualifications':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    break; 

                case 'inscript-poles':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST['intitule']))
                            throw new Exception("Le champs intitulé doit être rempli !");
                        elseif(empty($_POST['description']))
                            throw new Exception("Le champs description doit être rempli !");
                        
                        $preferences->createPoles($_POST['intitule'], $_POST['description']);

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription du pôle",
                            'msg' => $e
                        ]);
                    }
                    break;

                case 'inscript-establishments':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    try {
                        if(empty($_POST['intitule']))
                            throw new Exception('Le champs intitulé doit être rempli !');
                        elseif(empty($_POST['adresse']))
                            throw new Exception('Le champs adresse doit être rempli !');
                        elseif(empty($_POST['ville']))
                            throw new Exception('Le champs ville doit être rempli !');
                        elseif(empty($_POST['code-postal']))
                            throw new Exception('Le champs code postal doit être rempli !');
                        elseif(empty($_POST['pole']))
                            throw new Exception('Le champs pôle doit être rempli !');

                        $data = [
                            'titled'    => $_POST['intitule'],
                            'address'   => $_POST['adresse'],
                            'city'      => $_POST['ville'],
                            'postcode'  => $_POST['code-postal'],
                            'key_poles' => $_POST['pole']
                        ];

                    } catch (Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription de l'établissement",
                            'msg' => $e
                        ]);
                    }

                    $preferences->createEstablishments($data);
                    break;

                case 'inscript-services':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN && $_SESSION['user_role'] != MOD)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                    
                    try {
                        $service = $_POST['service'];
                        $etablissement = $_POST['etablissement'];
                    
                        if(empty($service) || empty($etablissement))
                            throw new Exception("Les champs service est établissements doivent être remplis !");

                    } catch (Exception $e) {
                        forms_manip::error_alert([
                            'title' => "Erreur lors de l'inscription du nouveau service",
                            'msg' => $e
                        ]);
                    }

                    $preferences->createService($service, $etablissement);
                    break;


                case 'logs-history':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayLogsHistory();
                    break;  

                case 'actions-history':
                    if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                        throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                    $preferences->displayActionsHistory();
                    break;  

                // todo : On affiche les listes des autres données de la base de données (types de contrats, aides au recrutement, sources)    
                case 'autres':
                    break;    

                default: 
                    throw new Exception("L'action n'a pas pu être identifiée !");
            }
        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e
            ]);
        }
        exit;

    default: (new HomeController())->displayHome();
}