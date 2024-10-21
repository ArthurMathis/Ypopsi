<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');
require_once(CLASSE.DS.'User.php');
require_once(COMPONENTS.DS.'Passwordgenerator.php');

class PreferencesModel extends Model {
    /// Méthode publique retournant les informations du l'utilisateur actuelk
    public function getProfil(&$cle_utilisateur): array {
        // On récupère les informations de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT 
            u.Id As Cle,
            u.Name AS Nom,
            u.Firstname AS Prenom, 
            r.Titled AS Role, 
            u.Email AS Email,
            LENGTH(u.Password) AS 'Mot de passe'

            FROM Users AS u
            INNER JOIN Roles AS r ON u.Key_Roles = r.Id
            
            WHERE u.Id= :cle";
            $params = ['cle' => $cle_utilisateur];

            // On implémente les données
            $infos = ['utilisateur' => $this->get_request($request, $params)[0]];

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }


        // On récupère l'historique de connexions de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT
            t.Titled AS Action,
            a.Moment AS Date

            FROM Actions AS a
            INNER JOIN Types_of_actions AS t ON a.Key_Types_of_actions = t.Id

            WHERE t.titled IN ('Connexion', 'Déconnexion')
            AND a.Key_Users = :cle
            ORDER BY Date DESC";

            // On implémente les données
            $temp = $this->get_request($request, $params);
            foreach($temp as $item) {
                $item['Hour'] = date('H:i:s', strtotime($item['Date']));
                $item['Date'] = date('Y-m-d', strtotime($item['Date']));
            }
            $infos['connexions'] = $temp;

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        

        // On récupère l'historique d'actions de l'utilisateur
        try {
            // On initialise la requête
            $request = "SELECT
            t.Titled AS Action,
            a.Moment AS Date

            FROM Actions AS a
            INNER JOIN Types_of_actions AS t ON a.Key_Types_of_actions = t.Id

            WHERE t.titled NOT IN ('Connexion', 'Déconnexion')
            AND a.Key_Users = :cle
            ORDER BY Date DESC";

            // On implémente les données
            $infos['actions'] = $this->get_request($request, $params);

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
    
        // On retourne les données
        return $infos;
    }
    public function getEditProfil($cle_utilisateur): array {
        // On initialise la requête
        $request = "SELECT 
        Id_Utilisateurs AS cle, 
        Nom_Utilisateurs AS nom,
        Prenom_Utilisateurs AS prenom, 
        Id_Role AS role, 
        Email_Utilisateurs AS email

        FROM Utilisateurs AS u
        INNER JOIN Roles AS r ON u.Cle_Roles = r.Id_Role
        
        WHERE u.Id_Utilisateurs = :cle";
        $params = ['cle' => $cle_utilisateur];

        // On lance la requête
        return  $this->get_request($request, $params, true, true);
    }

