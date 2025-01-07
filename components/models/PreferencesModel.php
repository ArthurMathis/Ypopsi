<?php 

require_once(MODELS.DS.'Model.php');
require_once(CLASSE.DS.'Moment.php');
require_once(CLASSE.DS.'Candidate.php');
require_once(CLASSE.DS.'User.php');
require_once(COMPONENTS.DS.'Passwordgenerator.php');

class PreferencesModel extends Model {
    // * GET * //
    /**
     * Public method returning the user's data profile
     *
     * @param Int $user_key The user's primary key
     * @return Array
     */
    public function getProfile(int $user_key): Array {
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
            forms_manip::error_alert(['msg' => $e]);
        }
        
        return $data;
    }
    /**
     * Public method returning the user's data
     *
     * @param Int $user_key The user's primary key
     * @return Array
     */
    public function getEditProfile(int $user_key): Array {
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
    public function getActionsHistory(): Array {
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
    public function getServices(): Array {
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
    public function getEstablishments(): Array {
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
    public function getPoles(): Array {
        $request = "SELECT 
        p.Titled AS Intitule,
        COUNT(e.Id) AS `Nombre d'établissements`,
        p.Description AS Description

        FROM Poles AS p
        LEFT JOIN Establishments AS e ON e.key_Poles = p.Id
        GROUP BY p.Id, p.Titled, p.Description";

        return $this->get_request($request);
    }

    // * CREATE * //
    /**
     * Public method creating a new user
     *
     * @param Array $data
     * @return Void
     */
    public function createUsers(array &$data) {
        $data['establishment'] = $this->searchEstablishments($data['establishment'])['Id'];
        $user = User::makeUser($data);
        unset($data);

        $this->inscriptUsers($user->exportToSQL());  
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouvel utilisateur",
            "Création du compte de " . strtoupper($user->getName()) . " " . forms_manip::nameFormat($user->getFirstname()) 
        );
    }

    //// Work ////
    /**
     * Public method creating a new jobs
     *
     * @param Array<String> $data The array containing the new jobs data
     * @return Void
     */
    public function createJobs(Array &$data) {
        $this->inscriptJobs($data['titled'], $data['titled feminin']);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau poste",
            "Ajout du poste " . $data['titled'] . " à la base de données"
        );
    }
    /**
     * Public method creating a new qualification
     *
     * @param String $titled The titled of the new qualification
     * @param Bool $medical_staff Boolean showing if the new qualification is for medical jobs or not
     * @param String|Null $abbreviation The abbreviation of the titled
     * @return Void
     */
    public function createQualifications(string $titled, bool $medical_staff = false, ?string $abbreviation = null) {
        $this->inscriptQualifications($titled, $medical_staff, $abbreviation);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau diplome",
            "Ajout de la qualification " . $titled . " à la base de données"
        );
    }

    //// Foundation ////
    /**
     * Public method creatng a  new service
     *
     * @param String $service The titled of the new service
     * @param Array<Int> $establishments The array containing th primary key of the establishments containing the new service
     * @param String|Null $description The description of the new service
     * @return Void
     */
    public function createServices(string $service, array $establishments, ?string $description = null) {
        $service = $this->inscriptServices($service, $description);
        foreach($establishments as $elmt) 
            $this->inscriptBelongTo($service, $elmt);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau service",
            "Ajout du service " . $this->searchServices($service)['Titled'] . "."
        );
    }
    /**
     * Public method creating a new establishments
     *
     * @param Array $data
     * @return Void
     */
    public function createEstablishments(array &$data) {
        $data['key_poles'] = $this->searchPoles($data['key_poles'])['Id']; // Todo : utiliser la nouvelle version de l'AutoComplete pour éviter la recherche et renvoyer directement la clé primaire
        $this->inscriptEstablishments(
            $_POST['intitule'],
            $_POST['adresse'],
            $_POST['ville'],
            $_POST['code-postal'],
            $_POST['pole']
        );
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouvel établissement",
            "Ajout de l'établissement " . $data['titled']
        );
    }
    /**
     * Public method creating a new poles
     *
     * @param String $titled The poles' titled 
     * @param String $description The poles' description
     */
    public function createPoles(string &$intitule, string &$description) {
        $this->inscriptPoles($intitule, $description);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Nouveau pôle",
            "Ajout du pôle " . $intitule
        );
    }

    // * OTHER * //
    /**
     * Public method checking if the input password is right
     *
     * @param String $password The password written in input
     * @return Void
     */
    public function verify_password(string &$password) {
        $request = "SELECT * FROM Users WHERE Id = :key";
        $params = ['key' => $_SESSION['user_key']];

        return password_verify($password, $this->get_request($request, $params, 1, 1)['Password']);
    }
    /**
     * Public method reinitializing the user's password
     *
     * @param String $password The user's new password
     * @param Int $key_users The user's primary key
     * @return Void
     */
    public function resetPassword(string $password, int $key_users) {
        $request = "UPDATE Users
        SET Password = :password, PasswordTemp = true
        WHERE Id = :key_users";
        $params = [
            'key_users' => $key_users,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        $this->post_request($request, $params);
    }

    /**
     * Public method registering the user's password update logs
     *
     * @return Void
     */
    public function updatePasswordLogs() {
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour mot de passe",
            strtoupper($_SESSION['user_name']) . " " . forms_manip::nameFormat($_SESSION['user_firstname']) . " a mis-à-jour son mot de passe"
        );
    }
    /**
     * Public method registering the user's data update logs
     *
     * @param Int $key_users The user's primary key
     * @return Void
     */
    public function updateUsersLogs(int $key_users) {
        $candidat = $this->searchUsers($key_users);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour utilisateur",
            "Mise-à-jour du profil de " . strtoupper($candidat['Name']) . " " . forms_manip::nameFormat($candidat['Firstname'])
        );
    }
    /**
     * Public method registering the user's password reset logs
     *
     * @param Int $key_users The user's primary key
     * @return Void
     */
    public function resetPasswordLogs(int $key_users) {
        $user = $this->searchUsers($key_users);
        $this->writeLogs(
            $_SESSION['user_key'],
            "Mise-à-jour mot de passe",
            "Le mot de passe de " . strtoupper($user['Name']) . " " . forms_manip::nameFormat($user['Firstname']) . " a été réinitialisé"
        );
    }
}