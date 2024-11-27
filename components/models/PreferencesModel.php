<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');
require_once(CLASSE.DS.'User.php');
require_once(COMPONENTS.DS.'Passwordgenerator.php');

class PreferencesModel extends Model {
    /**
     * Public method returning the user's data profile
     *
     * @param Int $user_key The user's primary key
     * @return Array
     */
    public function getProfil(&$user_key): Array {
        try {
            //// Profile ////
            $request = "SELECT 
            u.Id As id,
            u.Name AS name,
            u.Firstname AS firstname, 
            r.Titled AS titled_role, 
            r.Id AS role, 
            u.Email AS email, 
            e.Titled AS establishments

            FROM Users AS u
            INNER JOIN Roles AS r ON u.Key_Roles = r.Id
            INNER JOIN Establishments AS e on u.Key_Establishments = e.Id

            
            WHERE u.Id= :user_key";
            $params = ['user_key' => $user_key];

            $data = ['user' => $this->get_request($request, $params)[0]];

            //// Logs history ////
            $request = "SELECT
            t.Titled AS Action,
            DATE(a.Moment) AS Date,
            DATE_FORMAT(a.Moment, '%H:%i:%s') AS Hour

            FROM Actions AS a
            INNER JOIN Types_of_actions AS t ON a.Key_Types_of_actions = t.Id

            WHERE t.titled IN ('Connexion', 'Déconnexion')
            AND a.Key_Users = :user_key
            ORDER BY Date DESC";

            $data['logs'] = $this->get_request($request, $params);

            //// Actions history //// 
            $request = "SELECT
            t.Titled AS Action,
            DATE_FORMAT(a.Moment, '%Y-%m-%d') AS Date,
            DATE_FORMAT(a.Moment, '%H:%i:%s') AS Hour

            FROM Actions AS a
            INNER JOIN Types_of_actions AS t ON a.Key_Types_of_actions = t.Id

            WHERE t.titled NOT IN ('Connexion', 'Déconnexion')
            AND a.Key_Users = :user_key
            ORDER BY Date DESC";

            $data['actions'] = $this->get_request($request, $params);

        } catch(Exception $e) {
            forms_manip::error_alert($e);
        }
        
        return $data;
    }
    /**
     * Public method returning the user's data
     *
     * @param Int $user_key The user's primary key
     * @return Array
     */
    public function getEditProfile($user_key): Array {
        $request = "SELECT 
        u.Id AS id, 
        u.Name AS name,
        u.Firstname AS firstname, 
        r.Id AS role, 
        u.Email AS email

        FROM Users AS u
        INNER JOIN Roles AS r ON u.Key_Roles = r.Id
        
        WHERE u.Id = :user_key";
        $params = ['user_key' => $user_key];

        return  $this->get_request($request, $params, true, true);
    }

    /**
     * Public method returning the list of users
     * 
     * @return Array
     */
    public function getUsers(): Array {
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

        return $this->get_request($request);
    }
    /**
     * Public method returning the list of new users
     *
     * @return Void
     */
    public function getNewUsers() {
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
    public function getLogsHistory() {
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
     * Public method returning the actions history
     *
     * @return Array<String>
     */
    public function getActionsHistory() {
        $request = "SELECT
        t.titled AS Action,
        CONCAT(u.name, ' ', u.firstname) AS Utilisateur,
        DATE_FORMAT(a.moment, '%Y-%m-%d') AS Date,
        DATE_FORMAT(a.moment, '%H:%i:%s') AS Heure,
        a.description AS Description

        FROM Actions AS a
        INNER JOIN Users AS u ON a.key_Users = u.Id
        INNER JOIN Roles AS r ON u.key_Roles = r.Id
        INNER JOIN Types_of_actions AS t ON a.key_Types_of_actions = t.Id

        WHERE t.titled NOT IN ('Connexion', 'Déconnexion')

        ORDER BY Date DESC, Heure DESC";

        return $this->get_request($request);
    }
    /**
     * Public method returning the list of jobs
     *
     * @return Array<String>
     */
    public function getJobs(): Array {
        $request = "SELECT 
        Titled AS Intitulé,
        TitledFeminin AS 'Initutlé féminin'

        FROM Jobs
        
        ORDER BY Titled";
        
        return $this->get_request($request);
    }
    /**
     * Public method returning the list of jobs
     *
     * @return Array<String>
     */
    public function getQualifications(): Array {
        $request = "SELECT 
        Titled AS Intitulé, 
        CASE MedicalStaff WHEN 1 THEN 'Vrai' ELSE 'Faux' END AS 'Emploi du médical',
        Abreviation AS Abréviation
        
        FROM Qualifications
        
        ORDER BY Titled";
        
        return $this->get_request($request);
    }
    /**
     * Public method returning the list of jobs
     *
     * @return Array<String>
     */
    public function getServices() {
        $request = "SELECT 
        s.Titled AS Service,
        e.Titled AS Etablissement

        FROM Belong_to AS b
        
        INNER JOIN Services AS s ON b.Key_Services = s.Id
        INNER JOIN Establishments AS e ON b.Key_Establishments = e.Id
        
        ORDER BY Etablissement, Service";

        return $this->get_request($request);
    }
    /**
     * Public method returning the list of establishments
     *
     * @return Array<String>
     */
    public function getEstablishments() {
        $request = "SELECT 
        e.Titled AS Intitulé,
        p.Titled AS Pôle,
        e.Address AS Adresse,
        e.City AS Ville, 
        e.PostCode AS Code

        FROM Establishments  AS e
        LEFT JOIN Poles AS p ON e.Key_Poles = p.Id";

        return $this->get_request($request);
    }
    /**
     * Public method returning the list of establishments
     *
     * @return Array<String>
     */
    public function getPoles() {
        $request = "SELECT 
        p.Titled AS Intitule,
        COUNT(e.Id) AS `Nombre d'établissements`,
        p.Description AS Description

        FROM Poles AS p
        LEFT JOIN Establishments AS e ON e.key_Poles = p.Id
        GROUP BY p.Id, p.Titled, p.Description";

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
        $infos['pole'] = $this->searchPoles($infos['pole'])['Id_Poles'];

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
        $candidat = $this->searchUsers($cle_utilisateur);

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
        $user = $this->searchUsers($cle_utilisateur);
        // On enregistre les logs
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour mot de passe",
            "Le mot de passe de " . strtoupper($user['Nom_Utilisateurs']) . " " . forms_manip::nameFormat($user['Prenom_Utilisateurs']) . " a été réinitialisé"
        );
    }
}