    /**
     * Public method returning the list of users
     *
     * @return Void
     */
    public function getUtilisateurs() {
        // On initialise la requête 
        $request = "SELECT 
        u.Id AS Cle,
        r.Titled AS Role,
        u.Name AS Nom, 
        u.Firstname AS Prenom,
        u.Email AS Email,
        e.Titled AS Etablissement

        FROM Users AS u
        INNER JOIN Roles AS r ON u.Key_Roles = r.Id
        INNER JOIN Establishments AS e ON u.Key_Establishments = e.Id

        ORDER BY Role, Cle";

        // On lance la requête
        return $this->get_request($request);
    }
    /**
     * Public method returning the list of new users
     *
     * @return Void
     */
    public function getNouveauxUtilisateurs() {
        // On initialise la requête
        $request = "SELECT
        u.Id AS Cle,
        r.Titled AS Role,
        u.Name AS Nom, 
        u.Firstname AS Prenom,
        u.Email AS Email,
        e.Titled AS Etablissement

        FROM Users AS u
        INNER JOIN Roles AS r ON u.Key_Roles = r.Id
        INNER JOIN Establishments AS e ON u.Key_Establishments = e.Id

        WHERE u.PasswordTemp = 1
        
        ORDER BY Role";

        // On lance la requête
        return $this->get_request($request);
    }
    /**
     * Public method returning the connexion logs
     *
     * @return Void
     */
    public function getConnexionHistorique() {
        $request = "SELECT
        t.titled AS Action,
        r.titled AS Role,
        u.name AS Nom,
        u.firstname AS Prenom, 
        a.moment AS Date

        FROM Actions AS a
        INNER JOIN Users AS u ON a.key_Users = u.Id
        INNER JOIN Roles AS r ON u.key_Roles = r.Id
        INNER JOIN Types_of_actions AS t ON a.key_Types_of_actions = t.Id

        WHERE t.titled IN ('Connexion', 'Déconnexion')

        ORDER BY Date DESC";

        $temp = $this->get_request($request);
        foreach ($temp as &$row) {
            $datetime = new DateTime($row['Date']);
            $row['Date'] = $datetime->format('Y-m-d');
            $row['Heure'] = $datetime->format('H:i:s');
        }

        return $temp;
    }
    /**
     * Public method returning the action logs
     *
     * @return Void
     */
    public function getActionHistorique() {
        // On initialise la requête
        $request = "SELECT
        t.titled AS Action,
        CONCAT(u.name, ' ', u.firstname) AS Utilisateur,
        a.moment AS Date,
        a.description AS Description

        FROM Actions AS a
        INNER JOIN Users AS u ON a.key_Users = u.Id
        INNER JOIN Roles AS r ON u.key_Roles = r.Id
        INNER JOIN Types_of_actions AS t ON a.key_Types_of_actions = t.Id

        WHERE t.titled NOT IN ('Connexion', 'Déconnexion')

        ORDER BY Date DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /**
     * Public method returning the listes of roles
     *
     * @return Void
     */
    public function getRoles() {
        $request = "SELECT 
        Id AS id,
        titled AS role

        FROM Roles

        ORDER BY id DESC";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique retournant les postes de la base de données
    public function getPostes() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Postes AS Poste,
        Description_Postes AS Description

        FROM Postes";
        
        return $this->get_request($request);
    }
    /// Méthode publique retournant les services de la base de données
    public function getServices() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Services AS Service,
        Intitule_Etablissements AS Etablissement

        FROM Services AS s
        
        INNER JOIN Etablissements AS e ON s.cle_Etablissements = e.Id_Etablissements
        
        ORDER BY Service, Etablissement";
        
        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique retournant les services de la base de données
    public function getEtablissements() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Etablissements AS Intitule,
        Adresse_Etablissements AS Adresse,
        Ville_Etablissements AS Ville, 
        CodePostal_Etablissements AS Code,
        Intitule_Poles AS Pôle

        FROM Etablissements  AS e
        LEFT JOIN Poles AS p ON e.Cle_Poles = p.Id_Poles";

        // On lance la requête
        return $this->get_request($request);
    }
    /// Méthode publique retournant les pôles de la base de données
    public function getPoles() {
        // On initialise la requête
        $request = "SELECT 
        Intitule_Poles AS Intitule,
        Description_Poles AS Description,
        COUNT(e.Id_Etablissements) AS `Nombre d'établissements`

        FROM Poles AS p
        LEFT JOIN Etablissements AS e ON e.Cle_Poles = p.Id_Poles
        GROUP BY p.Id_Poles, p.Intitule_Poles, p.Description_Poles";

        // On lance la requête
        return $this->get_request($request);
    }

