<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'User.php');
require_once(CLASSE.DS.'Moment.php');

/**
 * Class representing the login model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class LoginModel extends Model {
    /**
     * Public method connecting the user to the application 
     * 
     * @param String $identifiant The user's id (ex: name.f)
     * @param String $motdepasse The user's password
     * @return Void
     */
    public function connectUser($identifiant, $motdepasse) {
        $user = $this->verifyUser($identifiant, $motdepasse);
        
        $_SESSION['user_key']           = $user->getKey();
        $_SESSION['user_identifier']    = $user->getIdentifier();
        $_SESSION['user_name']          = $user->getName();
        $_SESSION['user_firstname']     = $user->getFirstname();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_role']          = $user->getRole();
        $_SESSION['user_titled_role']   = $this->searchRole($user->getRole())['Titled'];
        $_SESSION['first_log_in']       = $user->getFirstLog();
        $_SESSION['key_establishment']  = $user->getEstablishment();

        $this->writeLogs($_SESSION['user_key'], "Connexion");
    }
    /**
     * Public method disconnecting hte current user to the application
     * 
     * @return Void
     */
    public function deconnectUser() {
        try {
            if(isset($_SESSION['user_key']) && !empty($_SESSION['user_key']))
                $this->writeLogs($_SESSION['user_key'], 'Déconnexion');
            else 
                throw new Exception("Inscription des logs impossible. Les données de l'utilisateur sont introuvables...");

            session_destroy();
    
        } catch(Exception $e) {
            forms_manip::error_alert([
                'msg' => $e,
                'direction' => 'index.php'
            ]);
        }
    }

    /**
     * Private method searching the user's informations
     * 
     * @param String $identifier The user's id (ex: name.f)
     * @param String $password The user's password
     * @return Utilisateurs|NULL The user, if the informations are corrects and null,  if they aren't
     */
    private function verifyUser($identifier, $password): ?User{
        $request = "SELECT * FROM Users WHERE Identifier = :identifier";
        $params = [":identifier" => $identifier];
        $users = $this->get_request($request, $params, false, true);

        $i = 0;
        $size = $users != null ? count($users) : 0;    
        $find = false;  
        while($i < $size && !$find) {
            if($users[$i]["Identifier"] == $identifier && password_verify($password, $users[$i]["Password"])) {
                $find = true;
                try {
                    $user = new User(
                        $users[$i]['Identifier'], 
                        $users[$i]['Name'],
                        $users[$i]['Firstname'],
                        $users[$i]['Email'], 
                        $password, 
                        $users[$i]['Key_Establishments'],
                        $users[$i]['Key_Roles']
                    );
                    $user->setKey($users[$i]['Id']);
                    if($users[$i]['PasswordTemp'])
                        $user->setFirstLog();

                } catch(InvalideUtilisateurExceptions $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur d'identification",
                        'msg' => $e
                    ]);
                }

                return $user;
            } 
            $i++;
        }

        if($i == $size) 
            throw new Exception("Identifiant ou mot de passe incorrect !");
    }
}