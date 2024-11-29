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


// * METHODES DE REQUETES A LA BASE DE DONNEES * //

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
    public function getEstablishments() {
        $request = "SELECT titled FROM Establishments ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the services list to the autocomplete items
     *
     * @return Void
     */
    public function getServices() {
        $request = "SELECT titled FROM Services ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the sources list to the autocomplete items
     *
     * @return Void
     */
    public function getSources() {
        $request = "SELECT titled FROM Sources ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the types of contracts list to the autocomplete items
     *
     * @return Void
     */
    public function getTypesOfContracts() {
        $request = "SELECT titled FROM Types_of_contracts ORDER BY titled";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the job lost to the autocomplete items
     *
     * @return Void
     */
    public function getJobs() {
        $request = "SELECT titled FROM jobs ORDER BY titled";
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
     * Public method returning the assistants list to autocomplete items
     *
     * @return Void
     */
    public function getHelps() {
        $request = "SELECT Id AS id, Titled AS text FROM Helps";
        return $this->get_request($request, [], false, true);
    }
    /**
     * Public method returning the candidate who have a job in the foundation list to autocomplete items
     *
     * @return Void
     */
    public function getEmployee() {
        $request = "SELECT 
        c.Id AS id,
        CONCAT(c.Name, ' ', c.Firstname) AS text

        FROM Candidates AS c
        INNER JOIN Contracts AS con ON c.Id = con.Key_Candidates

        WHERE con.SignatureDate IS NOT NULL
        AND (con.EndDate IS NULL OR con.EndDate > CURDATE())
        
        ORDER BY text";

        return $this->get_request($request, []);
    }
    /**
     * Public method returning the role liste without the owner
     *
     * @return Void
     */
    public function getRoles() {
        $request = "SELECT 
        Id AS id,
        Titled AS titled

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
        if(is_numeric($role)) 
            $request = "SELECT * FROM roles WHERE Id = :role";
        elseif(is_string($role)) 
            $request = "SELECT * FROM roles WHERE Titled = :role";
        else 
            throw new Exception("La saisie du rôle est mal typée. Le rôle doit être un identifiant (entier positif) ou une chaine de caractères !");

        $params = ["role" => $role];
        $result = $this->get_request($request, $params, true, true);

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
            $request = "SELECT * FROM qualifications WHERE id = :qualification";
            $params = ["qualification" => $qualification];

            $result = $this->get_request($request, $params, true, true);

        } elseif(is_string($qualification)) {
            $request = "SELECT * FROM qualifications WHERE titled = :qualification";
            $params = ["qualification" => $qualification];

            $result = $this->get_request($request, $params, true);

        } else 
            throw new Exception("La saisie du diplome est mal typée. Il doit être un identifiant (entier positif) ou un echaine de caractères !");      

        return $result;
    }
    /**
     * Protected method searching and returning the qualifications that the candidate get 
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    protected function searchGetQualificationsFromCandidates($key_candidate): ?Array {
        $request= "SELECT * FROM Get_qualifications WHERE key_Candidates = :key_candidate";
        $params = ['key_candidate' => $key_candidate];

        return $this->get_request($request, $params);
    }
    /**
     * Public method searching one job in the database
     *
     * @param Int|String $job The job primary key or intitule
     * @return Array
     */
    public function searchJobs($job): Array {
        if(is_numeric($job)) 
            $request = "SELECT * FROM Jobs WHERE Id = :job";    
        elseif(is_string($job)) 
            $request = "SELECT * FROM Jobs WHERE Titled = :job";
        else 
            throw new Exception("Erreur lors de la recherche de poste. La saisie du poste est mal typée. Il doit être un identifiant (entier positif) ou une chaine de caractères !");
        
        $params = ["job" => $job];

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
     * Protected method searching the helps that a candidate has the right to got
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    protected function searchHaveTheRightToFromCandidate($key_candidate): ?Array {
        $request = "SELECT * FROM Have_the_right_to WHERE Key_Candidates = :key_candidate";
        $params = ['key_candidate' => $key_candidate];

        return $this->get_request($request, $params);
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
    


// * INSCRIPT * //

    /**
     * protected method registering one user in the database
     *
     * @param Array $user The user's data Array
     * @return Void
     */
    protected function inscriptUsers($user=[]) {
        $request = "INSERT INTO Users (Id, Name, Firstname, Email, Password, Key_Establishments, Key_Roles)
                    VALUES (:identifier, :name, :firstname, :email, :password, :key_establishments, :key_roles)";
        $this->post_request($request, $user);
    }
    /**
     * Protected method registering one action in the database
     *
     * @param Int $key_user The user's primary key
     * @param Int $key_action The action primary key
     * @param String $description The action description
     * @throws Exception If the action's informtions is invalid or no complet
     * @return Void
     */
    protected function inscriptActions(&$key_user, &$key_action, $description=null) {
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
     * Protected method registering one candidate in the database
     *
     * @param Candidate $candidate The candidate's data 
     * @return Int
     */
    protected function inscriptCandidates(&$candidate): Int {
        $request = "INSERT INTO Candidates (Name, Firstname, Gender, Phone, Email, Address, City, PostCode, Availability";
        $values_request = " VALUES (:name, :firstname, :gender, :phone, :email, :address, :city, :post_code, :availability";

        if($candidate->getMedicalVisit()) {
            $request .= " , MedicalVisit";
            $values_request .= ", :visite";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);

        $this->post_request($request, $candidate->exportToSQL());
        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one Get_qualfications in the database
     *
     * TODO : Tester cette méthode
     * 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_qualification The degree primary key
     * @param Int $year The year of obtaining
     * @return Void
     */
    protected function inscriptGetQualifications($key_candidate, $key_qualification, $date) {
        $request = "INSERT INTO Get_qualifications (Key_Candidates, Key_Qualifications, Date) VALUES (:key_candidate, :key_qualification, :date)";
        $params = [
            "key_candidate"     => $key_candidate,
            "key_qualification" => $key_qualification,
            "date"              => $date
        ];

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one Have_the_right_to in the database
     *
     * TODO : Tester cette méthode
     * 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_helps The assistance primary key
     * @param Int $key_employee The recommander's primary key
     * @return Void
     */
    protected function inscriptHaveTheRightTo($key_candidate, $key_helps, $key_employee=null) {
        $request = "INSERT INTO Have_the_right_to (Key_Candidates, Key_Helps";
        $values_request = " VALUES (:key_candidate, :key_helps";
        $params = [
            'key_candidate' => $key_candidate,
            'key_helps'     => $key_helps
        ];

        if(!empty($key_employee)) {
            $request .= ", Key_Employee";
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
            "moment"            => date('Y-m-d H:i:s', $moment),
            "key_user"          => $key_user,
            "key_candidate"     => $key_candidate,
            "key_establishment" => $key_establishment
        ];
    
        $this->post_request($request, $params);
    }
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
            'key_candidate'        => $key_candidate,
            'key_job'              => $key_job,
            'key_service'          => $key_service,
            'key_establishment'    => $key_establishment,
            'key_type_of_contract' => $key_type_of_contract,
            'start_date'           => $start_date
        ];

        if(!empty($end_date)) {
            $request .= ", EndDate";
            $request_values .= ", :end_date";
            $params['end_date'] = $end_date;
        }
        if(!empty($signature_date)) {
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
     * Protected method registering one job in the database
     *
     * @param String $titled The job intitule
     * @param String $titledFeminin The job description
     * @return Void
     */
    protected function inscriptJobs(&$titled, &$titledFeminin) {
        $request = "INSERT INTO Jobs (Titled, TitledFeminin) VALUES (:titled, :titledFeminin)";
        $params = [
            "titled"        => $titled,
            "titledFeminin" => $titledFeminin
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
            'service'       => $service,
            'etablissement' => $cle_etablissement
        ];

        // On lance
        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one establishment
     *
     * @param Array<String> $data The establishment data Array 
     * @return Void
     */
    protected function inscriptEstablishments(&$data=[]) {
        $request = "INSERT INTO Establishments (Titled, Address, City, PostCode, Key_Poles) 
                    VALUES (:titled, :address, :city, :postcode, :key_poles)";
        $params = [
            'titled'    => $data['titled'],
            'address'   => $data['address'],
            'city'      => $data['city'],
            'postcode'  => $data['postcode'],
            'key_poles' => $data['key_poles']
        ];

        $this->post_request($request, $params);
    }
    /**
     * Protected method registering one hub in the database
     *
     * @param String $titled The hub titled
     * @param String $description The hub description
     * @return Void
     */
    protected function inscriptPoles(&$titled, &$description) {
        $request = "INSERT INTO Poles (Titled, Description) VALUES (:titled, :desc)";
        $params = [
            'titled' => $titled,
            'desc'   => $description
        ];

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


    // * UPDATE * // 

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
            'key'      => $_SESSION['user_key'],
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        
        // On lance la requête
        $this->post_request($request, $params);
    }
    /**
     * Public method updating one user's data
     *
     * @param Int $key_users The user's primary key
     * @param Array<String> $users The user's data Array
     * @return Void
     */
    public function updateUsers($key_users, $users=[]) {
        $request = "UPDATE Users
        SET Name = :name, Firstname = :firstname, Email = :email, Key_Roles = :role
        WHERE Id = :cle";
        $params = [
            'name'    => $users['name'],
            'firstname' => $users['firstname'],
            'email'  => $users['email'],
            'role'   => $users['role'],
            'cle'    => $key_users
        ];

        return $this->get_request($request, $params);
    }
    /**
     * public method updating one candidate's evaluation
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Array $notation The candidate's data Array
     * @return Void
     */
    public function updateRatings($key_candidate, &$rating=[]) {
        $request = "UPDATE Candidates SET Rating = :rating, Description = :description, A = :a, B = :b, C = :c WHERE Id = :key_candidate";
        $params = [
            'rating'        => $rating['notation'],
            'description'   => $rating['description'],
            'a'             => $rating['a'],
            'b'             => $rating['b'],
            'c'             => $rating['c'],
            'key_candidate' => $key_candidate
        ];

        $this->post_request($request, $params);
    }
    /**
     * Public method updating a candidate's data
     *
     * @param Int $key_candidate The candidate's primary key
     * @param String $name The candidate's name
     * @param String $firstname The candidate's firstname
     * @param String $email The candidate's email
     * @param String $phone The candidate's phone
     * @param String $address The candidate's addess
     * @param String $city The candidate's city
     * @param Int $post_code The candidate's post code
     * @return Void
     */
    public function updateCandidates($key_candidate, $name, $firstname, $email, $phone, $address, $city, $post_code) {
        $request = "UPDATE Candidates 
        SET Name = :name, Firstname = :firstname, Email = :email, Phone = :phone, Address = :address, City = :city, PostCode = :post_code
        Where Id = :key_candidate";
        $params = [
            'name'          => $name,
            'firstname'     => $firstname,
            'email'         => $email,
            'phone'         => $phone,
            'address'       => $address,
            'city'          => $city,
            'post_code'   => $post_code,
            'key_candidate' => $key_candidate
        ];

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
    public function updateMeetings($key_meeting, $key_user, $key_candidate, $key_establishment, $moment, $description) {
        $request = "UPDATE Meetings
        SET Key_Users = :key_user, Key_Candidates = :key_candidate, Key_Establishments = :key_establishment, Date = :moment, Description = :description
        WHERE Id = :key_meeting";
        $params = [
            'key_meeting'       => $key_meeting,
            'key_user'          => $key_user,
            'key_candidate'     => $key_candidate,
            'key_establishment' => $key_establishment,
            'moment'            => $moment,
            'description'       => $description
        ];

        $this->post_request($request, $params);
    }


    // * DELETE * //

    /**
     * protected method deleting one meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Void
     */
    protected function deleteMeetings($key_meeting) {
        $request = "DELETE FROM Meetings
        WHERE Id = :key_meeting";
        $params = ['key_meeting' => $key_meeting];

        $this->post_request($request, $params);
    }
    /**
     * Protected method deleting an Have_the_right_to 
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_help The help's primary key
     * @return Void
     */
    protected function deleteHaveTheRightTo($key_candidate, $key_help) {
        $request = "DELETE FROM Have_the_right_to WHERE Key_Candidates = :key_candidate AND Key_Helps = :key_help";
        $params = [
            'key_candidate' => $key_candidate,
            'key_help'      => $key_help
        ];

        $this->post_request($request, $params);
    }
    /**
     * Protected metho deleting a get_qualifications
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_qualifications The qualification's primary key
     * @return void
     */
    protected function deleteGetQualifications($key_candidate, $key_qualifications) {
        $request = "DELETE FROM Get_qualifications WHERE Key_Candidates = :key_candidate AND Key_Qualifications = :key_qualifications";
        $params = [
            'key_candidate'      => $key_candidate,
            'key_qualifications' => $key_qualifications
        ];

        $this->post_request($request, $params);
    }

    // * OTHER * //
    /**
     * Public method verifying if a service is in an establishment
     *
     * @param Int $key_services The service's primary key
     * @param Int $key_establishments The establishment's primary key
     * @return Bool
     */
    public function verifyServices($key_services, $key_establishments): Bool {
        return !empty($this->searchBelongTo($key_services, $key_establishments));
    }
    // public function verifyServices($key_services, $key_establishments): Bool {
    //     $request = "SELECT COUNT(*) AS count FROM Belong_to 
    //     WHERE Key_Services = :key_services AND Key_Establishments = :key_establishments";
    //     $params = [
    //         'key_services'       => $key_services,
    //         'key_establishments' => $key_establishments
    //     ];
    // 
    //     return $this->get_request($request, $params, true, true)['count'] > 0; 
    // }
}