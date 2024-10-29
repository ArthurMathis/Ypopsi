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

if(isset($_SESSION['first_log_in']) && $_SESSION['first_log_in'] == true) {
    unset($_SESSION['first_log_in']);
    alert_manipulation::alert([
        'title' => "Information importante",
        'msg' => "<p>Bienvenu, c'est votre première connexion !</p><p>Vous devez <b>modifier votre mot de passe</b> au plus vite.</p>",
        'icon' => 'warning',
        'direction' => 'index.php?preferences=edit-password',
        'button' => true
    ]);
    
} elseif(isset($_GET['login'])) {
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
    
            // On récupère et retourne les éventuelles erreurs    
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

} elseif(isset($_GET['applications'])) {
    $applications = new CandidaturesController();
    try {
        switch($_GET['applications']) {
            case 'home' :
                $applications->dispayCandidatures();
                break; 

            case 'input-candidate': 
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $applications->displayInputCandidate();
                break;

            case 'input-applications' : 
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $applications->displayInputApplications();
                break;

            case 'inscript-candidate' : 
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                try {
                    if(empty($_POST["nom"])) {
                        throw new Exception("Le champs nom doit être rempli par une chaine de caractères !");
                    } elseif(empty($_POST["prenom"])) {
                        throw new Exception("Le champs prenom doit être rempli par une chaine de caractères !");
                    } elseif(empty($_POST["email"])) {
                        throw new Exception("Le champs email doit être rempli par une chaine de caractères !");
                    } elseif(empty($_POST["adresse"])) {
                        throw new Exception("Le champs adresse doit être rempli par une chaine de caractères !");
                    } elseif(empty($_POST["ville"])) {
                        throw new Exception("Le champs ville doit être rempli par une chaine de caractères !");
                    } elseif(empty($_POST['code-postal'])) {
                        throw new Exception("Le champs code postal doit être rempli par une chaine de caractères !");
                    }

                    $candidate = [
                        'name'          => forms_manip::nameFormat($_POST["nom"]), 
                        'firstname'     => forms_manip::nameFormat($_POST["prenom"]), 
                        'gender'        => $_POST['genre'],
                        'email'         => $_POST["email"], 
                        'phone'         => forms_manip::numberFormat($_POST["telephone"]), 
                        'address'       => $_POST["adresse"],
                        'city'          => forms_manip::nameFormat($_POST["ville"]), 
                        'post code'     => $_POST['code-postal']
                    ];

                    $qualifications = isset($_POST["diplome"]) ? $_POST["diplome"] : null;
                    $helps          = isset($_POST["aide"]) ? $_POST["aide"] : null;
                    $coopteur       = isset($_POST["coopteur"]) ? $_POST['coopteur'][0] : null;
                    $medical_visit  = isset($_POST["visite_medicale"][0]) ? $_POST["visite_medicale"][0] : null;

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

                    $application = [
                        'job'               => forms_manip::nameFormat($_POST["poste"]), 
                        'service'           => $_POST["service"], 
                        'establishment'      => $_POST["etablissement"],
                        'type of contract'  => $_POST["type_de_contrat"],
                        'availability'      => $_POST["disponibilite"], 
                        'source'            => forms_manip::nameFormat($_POST["source"])
                    ];

                    $candidate = $_SESSION['candidate'];
                    $qualifications = isset($_SESSION['qualifications']) && !empty($_SESSION['diplomes']) ? $_SESSION['diplomes'] : null;
                    $helps = isset($_SESSION['helps']) && !empty($_SESSION['aide']) ? $_SESSION['aide'] : null;
                    $coopteur = isset($_SESSION['coopteur']) && !empty($_SESSION['coopteur']) ? $_SESSION['coopteur'] : null; 

                    $applications->createApplications($candidate, $application, $qualifications, $helps, $coopteur);

                    // TODO : !! Libérer la mémoire !!
        
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


} elseif(isset($_GET['candidates'])) {
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
                    $candidates->getInputMeetings($_GET['key_candidate']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être récupérée !");
                break;

            case 'input-applications': 
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                    $candidates->getInputApplications($_GET['key_candidate']);
                else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionné");
                break;

            case 'input-offers' :
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(is_numeric($_GET['key_candidate'])) {
                    $application = empty($_GET['key_application']) ? null : $_GET['key_application'];
                    $need = empty($_GET['key_need']) ? null : $_GET['key_need'];

                    $candidates->getInputOffers($_GET['key_candidate'], $application, $need);
                } else 
                    throw new Exception("La clé candidat n'a pas pu être réceptionnée");
                break;

            case 'input-contracts':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                    $candidates->getInputContracts($_GET['key_candidate']);
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

                    $candidates->createMeeting($_GET['key_candidate'], $data);

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
                        $candidates->createOffer(
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
                    $candidates->signContract($_GET['key_candidate'], $_GET['key_offer']);
                    
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
                
            case 'edit-meeting':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                else 
                    $candidates->getEditMeetings($_GET['key_meeting']); 
                break;  

            case 'edit-rating':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                    $candidates->getEditRatings($_GET['key_candidate']);
                else 
                    throw new Exception("La clé candidat est introuvable !");
                break;  

            case 'edit-candidate':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['key_candidate']))
                    $candidates->getEditCandidates($_GET['key_candidate']);
                else 
                    throw new Exception("La clé candidat est introuvable !");
                break;  

            case 'update-rating':
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
                        $candidates->updateRating($_GET['key_candidate'], $rating);
                    else 
                        throw new Exception("La clé candidat est introuvable !");

                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de la mise-à-jour du candidat",
                        'msg' => $e
                    ]);
                }

                break;  
                
            case 'update-candidate':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                try {
                    $data = [
                        'name' => forms_manip::nameFormat($_POST['nom']),
                        'firstname' => forms_manip::nameFormat($_POST['prenom']), 
                        'email' => $_POST['email'], 
                        'phone' => forms_manip::numberFormat($_POST['telephone']), 
                        'address' => $_POST['adresse'], 
                        'city' => forms_manip::nameFormat($_POST['ville']), 
                        'post_code' => $_POST['code-postal'], 
                        'qualifications' => isset($_POST["diplome"]) ? $_POST["diplome"] : null,
                        'helps' => isset($_POST["aide"]) ? $_POST["aide"] : null,
                        'coopteur' => isset($_POST["coopteur"]) ? $_POST['coopteur'][0] : null,
                        'medical_visit' => isset($_POST["visite_medicale"][0]) ? $_POST["visite_medicale"][0] : null
                    ];

                    if(isset($_GET['key_candidate']) && is_numeric($_GET['key_candidate']))
                        $candidates->updateCandidate($_GET['key_candidate'], $data);
                    else 
                        throw new Exception("Impossible de modifier la notation du candidat, clé candidat est introuvable !");

                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'msg' => $e
                    ]);
                }
                break;  

            case 'update-meeting':
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

                    $candidates->updateMeeting($_GET['key_meeting'], $_GET['key_candidate'], $meeting);

                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'msg' => $e
                    ]);
                }

                break;
                
            case 'delete-meeting': 
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                else
                    $candidates->deleteMeeting($_GET['key_meeting'], $_GET['key_candidate']);
                break;  
                
            case 'dismiss-applications':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(!isset($_GET['key_applications']) || !is_numeric($_GET['key_applications']))
                    throw new Exception("Clé de candidature est introuvable !");
                else
                    $candidates->dismissApplications($_GET['key_applications']);
                break;  

            case 'reject-offer':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
                $candidates->rejectOffer($_GET['key_offer']);
                break;    
                
            case 'resignation':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(!isset($_GET['key_contract']) || !is_numeric($_GET['key_contract']))
                    throw new Exception("La clé de contrat est introuvable !");
                else
                    $candidates->resignContract($_GET['key_contract']);
                break; 

            default: 
                throw new Exception("L'action n'a pas pu être identifiée !");
        } 

    // On récupère les éventuelles erreurs    
    } catch(Exception $e) {
        forms_manip::error_alert([
            'msg' => $e
        ]);
    } 


} elseif(isset($_GET['preferences'])) {
    // On déclare le controller de préférences
    $preferences = new PreferencesController();

    // On vérifie s'il s'agit d'une clé de candidat
    if(is_numeric($_GET['preferences'])) {
        if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
            throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");
        
        if($_GET['preferences'] == $_SESSION['user_key']) 
            header('Location: index.php?preferences=home');
        else 
            $preferences->display($_GET['preferences']);

    // On sélectionne l'action
    } else try {
        switch($_GET['preferences']) {
            // On affiche la page d'accueil
            case 'home':
                $preferences->display($_SESSION['user_key']); 
                break;    

            // On affiche la formulaire de mise-à-jour d'un utilisateur
            case 'edit-user':
                if(isset($_GET['cle_utilisateur']) && !empty($_GET['cle_utilisateur']) && is_numeric($_GET['cle_utilisateur'])) {
                    $preferences->displayEditUtilisateur($_GET['cle_utilisateur']);

                } else 
                    throw new Exception ('La clé utilisateur est nécessaire pour la mise-à-jour de son rôle !');
                break;

            // On met-à-jour le candidat  
            case 'update-user':
                if(isset($_GET['cle_utilisateur']) && !empty($_GET['cle_utilisateur']) && is_numeric($_GET['cle_utilisateur'])) {
                    try {
                        // On récupère les données du formulaire
                        $user = [
                            'nom' => $_POST['nom'],
                            'prenom' => $_POST['prenom'],
                            'email' => $_POST['email'],
                            'role' => $_POST['role']
                        ];

                        // On vérifie l'intégrité des données
                        if(empty($user['nom'])) 
                            throw new Exception('Le champs nom doit être rempli !');
                        elseif(empty($user['prenom'])) 
                            throw new Exception('Le champs prénom doit être rempli !');
                        elseif(empty($user['email'])) 
                            throw new Exception('Le champs email doit être rempli !');
                        elseif(empty($user['role'])) 
                            throw new Exception('Le champs rôle doit être rempli !');

                    } catch(Exception $e) {
                        forms_manip::error_alert([
                            'msg' => $e
                        ]);
                    }
                    
                    $preferences->updateUser($_GET['cle_utilisateur'], $user);

                } else 
                    throw new Exception ('La clé utilisateur est nécessaire pour la mise-à-jour !');
                break;    

            // On affiche la formulaire de mise-à-jour d'un 
            case 'get-reset-password':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['cle_utilisateur']) && !empty($_GET['cle_utilisateur']) && is_numeric($_GET['cle_utilisateur'])) {
                    $_SESSION['password'] = PasswordGenerator::random_password();
                    alert_manipulation::alert([
                        'title' => "Information importante",
                        'msg' => "Le mot de passe va être réinitialisé. Le nouveau mot de passe est : <br><b> ". $_SESSION['password'] . "</b><br>Ce mot de passe ne pourra plus être consulté. Mémorisez-le avant de valider ou revenez en arrière.",
                        'direction' => 'index.php?preferences=reset-password&cle_utilisateur=' . $_GET['cle_utilisateur'],
                        'confirm' => true
                    ]);

                } else 
                    throw new Exception ('La clé utilisateur est nécessaire pour la réinitialisation du mot de passe !');
                break;

            // On affiche la formulaire de mise-à-jour d'un 
            case 'reset-password':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                if(isset($_GET['cle_utilisateur']) && !empty($_GET['cle_utilisateur']) && is_numeric($_GET['cle_utilisateur'])) {
                    $preferences->resetPassword($_SESSION['password'], $_GET['cle_utilisateur']);
                    unset($_SESSION['password']);

                } else 
                    throw new Exception ('La clé utilisateur est nécessaire pour la réinitialisation du mot de passe !');
                break;    

            // On affiche le formulaire de mise-à-jour du mot de passe    
            case 'edit-password':
                $preferences->displayEdit();
                break; 
            
            // On met-à-jour le mot de passe de l'utilisateur    
            case 'update-password':
                // On vérifie l'intégrité des données du formulaire
                try {
                    if(empty($_POST['password']) || empty($_POST['new-password']) || empty($_POST['confirmation']))
                        throw new Exception('Tous les champs doivent être rempli pour mettre le mot de passe à jour !');
                    elseif($_POST['new-password'] != $_POST['confirmation'])
                        throw new Exception('Le nouveau mot de passe et sa confirmation doivent être identiques !');

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de la mise-à-jour du mot de passe", 
                        'msg' => $e
                    ]);
                }

                // On met-à-jour le mot de passe
                $preferences->updatePassword($_POST['password'], $_POST['new-password']);
                break;    

            // On affiche la liste des utilisateurs
            case 'liste-utilisateurs':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayUtilisateurs();
                break;

            // On affiche le formulaire d'ajout d'utilisateurs
            case 'saisie-utilisateur':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displaySaisieUtilisateur();
                break;     

            // On prépare l'inscritpion du nouvel utilisateur
            case 'get-inscription-utilisateur':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                // On récupère les données du formulaire
                try {
                    $infos = [
                        'identifiant' => $_POST['identifiant'],
                        'nom' => forms_manip::nameFormat($_POST['nom']  ),
                        'prenom' => forms_manip::nameFormat($_POST['prenom']),
                        'email' => $_POST['email'],
                        'etablissement' => $_POST['etablissement'],
                        'role' => $_POST['role']
                    ];

                    if(empty($infos['identifiant']))
                        throw new Exception("Le champs identifiant doit être rempli.");
                    elseif(empty($infos['nom']))
                        throw new Exception("Le champs nom doit être rempli.");
                    elseif(empty($infos['prenom']))
                        throw new Exception("Le champs prenom doit être rempli.");
                    elseif(empty($infos['email']))
                        throw new Exception("Le champs email doit être rempli.");
                    elseif(empty($infos['etablissement']))
                        throw new Exception("Le champs étabissement doit être rempli.");
                    elseif(empty($infos['role']))
                        throw new Exception("Le champs role doit être rempli.");

                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'incription du nouvel utilisateur", 
                        'msg' => $e
                    ]);
                }

                // On génère le mot de passe de l'utilisateur
                $infos['mot de passe'] = PasswordGenerator::random_password();
                $_SESSION['new user data'] = $infos;
                alert_manipulation::alert([
                    'title' => "Information importante",
                    'msg' => "Le nouvel utilisateur va être créé avec le mot de passe suivant : <br><b> ". $infos['mot de passe'] . "</b><br>Ce mot de passe ne pourra plus être consulté. Mémorisez-le avant de valider la création du compte ou revenez en arrière.",
                    'direction' => 'index.php?preferences=inscription-utilisateur',
                    'confirm' => true
                ]);
                break;  
            
            // On inscrit un nouvel utilisateur
            case 'inscription-utilisateur':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                // On vérifie l'intégrité des données
                try {
                    if(isset($_SESSION['new user data']) && !empty($_SESSION['new user data'])) {
                        $infos = $_SESSION['new user data'];
                        unset($_SESSION['new user data']);
                    } else 
                        throw new Exception('Erreur lors de la récupération des informations du candidat, des informations sont manquantes.');
                    
                    if(empty($infos['identifiant']))
                        throw new Exception("Le champs identifiant doit être rempli.");
                    elseif(empty($infos['nom']))
                        throw new Exception("Le champs nom doit être rempli.");
                    elseif(empty($infos['prenom']))
                        throw new Exception("Le champs prenom doit être rempli.");
                    elseif(empty($infos['email']))
                        throw new Exception("Le champs email doit être rempli.");
                    elseif(empty($infos['etablissement']))
                        throw new Exception("Le champs étabissement doit être rempli.");
                    elseif(empty($infos['role']))
                        throw new Exception("Le champs role doit être rempli.");
                    elseif(empty($infos['mot de passe']))
                        throw new Exception("Mot de passe introuvable.");
    
                // On récupère les éventuelles erreurs        
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'incription du nouvel utilisateur", 
                        'msg' => $e,
                        'direction' => "index.php?preferences=saisie-utilisateur"
                    ]);
                } 

                // On génère le nouvel utilisateur
                $preferences->createUtilisateur($infos);
                break;

            // On affiche la liste des nouveaux utilisateurs
            case 'liste-nouveaux-utilisateurs':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayNouveauxUtilisateurs();
                break;    
            
            // On affiche l'historique de connexions des utilisateurs
            case 'connexion-historique':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayConnexionHistorique();
                break;  
            
            // On affiche l'historique d'actions des utilisateurs
            case 'action-historique':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayActionHistorique();
                break;    

            // On affiche la liste des postes de la fondation    
            case 'liste-postes':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayPostes();
                break;

            // On affiche le formulaire d'ajout de poste    
            case 'saisie-poste':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displaySaisiePoste();
                break;    

            // On inscrit un nouveau poste
            case 'inscription-poste':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                // On récupère les informations du formulaire
                try {
                    $infos = [
                        'poste' => $_POST['poste'],
                        'description' => $_POST['description']
                    ];

                    if(empty($infos['poste']))
                        throw new Exception("Le champs poste doit être rempli !");
                    if(empty($infos['description']))
                        throw new Exception("Le champs description doit être rempli !");

                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription du nouveau poste", 
                        'msg' => $e
                    ]);
                }

                $preferences->createPoste($infos);
                break;

            // On affiche la liste des services de la fondation
            case 'liste-services':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayServices();
                break;

            // On affiche le formulaire d'ajout de service
            case 'saisie-service': 
                $preferences->displaySaisieService();
                break;

            // On inscrit un nouveau service
            case 'inscription-service':
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
            
            // On affiche la liste des établissements de la fondation
            case 'liste-etablissements':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayEtablissements();
                break;

            // On affiche le formulaire d'ajout d'établissement
            case 'saisie-etablissement':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displaySaisieEtablissement();
                break;  
                
            // On inscrit un nouvel établissement
            case 'inscription-etablissement':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                // On récupère les données du formulaire
                try {
                    $infos = [
                        'intitule' => $_POST['intitule'],
                        'adresse' =>$_POST['adresse'],
                        'ville' => $_POST['ville'],
                        'code postal' => $_POST['code-postal'],
                        'pole' => $_POST['pole']
                    ];

                } catch (Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de l'établissement",
                        'msg' => $e
                    ]);
                }

                // On vérifie l'intégrité des données
                try {
                    if(empty($infos['intitule']))
                        throw new Exception('Le champs intitulé doit être rempli !');
                    elseif(empty($infos['adresse']))
                        throw new Exception('Le champs adresse doit être rempli !');
                    elseif(empty($infos['ville']))
                        throw new Exception('Le champs ville doit être rempli !');
                    elseif(empty($infos['code postal']))
                        throw new Exception('Le champs code postal doit être rempli !');
                    elseif(empty($infos['pole']))
                        throw new Exception('Le champs pôle doit être rempli !');

                } catch (Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription de l'établissement",
                        'msg' => $e
                    ]);
                }

                $preferences->createEtablissement($infos);
                break;

            // On affiche la listes des pôles de la fondation
            case 'liste-poles':
                if($_SESSION['user_role'] == INVITE)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displayPoles();
                break;

            // On affiche le formulaire d'ajout d'un pôle
            case 'saisie-pole':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                $preferences->displaySaisiePole();
                break;
                
            // On inscrit un nouveau pôle
            case 'inscription-pole':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                // On récupère les données du formulaire
                try {
                    $intitule = $_POST['intitule'];
                    $desc = $_POST['description'];
                } catch(Exception $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription du pôle",
                        'msg' => $e
                    ]);
                }

                // On vérifie l'intégrité des données
                try {
                    if(empty($intitule))
                        throw new Exception("Le champs intitulé doit être rempli !");
                    elseif(empty($desc))
                        throw new Exception("Le champs description doit être rempli !");

                } catch(Exception $e) {  
                    forms_manip::error_alert([
                        'title' => "Erreur lors de l'inscription du pôle",
                        'msg' => $e
                    ]);
                }

                // On inscrit le pôle
                $preferences->createPole($intitule, $desc);
                break;    

            // On affiche la liste des diplômes    
            case 'liste-diplomes': 
                break;
                
            // On affiche le formulaire d'ajout d'un diplome
            case 'saisie-diplome':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                break;
                
            // On inscrit un nouveau diplome
            case 'inscript-diplome':
                if($_SESSION['user_role'] != OWNER && $_SESSION['user_role'] != ADMIN)
                    throw new Exception("Accès refusé. Votre rôle est insufissant pour accéder à cette partie de l'application... ");

                break;    

            // On affiche les listes des autres données de la base de données (types de contrats, aides au recrutement, sources)    
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

} elseif(isset($_SESSION['user_key']) && !empty($_SESSION['user_key'])) {
    // On affiche la page d'accueil du site
    $home = new HomeController();
    $home->displayHome();

} else {
    // On affiche le formulaire de connexion
    $c = new LoginController();
    $c->displayLogin();
}