    /// Méthode publique générant un nouvel Utilisateur
    public function createUser(&$infos=[]) {
        // On récupère l'établissement
        $infos['etablissement'] = $this->searchEtablissement($infos['etablissement'])['Id_Etablissements'];

        // On génère un mot de passe
        // $infos['mot de passe'] = PasswordGenerator::random_password($infos['nom'], $infos['prenom']);

        // On crée l'utilisateur
        $user = Utilisateurs::makeUtilisateurs($infos);
        unset($infos);

        // On inscrit l'Utilisateur
        $this->inscriptUtilisateurs($user->exportToSQL());  
        
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouvel utilisateur",
            "Création du compte de " . strtoupper($user->getNom()) . " " . forms_manip::nameFormat($user->getPrenom()) 
        );
    }
    /// Méthode publique générant un nouveau poste
    public function createPoste(&$infos=[]) {
        // On inscrit le nouveau poste
        $this->inscriptPoste($infos['poste'], $infos['description']);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau poste",
            "Ajout du poste " . $infos['poste'] . " à la base de données"
        );
    }
    /// Méthode publique générant un nouveau service
    public function createService(&$service, &$etablissement) {
        // On récupère l'établissement
        $etablissement = $this->searchEtablissement($etablissement);

        // On inscrit le service
        $this->inscriptService($service, $etablissement['Id_Etablissements']);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau service",
            "Ajout du service " . $service . " dans l'établissement " . $etablissement['Intitule_Etablissements']
        );
    }
    /// Méthode publique générant un nouvel établissement
    public function createEtablissement(&$infos=[]) {
        // On récupère le pôle
        $infos['pole'] = $this->searchPole($infos['pole'])['Id_Poles'];

        // On inscrit l'établissement
        $this->inscriptEtablissement($infos);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouvel établissement",
            "Ajout de l'établissement " . $infos['intitule']
        );
    }
    /// Méthode publique générant un nouveau pôle
    public function createPole(&$intitule, &$description) {
        // On inscrit le pôle
        $this->inscriptPole($intitule, $description);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau pôle",
            "Ajout du pôle " . $intitule
        );
    }
    /**
     * Public method checking if the input password is right
     *
     * @param String $password The password written in input
     * @return Void
     */
    public function verify_password(&$password) {
        $request = "SELECT * FROM Users WHERE Id = :key";
        $params = ['key' => $_SESSION['user_key']];

        return password_verify($password, $this->get_request($request, $params, 1, 1)['Password']);
    }
    /// Méthode publique réinitialisant le mot de passe d'un utilisateur
    public function resetPassword($password, $cle_utilisateur) {
        // On initialise la requête
        $request = "UPDATE Utilisateurs
        SET MotDePasse_Utilisateurs = :password, MotDePassetemp_Utilisateurs = true
        WHERE Id_Utilisateurs = :cle";
        $params = [
            'cle' => $cle_utilisateur,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // On lance la requête
        $this->post_request($request, $params);
    }

    /// Méthode publique enregistrant les mise-à-jour de mots de passe dans les logs
    public function updatePasswordLogs() {
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour mot de passe",
            strtoupper($_SESSION['user_name']) . " " . forms_manip::nameFormat($_SESSION['user_firstname']) . " a mis-à-jour son mot de passe"
        );
    }
    public function updateUserLogs($cle_utilisateur) {
        // On récupère les données du candidat
        $candidat = $this->searchUser($cle_utilisateur);

        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour utilisateur",
            "Mise-à-jour du profil de " . strtoupper($candidat['Nom_Utilisateurs']) . " " . forms_manip::nameFormat($candidat['Prenom_Utilisateurs'])
        );
    }
    /// Méthode publique enregistrant les réinitialisations de mots de passe dans les logs
    public function resetPasswordLogs($cle_utilisateur) {
        // On récpère l'utilisateur
        $user = $this->searchUser($cle_utilisateur);
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour mot de passe",
            "Le mot de passe de " . strtoupper($user['Nom_Utilisateurs']) . " " . forms_manip::nameFormat($user['Prenom_Utilisateurs']) . " a été réinitialisé"
        );
    }
}