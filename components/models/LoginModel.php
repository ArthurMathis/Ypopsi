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
     * @brief Public method connecting the user to the application 
     * @param string $identifiant The user's id (ex: name.f)
     * @param string $motdepasse The user's password
     * @return void
     */
    public function connectUser($identifiant, $motdepasse) {
        $user = $this->verifyUser($identifiant, $motdepasse);
        
        $_SESSION['user_key']           = $user->getKey();
        $_SESSION['user_identifiant']   = $user->getIdentifier();
        $_SESSION['user_name']           = $user->getName();
        $_SESSION['user_firstname']        = $user->getFirstname();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_role']          = $user->getRole();
        $_SESSION['first_log_in']       = $user->getFirstLog();

        $this->writeLogs($_SESSION['user_key'], "Connexion");
    }
    /**
     * @brief Public method disconnecting hte current user to the application
     * @return void
     */
    public function deconnectUser() {
        try {
            if(isset($_SESSION['user_key']) && !empty($_SESSION['user_key']))
                $this->writeLogs($_SESSION['user_key'], 'Deconnexion');
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
     * @brief Private method searching the user's informations
     * @param string $identifier The user's id (ex: name.f)
     * @param string $password The user's password
     * @return Utilisateurs|null The user, if the informations are corrects and null,  if they aren't
     */
    private function verifyUser($identifier, $password): ?User{
        $request = "SELECT * FROM Users WHERE Identifier_Users = :identifier";
        $params = [":identifier" => $identifier];
        $users = $this->get_request($request, $params, false, true);

        // On déclare les variables tampons
        $i = 0;
        $size = $users != null ? count($users) : 0;    
        $find = false;  

        // On fait défiler la table
        while($i < $size && !$find) {
            if($users[$i]["Identifier_Users"] == $identifier && password_verify($password, $users[$i]["Password_Users"])) {
                // On implémente find
                $find = true;

                // On construit notre Utilisateur
                try {
                    $user = new User(
                        $users[$i]['Identifier_Users'], 
                        $users[$i]['Name_Users'],
                        $users[$i]['Firstname_Users'],
                        $users[$i]['Email_Users'], 
                        $password, 
                        $users[$i]['Key_Establishments'],
                        $users[$i]['Key_Roles']
                    );
                    $user->setKey($users[$i]['Id_Users']);
                    if($users[$i]['PasswordTemp_Users'])
                        $user->setFirstLog();

                // On récupère les éventuelles erreurs 
                } catch(InvalideUtilisateurExceptions $e) {
                    forms_manip::error_alert([
                        'title' => "Erreur d'identification",
                        'msg' => $e
                    ]);
                }

                // On retourne notre utilisateur, la connexion est validée
                return $user;
            } 
            // On implémnte l'index
            $i++;
        }
        // Utilisateur introuvé, on signale l'erreur
        if($i == $size) 
            throw new Exception("Identifiant ou mot de passe incorrect !");
    }
}