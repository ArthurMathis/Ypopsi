<?php 

/**
 * Abstract class representing a model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
abstract class Model {
    /**
     * Private attribute containing the database connection
     */
    private $connection;

    /**
     * Class' constructor
     */
    public function __construct() {
        $this->makeConnection();
    }

    /**
     * Protected method connecting the application to the database
     */
    protected function makeConnection() {
        try {
            $db_connection  = getenv('DB_CONNEXION');
            $db_host        = getenv('DB_HOST');
            $db_port        = getenv('DB_PORT');
            $db_name        = getenv('DB_NAME');
            $db_user        = getenv('DB_USER');
            $db_password    = getenv('DB_PASS');
    
            // Supprimez le slash dans la valeur de DB_HOST
            $db_host = str_replace('/', '', $db_host);
    
            $db_fetch = "$db_connection:host=$db_host;port=$db_port;dbname=$db_name";

            $this->connection = new PDO($db_fetch, $db_user, $db_password, Array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            die("Connexion à la base de données réchouée. " . $e->getMessage());
        }
        return $this->connection;
    }
    /**
     * Protected method returning the database connection
     */
    protected function getConnection() { return $this->connection; }
    /**
     * Protected method recording application logs
     * 
     * @param Int $user_key The user identification key in the database
     * @param String $action The action title
     * @param String optionnal $description The action description 
     * @return Void
     */
    protected function writeLogs(&$user_key, $action, $description=null) {
        try {
            $this->inscriptActions(
                $user_key, 
                $this->serachTypesOfActions($action)['Id'], 
                $description
            );

        } catch (Exception $e) {
            forms_manip::error_alert([
                'title' => "Erreur lors de l'enregistrement des logs",
                'msg' => $e
            ]);
        }
    }


    // METHODES DE REQUETES A LA BASE DE DONNEES //
    

    /**
     * Private method checking the request parameters
     * 
     * @param String $request The SQL request
     * @param Array<String> $params The request data Array
     * @return Boolean TRUE if the request executed successfully, FALSE otherwise
     */
    private function test_data_request(&$request, &$params=[]): Bool {
        if(empty($request) || !is_string($request)) 
            throw new Exception("La requête doit être passée en paramètre !");
        elseif(!is_Array($params))
            throw new Exception("Les données de la requête doivent être passsée en paramètre !");
    
        return true;
    }
    /**
     * Private method executing a GET request to the database
     *
     * @param String $request The SQL request
     * @param Array<String> $params The request data parameters
     * @param Boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param Boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return Array|null
     */
    protected function get_request($request, $params = [], $unique=false, $present=false): ?Array {
        if(empty($unique) || !is_bool($unique) || empty($present) || !is_bool($present))  
            $present = false;
    
        if($this->test_data_request($request, $params)) try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);

            if($unique) 
                $result = $query->fetch(PDO::FETCH_ASSOC);
            else 
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(empty($result)) {
                if($present) 
                    throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
                
                else 
                    return null;
    
            } else 
                return $result;
    
        } catch(Exception $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 

        return null;
    }
    /**
     * Private method executing a POST request to the database
     *
     * @param String  $request The SQL request
     * @param Array<String>  $params The request data Array
     * @return Bool
     */
    protected function post_request(&$request, $params=[]): Bool {
        $res = true;
    
        if(!$this->test_data_request($request, $params)) 
            $res = false;
    
        else try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);

        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 
    
        return $res;
    }


    // * GET * //
    /**
     * Public method returning the users list to autocomplete items
     *
     * @return Array
     */
    public function getAutoCompUsers(): Array {
        $request = "SELECT CONCAT(Name, ' ', Firstname) as name FROM Users ORDER BY name";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Void
     */
    public function getAutoCompEstablishments() {
        $request = "SELECT titled FROM Establishments ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the candidate who have a job in the foundation list to autocomplete items
     *
     * @return Void
     */
    public function getEmployee() {
        $request = "SELECT 
        CONCAT(c.Name, ' ', c.Firstname) AS text

        FROM Candidates AS c
        INNER JOIN Contracts AS con ON c.Id = con.Key_Candidates

        WHERE con.SignatureDate IS NOT NULL
        AND (con.EndDate IS NULL OR con.EndDate > CURDATE())";

        return $this->get_request($request, []);
    }
    /**
     * Public method returning the assistants list to autocomplete items
     *
     * @return Void
     */
    public function getHelps() {
        $request = "SELECT Id AS id, Titled AS text FROM Helps";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Void
     */
    public function getQualifications() {
        $request = "SELECT Titled AS text FROM Qualifications";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the job lost to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompJobs() {
        $request = "SELECT titled FROM jobs ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the services list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompServices() {
        // On inititalise la requête
        $request = "SELECT titled FROM Services ORDER BY titled";
        
        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the types of contracts list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompTypesOfContracts() {
        // On initialise la requête
        $request = "SELECT titled FROM Types_of_contracts ORDER BY titled";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the sources list to the autocomplete items
     *
     * @return Void
     */
    public function getAutoCompSources() {
        // On initialise la requête
        $request = "SELECT titled FROM Sources ORDER BY titled";

        // On lance la requête
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the role liste without the owner
     *
     * @return Void
     */
    public function getAccessibleRoles() {
        $request = "SELECT 
        Id_Role AS id,
        Intitule_Role AS text

        FROM Roles";

        return $this->get_request($request);
    }



    // * SEARCH * //

    /**
     * Protected method searching one hub in the database
     *
     * @param Int|String $pole The hub primary key or intitule
     * @return Array
     */
    protected function searchPoles($pole): Array {
        if(is_numeric($pole))
            $request = "SELECT * FROM Poles WHERE Id = :pole";
        elseif(is_string($pole))
            $request = "SELECT * FROM Poles WHERE Titled = :pole";  
        else 
            throw new Exception("paramètre invalide");

        $params = ['pole' => $pole];

        return $this->get_request($request, $params, true, true);    
    }
    /**
     * Public method searching one establishment 
     *
     * @param Int|String $establishment The establishment primary key or intitule 
     * @return Array
     */
    public function searchEstablishments($establishment): Array {
        if(is_numeric($establishment)) 
            $request = "SELECT * FROM Establishments WHERE Id = :establishment";
        elseif(is_string($establishment)) 
            $request = "SELECT * FROM Establishments WHERE Titled = :establishment";
        else 
            throw new Exception("Type invalide. La clé primaire (int) ou son intitulé (string) sont nécessaires pour rechercher un établissment !");

        $params = ['establishment' => $establishment];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one service in the database
     *
     * @param Int|String $service The service primary key or intitule
     * @return Array
     */
    public function searchServices($service): Array {
        if(is_numeric($service))
            $request = "SELECT * FROM Services WHERE Id = :service";
        elseif(is_string($service))
            $request =  "SELECT * FROM Services WHERE Titled = :service";
        else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");

        $params = ['service' => $service];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching and returning one BelongTo
     *
     * @param Int $key_service The service's primary key
     * @param Int $key_establishment The establishment's primary key
     * @return Array|NULL
     */
    protected function searchBelongTo($key_service, $key_establishment): ?Array {
        $request = "SELECT * FROM Belong_to WHERE Key_Services = :key_service AND Key_Establishments = :key_establishment";
        $params = [
            'key_service' => $key_service,
            'key_establishment' => $key_establishment
        ];

        return $this->get_request($request, $params, true);
    }
    
    /**
     * Public method search one user in the database
     * 
     * @param Int|String $user The user's primary key or identifier
     * @return Array
     */ 
    public function searchUsers($user): Array {
        if($user == null)
            throw new Exception("Le nom ou l'identifiant de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");

        $params = ['user' => $user];
        if(is_numeric($user)) {
            $request = "SELECT * FROM Users WHERE Id = :user";
            return $this->get_request($request, $params, true, true);

        } elseif(is_string($user)) {
            $request = "SELECT * FROM Users WHERE Identifier = :user";
            return $this->get_request($request, $params, true, true);

        } else 
            throw new Exception("Le type n'a pas pu être reconnu. Le nom (string) ou l'identifiant (int) de l'utilisateur sont nécessaires pour le rechercher dans la base de données !");
    }
    /**
     * Protected method searching one role in the database
     *
     * @param Int|String $role The role primary key or intitule
     * @return Array
     */
    protected function searchRole($role): Array {
        // On initialise la requête
        if(is_numeric($role)) {
            $request = "SELECT * FROM roles WHERE Id_Role = :Id";
            $params = ["Id" => $role];

        } elseif(is_string($role)) {
            $request = "SELECT * FROM roles WHERE Intitule_Role = :Intitule";
            $params = ["Intitule" => $role];

        } else 
            throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou une chaine de caractères !");

        // On lance la requête
        $result = $this->get_request($request, $params, true, true);

        // On retourne le rôle
        return $result;
    }
    /**
     * Protected method searching one action type in the database
     * 
     * @param Int|String $action The type primary key or intitule
     * @return Array
     */
    protected function serachTypesOfActions($action): Array {
        if($action == null) 
            throw new Exception("Données éronnées. La clé action ou son intitulé sont nécessaires pour rechercher une action !");
        elseif(is_numeric($action)) 
            $request = "SELECT * FROM Types_of_actions WHERE Id = :action";
        elseif(is_string($action))
            $request = "SELECT * FROM Types_of_actions WHERE Titled = :action";
        else 
            throw new Exception('Type invalide. La clé action (int) ou son intitulé (string) sont nécessaires pour rechercher une action !');   

        $params = [ "action" => $action ];

        return $this->get_request($request, $params, true, true);
    }
    // TODO: Implémenter la methode //
    protected function searchActions(): Array { return []; }

    /**
     * Public method searching and returning one candidate from his primary key
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array
     */
    public function searchCandidates($key_candidate): Array {
        if(empty($key_candidate) || !is_numeric($key_candidate))
            throw new Exception("Impossible de rechercher un candidat sans sa clé primaire !");

        $request = "SELECT * FROM Candidates WHERE Id = :candidate";
        $params = ['candidate' => $key_candidate];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching a candidate with his name, his firstnam and his email address or his phone number
     * 
     * @param String $name The candidate's name
     * @param String $firstname The candidate's firstname
     * @param String $email The candidate's email
     * @param String $phone The candidate's phone number
     * @return The candidate
     */
    public function searchCandidatesByName($name, $firstname, $email): ?Array {
        $request = "SELECT * FROM Candidates WHERE name = :name AND firstname = :firstname AND email = :email";
        $params = [
            ":name" => $name,
            ":firstname" => $firstname, 
            ":email" => $email
        ];
        return $this->get_request($request, $params, true);
    }
    /**
     * Public method searching one candidate from one of his application in the database
     *
     * @param Int $cle The application primary key
     * @return Array
     */
    public function searchCandidatesFromApplications($key_application): Array {
        $request = "SELECT c.Id, c.Name, c.Firstname, c.Gender, c.Email, c.Phone, c.Address, c.City, c.PostCode,  c.Availability, c.MedicalVisit,  c.Rating, c.Description, c.Is_delete, c.A,  c.B,  c.C
        FROM Applications 
        INNER JOIN Candidates AS c ON Applications.Key_Candidates = c.Id
        WHERE Applications.Id = :key_application";
        $params = ['key_application' => $key_application];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one candidate from one of his contract in the database
     *
     * @param Int $key_contract The contract's primary key
     * @return Array
     */
    public function searchCandidatesFromContracts($key_contract): Array {
        $request = "SELECT * 
        FROM Contracts 
        INNER JOIN Candidates ON Contracts.Key_Candidates = Candidates.Id
        WHERE Contracts.Id = :key_contract";
        $params = ['key_contract' => $key_contract];

        return $this->get_request($request, $params, true, true);
    }  

    /**
     * Protected method searching one degree in the database 
     *
     * @param Int|String $diplome The degree primary key or intitule
     * @return Array
     */
    protected function searchQualifications($qualification): Array {
        if(is_numeric($qualification)) {
            $request = "SELECT * FROM qualifications WHERE id = :id";
            $params = ["id" => $qualification];

            $result = $this->get_request($request, $params, true, true);

        } elseif(is_string($qualification)) {
            $request = "SELECT * FROM qualifications WHERE id = :intitule";
            $params = ["intitule" => $qualification];

            $result = $this->get_request($request, $params, true);

        } else 
            throw new Exception("La saisie du diplome est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");        

        return $result;
    }
    /**
     * Public method searching one job in the database
     *
     * @param Int|String $job The job primary key or intitule
     * @return Array
     */
    public function searchJobs($key_job): Array {
        if(is_numeric($key_job)) 
            $request = "SELECT * FROM Jobs WHERE Id = :key_job";    
        elseif(is_string($key_job)) 
            $request = "SELECT * FROM Jobs WHERE Titled = :key_job";
        else 
            throw new Exception("Erreur lors de la recherche de poste. La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou une chaine de caractères !");
        
        $params = ["key_job" => $key_job];

        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method one source in the database
     *
     * @param Int|String $source The source primary key or intitule
     * @return Array
     */
    public function searchSources($source): Array {
        if(is_numeric($source)) 
            $request = "SELECT * FROM sources WHERE Id = :source";
        elseif(is_string($source)) 
            $request = "SELECT * FROM sources WHERE Titled = :source";
        else 
            throw new Exception("La saisie de la source est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        $params = ["source" => $source];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching and returning one meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Array The array containing the meeting's data
     */
    public function searchMeetings($key_meeting): Array {
        $request = "SELECT * FROM Meetings WHERE Id = :key_meeting";
        $params = ['key_meeting' => $key_meeting];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one assistance in the database
     *
     * @param Int|String $aide The assistance primary key or intitule
     * @return Array
     */
    protected function searchHelps($key_helps): Array {
        if(is_numeric($key_helps)) {
            $request = "SELECT * FROM Helps WHERE Id = :id";
            $params = ["id" => $key_helps];

            $result = $this->get_request($request, $params, true, true);

        } elseif(is_string($key_helps)) {
            $request = "SELECT * FROM Helps WHERE titled = :titled";
            $params = ["titled" => $key_helps];

            $result = $this->get_request($request, $params, true);

        } else 
            new Exception("La saisie de l'aide est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");        

        return $result;
    }

    /**
     * Public method searching one application in the database
     *
     * @param Int $application The application primary key
     * @return Array
     */
    public function searchApplications($key_application): Array {
        $request = "SELECT * FROM Applications WHERE Id = :key_application";
        $params = ['key_application' => $key_application];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one type of contracts in the database 
     *
     * @param Int|String $contract The types of contracts primary key or intitule
     * @return Array The array of Type of contract information
     */
    public function searchTypesOfContracts($contract): Array {
        if(is_numeric($contract)) {
            $request = "SELECT * FROM Types_of_contracts WHERE Id = :id";
            $params = ['id' => $contract];

        } elseif(is_string($contract)) {
            $request =  "SELECT * FROM Types_of_contracts WHERE titled = :titled";
            $params = ['titled' => $contract];

        } else 
            throw new Exception("La saisie du type de contrat est mal typée. Elle doit être un identifiant (entier positif) ou un echaine de caractères !");
        
        $result = $this->get_request($request, $params, true, true);

        return $result;
    }
    /**
     * Protected method searching one contract in the database
     *
     * @param Int $key_contract The contract's primary key
     * @return Array
     */
    protected function searchContracts(&$key_contract): Array {
        $request  = "SELECT * FROM Contracts WHERE Id = :key_contract";
        $params = ['key_contract' => $key_contract];

        return $this->get_request($request, $params, true, true);
    }
    


    // * METHODES D'INSCRIPTION DANS LA BASE DE DONNEES * //

    /**
     * protected method registering one user in the database
     *
     * @param Array $user The user's data Array
     * @return Void
     */
    protected function inscriptUtilisateurs($user=[]) {
        if(empty($user)) 
            throw new Exception("Impossible d'inscrire un Utilisateur. Données manquantes !");

        else {
            // On initialise la requête
            $request = "INSERT INTO utilisateurs (identifiant_utilisateurs, nom_utilisateurs, prenom_utilisateurs, email_utilisateurs, motdepasse_utilisateurs, Cle_Etablissements, Cle_Roles)
                        VALUES (:identifiant, :nom, :prenom, :email, :motdepasse, :cle_etablissement, :cle_role)";

            // On lance la requête
            $this->post_request($request, $user);
        }
    }
    /**
     * Protected method registering one action in the database
     *
     * @param Int $cle_user The user's primary key
     * @param Int $cle_action The action primary key
     * @param Int $cle_instant The instant primary key
     * @param String $description The action description
     * @throws Exception If the action's informtions is invalid or no complet
     * @return Void
     */
    protected function inscriptActions(&$key_user, &$key_action, $description=null) {
        if(empty($key_user) || !is_numeric($key_user))
            throw new Exception("La clé Utilisateur est nécessaire pour l'enregistrement d'une action !");
        elseif(empty($key_action) || !is_numeric($key_action))
            throw new Exception("La clé Action est nécessaire pour l'enregistrement d'une action !");
        
        if(!empty($description)) {
            $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions, Description) VALUES (:user_id, :type_id, :description)";
            $params = [
                "user_id" => $key_user,
                "type_id" => $key_action,
                'description' => $description
            ];

        } else {
            $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions) VALUES (:user_id, :type_id)";
            $params = [
                "user_id" => $key_user,
                "type_id" => $key_action,
            ];   
        }

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one candidate ine the database
     *
     * @param Candidatz $candidate The candidate's data 
     * @return Void
     */
    protected function inscriptCandidate(&$candidate) {
        $request = "INSERT INTO Candidates (Name, Firstname, Gender, Phone, Email, Address, City, PostCode, Availability";
        $values_request = " VALUES (:name, :firstname, :gender, :phone, :email, :address, :city, :post_code, :availability";

        if($candidate->getMedicalVisit()) {
            $request .= " , MedicalVisit";
            $values_request .= ", :visite";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);

        $this->post_request($request, $candidate->exportToSQL());
    }
    /**
     * Protected method registering one Get_qualfications in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_diplome The degree primary key
     * @return Void
     */
    protected function inscriptGetQualifications($key_candidate, $key_qualification) {
        $request = "INSERT INTO Get_qualifications (Key_Candidates, Key_Qualifications) VALUES (:key_candidate, :key_qualification)";
        $params = [
            "key_candidate" => $key_candidate, 
            "key_qualification" => $key_qualification
        ];

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Have_the_right_to in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_aide The assistance primary key
     * @param Int $cle_coopteur The recommander's primary key
     * @return Void
     */
    protected function inscriptHaveTheRightTo($key_candidate, $key_helps, $key_employee=null) {
        $request = "INSERT INTO Have_the_right_to (Key_Candidates, Key_Helps";
        $values_request = " VALUES (:key_candidate, :key_helps";
        $params = [
            'key_candidate' => $key_candidate,
            'key_helps' => $key_helps
        ];

        if(!empty($cle_coopteur)) {
            $request .= ", Cle_Coopteur";
            $values_request .= ", :key_employee";
            $params['key_employee'] = $key_employee;
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);
        
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one meeting in the database 
     *
     * @param Int $key_user The user's primary key (recruiter) 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_establishment The establishment primary key
     * @param Int $moment The meeting's moment timestamp
     * @return Void
     */
    protected function inscriptMeetings($key_user, $key_candidate, $key_establishment, $moment) {
        $request = "INSERT INTO Meetings (Date, Key_Users, Key_Candidates, Key_Establishments) VALUES (:moment, :key_user, :key_candidate, :key_establishment)";
        $params = [
            "moment" => date('Y-m-d H:i:s', $moment),
            "key_user" => $key_user,
            "key_candidate" => $key_candidate,
            "key_establishment" => $key_establishment
        ];
    
        $this->post_request($request, $params);
    }
    // TODO : séparation de la méthode CandidaturesModel::inscriptApplication en Model::inscriptApplication et CandiatureModel::createApplications //
    /**
     * Protected methood registering a new contract
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_job The job's primary key
     * @param Int $key_service The service's primary key
     * @param Int $key_establishment The establishment's primary key
     * @param Int $key_type_of_contract The type of contracts primary key
     * @param Int $start_date The start date timestamp
     * @param Int $end_date The end date timestamp
     * @param Int $signature_date The signature date timestamp
     * @param Int $salary The candidate's salary
     * @param Int $hourly_rate The number of hours to be completed in a working week
     * @param Bool $night_work If the candidate has to work on nights
     * @param Bool $wk_work If the candidate has to work on week-ends
     * @return Void
     */
    protected function inscriptContracts($key_candidate, $key_job, $key_service, $key_establishment, $key_type_of_contract, $start_date, $end_date = null, $signature_date = null, $salary = null, $hourly_rate = null, $night_work = null, $wk_work = null) {
        $request = "INSERT INTO Contracts (Key_Candidates, Key_Jobs, Key_Services, Key_Establishments, Key_Types_of_contracts, StartDate";
        $request_values = " VALUES (:key_candidate, :key_job, :key_service, :key_establishment, :key_type_of_contract, :start_date";
        $params = [
            'key_candidate' => $key_candidate,
            'key_job' => $key_job,
            'key_service' => $key_service,
            'key_establishment' => $key_establishment,
            'key_type_of_contract' => $key_type_of_contract,
            'start_date' => $start_date
        ];

        if(!empty($end_date)) {
            $request .= ", EndDate";
            $request_values .= ", :end_date";
            $params['end_date'] = $end_date;
        }
        if(!empty($end_signature_datedate)) {
            $request .= ", SignatureDate";
            $request_values .= ", :signature_date";
            $params['signature_date'] = $signature_date;
        }
        if(!empty($salary)) {
            $request .= ", Salary";
            $request_values .= ", :salary";
            $params['salary'] = $salary;
        }
        if(!empty($hourly_rate)) {
            $request .= ", HourlyRate";
            $request_values .= ", :hourly_rate";
            $params['hourly_rate'] = $hourly_rate;
        }
        if(!empty($night_work)) {
            $request .= ", NightWork";
            $request_values .= ", :night_work";
            $params['night_work'] = $night_work;
        }
        if(!empty($wk_work)) {
            $request .= ", WeekEndWork";
            $request_values .= ", :wk_work";
            $params['wk_work'] = $wk_work;
        }

        $request .= ')' . $request_values . ')';
        unset($request_values);

        $this->post_request($request, $params);
    }
    /**
     * Protected method regstering one Postuler_a in the database
     *
     * @param Int $candidat The candidate's primary key
     * @param Int $instant The instant primary key
     * @return Void
     */
    // protected function inscriptPostuler_a($candidat, $instant) {
    //     // On initialise la requête 
    //     $request = "INSERT INTO Postuler_a (Cle_Candidats, Cle_Instants) VALUES (:candidat, :instant)";
    //     $params = [
    //         "candidat" => $candidat, 
    //         "instant" => $instant
    //     ];
    // 
    //     // On lance la requête
    //     $this->post_request($request, $params);
    // }
    /**
     * Protected method registering one Appliquer_a ine the database
     *
     * @param Int $cle_candidature The application primary key
     * @param Int $cle_service The service primary key
     * @return Void
     */
    //protected function inscriptAppliquer_a($cle_candidature, $cle_service) {
    //    // On vérifie l'intégrité des données
    //    try {
    //        if(empty($cle_candidature) || empty($cle_service)) 
    //            throw new Exception('Données éronnées. Pour inscrire un Appliquer_a, la clé de candidature et la clé de service sont nécessaires');
    //
    //    } catch(Exception $e) {
    //        forms_manip::error_alert([
    //            'msg' => $e
    //        ]);
    //    }
    //    
    //    // On inititalise la requête
    //    $request = "INSERT INTO Appliquer_a (Cle_Candidatures, Cle_Services) VALUES (:candidature, :service)";
    //    $params = [
    //        "candidature" => $cle_candidature,
    //        "service" => $cle_service
    //    ];
    //
    //    // On exécute la requête
    //    $this->post_request($request, $params);
    //}
    
    /**
     * Protected method registerin one Proposer_a in the database
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $cle_instant The instant primary key
     * @return Void
     */
    // protected function inscriptProposer_a($cle_candidat, $cle_instant) {
    //     $request = "INSERT INTO Proposer_a (Cle_candidats, Cle_Instants) VALUES (:candidat, :instant)";
    //     $params = [
    //         'candidat' => $cle_candidat,
    //         'instant' => $cle_instant
    //     ];
    // 
    //     $this->post_request($request, $params);
    // }
    /**
     * Protected method registering one job in the database
     *
     * @param String $poste The job intitule
     * @param String $description The job description
     * @return Void
     */
    protected function inscriptPoste(&$poste, &$description) {
        $request = "INSERT INTO Postes (Intitule_Postes, Description_Postes) VALUES (:poste, :description)";
        $params = [
            "poste" => $poste,
            "description" => $description
        ];

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one service in the database
     *
     * @param String $service The service intitule
     * @param String $cle_etablissement The service description
     * @return Void
     */
    protected function inscriptService(&$service, $cle_etablissement) {
        // On initialise la requête 
        $request = "INSERT INTO Services (Intitule_Services, Cle_Etablissements) VALUES (:service, :etablissement)";
        $params = [
            'service' => $service,
            'etablissement' => $cle_etablissement
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one establishment
     *
     * @param Array<String> $infos The establishment data Array 
     * @return Void
     */
    protected function inscriptEtablissement(&$infos=[]) {
        // On initialise la requête 
        $request = "INSERT INTO Etablissements (Intitule_Etablissements, Adresse_Etablissements, Ville_Etablissements, CodePostal_Etablissements, Cle_Poles) 
        VALUES (:intitule, :adresse, :ville, :code, :pole)";
        $params = [
            'intitule' => $infos['intitule'],
            'adresse' => $infos['adresse'],
            'ville' => $infos['ville'],
            'code' => $infos['code postal'],
            'pole' => $infos['pole']
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one hub in the database
     *
     * @param String $intitule The hub intitule
     * @param String $description The hub description
     * @return Void
     */
    protected function inscriptPole(&$intitule, &$description) {
        // On initialise la requête 
        $request = "INSERT INTO Poles (Intitule_Poles, Description_Poles) VALUES (:intitule, :desc)";
        $params = [
            'intitule' => $intitule,
            'desc' => $description
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one degree in the database
     *
     * @param String $diplome The degree intitule
     * @return Void
     */
    protected function inscriptDiplome($diplome) {
        // On initialise la requête
        $request = "INSERT INTO Diplomes (Intitule_Diplomes) VALUES (:intitule)";
        $params = ["intitule" => $diplome];

        // On lance la requête
        $this->post_request($request, $params);
    }


    // METHODES DE MISE-A-JOUR // 

    /**
     * Public method updating one user's password 
     *
     * @param String $password The new user's password
     * @return Void
     */
    public function updatePassword(&$password) {
        // On initialise la requête
        $request = "UPDATE Users
        SET Password = :password, PasswordTemp = false
        WHERE Id = :key";
        $params = [
            'key' => $_SESSION['user_key'],
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one user's data
     *
     * @param Int $cle_utilisateur The user's primary key
     * @param Array<String> $user The user's data Array
     * @return Void
     */
    public function updateUser($cle_utilisateur, $user=[]) {
        // On initialise la requête
        $request = "UPDATE Utilisateurs 
        SET Nom_Utilisateurs = :nom, Prenom_Utilisateurs = :prenom, Email_Utilisateurs = :email, Cle_Roles = :role
        WHERE Id_Utilisateurs = :cle";
        $params = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role'],
            'cle' => $cle_utilisateur
        ];

        // On lance la requête
        return $this->get_request($request, $params);
    }
    /**
     * public method updating one candidate's evaluation
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Array $notation The candidate's data Array
     * @return Void
     */
    public function updateRating($key_candidate, &$rating=[]) {
        $request = "UPDATE Candidates SET Rating = :rating, Description = :description, A = :a, B = :b, C = :c WHERE Id = :key_candidate";
        $params = [
            'rating' => $rating['notation'],
            'description' => $rating['description'],
            'a' => $rating['a'],
            'b' => $rating['b'],
            'c' => $rating['c'],
            'key_candidate' => $key_candidate
        ];

        $this->post_request($request, $params);
    }
    /**
     * Public method updating a candidate's data
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Array<String> $candidat The cadidate's data Array
     * @return Void
     */
    public function updateCandidat($cle_candidat, $candidat=[]) {
        // On initialise la requête
        $request = "UPDATE Candidats 
        SET Nom_candidats = :nom, Prenom_Candidats = :prenom, Email_Candidats = :email, Telephone_Candidats = :telephone, Adresse_Candidats = :adresse, Ville_Candidats = :ville, CodePostal_Candidats = :code_postal
        Where Id_Candidats = :cle";
        $params = [
            'nom' => $candidat['nom'], 
            'prenom' => $candidat['prenom'], 
            'email' => $candidat['email'], 
            'telephone' => $candidat['telephone'], 
            'adresse' => $candidat['adresse'], 
            'ville' => $candidat['ville'], 
            'code_postal' => $candidat['code_postal'],
            'cle' => $cle_candidat
        ];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one candidate's meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @param Int $key_user
     * @param Int $key_candidate
     * @param Int $key_establishment
     * @param Int $moment
     * @param Int $description
     * @return Void
     */
    public function updateMeeting($key_meeting, $key_user, $key_candidate, $key_establishment, $moment, $description) {
        $request = "UPDATE Meetings
        SET Key_Users = :key_user, Key_Candidates = :key_candidate, Key_Establishments = :key_establishment, Date = :moment, Description = :description
        WHERE Id = :key_meeting";
        $params = [
            'key_meeting' => $key_meeting,
            'key_user' => $key_user,
            'key_candidate' => $key_candidate,
            'key_establishment' => $key_establishment,
            'moment' => $moment,
            'description' => $description
        ];

        $this->post_request($request, $params);
    }


    // METHODES DE SUPPRESSION //

    /**
     * protected method deleting one meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Void
     */
    protected function deleteMeeting($key_meeting) {
        $request = "DELETE FROM Meetings
        WHERE Id = :key_meeting";
        $params = ['key_meeting' => $key_meeting];

        $this->post_request($request, $params);
    }
    /**
     * Protected method deleting one instant
     *
     * @param Int $cle_instant The instant primary key
     * @return Void
     */
    protected function deleteInstant($cle_instant) {
        // On initialise la requête
        $request = "DELETE FROM Instants WHERE Id_Instants = :cle";
        $params = ['cle' => $cle_instant];

        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Protected method verifying if a service is in an establishment
     *
     * @param Int $key_service The service's primary key
     * @param Int $key_establishment The establishment's primary key
     * @return Bool
     */
    protected function verifyService($key_service, $key_establishment): Bool {
        
    }
}