<?php 

namespace App\Models;

use \PDO;
use \PDOException;
use \Exception;
use App\Core\FormsManip;
use App\Repository\Candidate;

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
    public function __construct() { $this->makeConnection(); }

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
     * Public method recording application logs
     * 
     * @param Int $user_key The user identification key in the database
     * @param String $action The action title
     * @param String|Null optionnal $description The action description 
     * @return Void
     */
    public function writeLogs(int $user_key, string $action, ?string $description = null) {
        try {
            $this->inscriptActions(
                $user_key, 
                $this->serachTypesOfActions($action)['Id'], 
                $description
            );

        } catch (Exception $e) {
            FormsManip::error_alert([
                'title' => "Erreur lors de l'enregistrement des logs",
                'msg' => $e
            ]);
        }
    }


// * METHODES DE REQUETES A LA BASE DE DONNEES * //

    /**
     * Private method executing a GET request to the database
     *
     * @param String $request The SQL request
     * @param Array<String> $params The request data parameters
     * @param Boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param Boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return Array|Null
     */
    protected function get_request(string $request, ?array $params = [], bool $unique = false, bool $present = false): ?Array { 
        if(empty($unique) || empty($present))  
            $present = false;

        try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);
            $result = $unique ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)) {
                if($present) 
                    throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
                else 
                    return null;
            } else 
                return $result;
    
        } catch(Exception $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } catch(PDOException $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        } 

        return null;
    }
    /**
     * Private method executing a POST request to the database
     *
     * @param String $request The SQL request
     * @param Array<String>  $params The request data Array
     * @return Int The primary key og the new element
     */
    protected function post_request(string $request, array $params): Int {
        try {
            $query = $this->getConnection()->prepare($request);
            $query->execute($params);
            $lastId = $this->getConnection()->lastInsertId();
            return $lastId;
    
        } catch(PDOException $e){
            FormsManip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        }
    }


    // * GET * //

    /**
     * Public method returning the users list to autocomplete items
     *
     * @return Array
     */
    public function getUsersForAutoComplete(): Array {
        $request = "SELECT Id as id, CONCAT(Name, ' ', Firstname) as text FROM Users ORDER BY name";
        return $this->get_request($request, null, false, true);
    }
    public function getPolesForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM Poles";
        return $this->get_request($request);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Array
     */
    public function getEstablishmentsForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM Establishments ORDER BY titled";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the services list to the autocomplete items
     *
     * @return Array
     */
    public function getServicesForAutoComplete(): Array {
        $request = "SELECT Id AS id, titled AS text FROM Services ORDER BY titled";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the sources list to the autocomplete items
     *
     * @return Array
     */
    public function getSourcesForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM Sources ORDER BY titled";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the types of contracts list to the autocomplete items
     *
     * @return Array
     */
    public function getTypesOfContractsForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM Types_of_contracts ORDER BY titled";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the job lost to the autocomplete items
     *
     * @return Array
     */
    public function getJobsForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM jobs ORDER BY titled";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the establishments list to autocomplete items
     *
     * @return Void
     */
    public function getQualificationsForAutoComplete() {
        $request = "SELECT Id AS id, Titled AS text FROM Qualifications";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the assistants list to autocomplete items
     *
     * @return Array
     */
    public function getHelpsForAutoComplete(): Array {
        $request = "SELECT Id as id, Titled AS text FROM Helps";
        return $this->get_request($request, null, false, true);
    }
    /**
     * Public method returning the candidate who have a job in the foundation list to autocomplete items
     *
     * @return Array|NULL
     */
    public function getEmployeeForAutoComplete(): ?Array {
        $request = "SELECT 
            c.Id AS id,
            CONCAT(c.Name, ' ', c.Firstname) AS text

            FROM Candidates AS c
            INNER JOIN Contracts AS con ON c.Id = con.Key_Candidates

            WHERE con.SignatureDate IS NOT NULL
            AND (con.EndDate IS NULL OR con.EndDate > CURDATE())
            
            GROUP BY text
            ORDER BY text";

        return $this->get_request($request);
    }
    /**
     * Public method returning the role liste without the owner
     *
     * @return Array
     */
    public function getRolesForAutoComplete(): Array {
        $request = "SELECT Id AS id, Titled AS text FROM Roles";
        return $this->get_request($request);
    }
// 
// 
// * SEARCH * //
// 
    /**
     * Protected method searching one hub in the database
     *
     * @param Int|String $pole The hub primary key or intitule
     * @return Array
     */
    protected function searchPoles(int|string $pole): Array {
        if(is_numeric($pole))
            $request = "SELECT * FROM Poles WHERE Id = :pole";
        elseif(is_string($pole))
            $request = "SELECT * FROM Poles WHERE Titled = :pole";  

        $params = ['pole' => $pole];

        return $this->get_request($request, $params, true, true);    
    }
    /**
     * Public method searching one establishment 
     *
     * @param Int|String $establishment The establishment primary key or intitule 
     * @return Array
     */
    public function searchEstablishments(int|string $establishment): Array {
        if(is_numeric($establishment)) 
            $request = "SELECT * FROM Establishments WHERE Id = :establishment";
        elseif(is_string($establishment)) 
            $request = "SELECT * FROM Establishments WHERE Titled = :establishment";

        $params = [ 'establishment' => $establishment ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one service in the database
     *
     * @param Int|String $service The service primary key or intitule
     * @return Array
     */
    public function searchServices(int|string $service): Array {
        if(is_numeric($service))
            $request = "SELECT * FROM Services WHERE Id = :service";
        elseif(is_string($service))
            $request =  "SELECT * FROM Services WHERE Titled = :service";

        $params = [ 'service' => $service ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching and returning one BelongTo
     *
     * @param Int $key_service The service's primary key
     * @param Int $key_establishment The establishment's primary key
     * @return Array|NULL
     */
    protected function searchBelongTo(int $key_service, int $key_establishment): ?Array {
        $request = "SELECT * FROM Belong_to WHERE Key_Services = :key_service AND Key_Establishments = :key_establishment";
        $params = [
            'key_service'       => $key_service,
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
    public function searchUsers(int|string $user): Array {
        if(is_numeric($user)) 
            $request = "SELECT * FROM Users WHERE Id = :user";
        elseif(is_string($user)) 
            $request = "SELECT * FROM Users WHERE Identifier = :user";

        $params = [ 'user' => $user ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one role in the database
     *
     * @param Int|String $role The role primary key or intitule
     * @return Array
     */
    protected function searchRole(int|string $role): Array {
        if(is_numeric($role)) 
            $request = "SELECT * FROM roles WHERE Id = :role";
        elseif(is_string($role)) 
            $request = "SELECT * FROM roles WHERE Titled = :role";
        
        $params = [ "role" => $role ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one action type in the database
     * 
     * @param Int|String $action The type primary key or intitule
     * @return Array
     */
    protected function serachTypesOfActions(int|string $action): Array {
        if(is_numeric($action)) 
            $request = "SELECT * FROM Types_of_actions WHERE Id = :action";
        elseif(is_string($action))
            $request = "SELECT * FROM Types_of_actions WHERE Titled = :action";   

        $params = [ "action" => $action ];

        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method searching and returning one candidate from his primary key
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array
     */
    public function searchCandidates(int $key_candidate): Array {
        $request = "SELECT * FROM Candidates WHERE Id = :key_candidate"; 

        $params = [ 'key_candidate' => $key_candidate ]; 

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one candidate from one of his application in the database
     *
     * @param Int $cle The application primary key
     * @return Array
     */
    public function searchCandidatesFromApplications(int $key_application): Array {
        $request = "SELECT c.Id, c.Name, c.Firstname, c.Gender, c.Email, c.Phone, c.Address, c.City, c.PostCode,  c.Availability, c.MedicalVisit,  c.Rating, c.Description, c.Is_delete, c.A,  c.B,  c.C
            FROM Applications 
            INNER JOIN Candidates AS c ON Applications.Key_Candidates = c.Id
            WHERE Applications.Id = :key_application";

        $params = [ 'key_application' => $key_application ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one candidate from one of his contract in the database
     *
     * @param Int $key_contract The contract's primary key
     * @return Array
     */
    public function searchCandidatesFromContracts(int $key_contract): Array {
        $request = "SELECT * 
            FROM Contracts 
            INNER JOIN Candidates ON Contracts.Key_Candidates = Candidates.Id
            WHERE Contracts.Id = :key_contract";

        $params = [ 'key_contract' => $key_contract ];

        return $this->get_request($request, $params, true, true);
    }  

    /**
     * Protected method searching one degree in the database 
     *
     * @param Int|String $diplome The degree primary key or intitule
     * @return Array
     */
    protected function searchQualifications(int|string $qualification): Array {
        if(is_numeric($qualification)) {
            $request = "SELECT * FROM qualifications WHERE id = :qualification";

            $params = [ "qualification" => $qualification ];

            $result = $this->get_request($request, $params, true, true);

        } elseif(is_string($qualification)) {
            $request = "SELECT * FROM qualifications WHERE titled = :qualification";

            $params = [ "qualification" => $qualification ];

            $result = $this->get_request($request, $params, true);
        }

        return $result;
    }
    /**
     * Protected method searching and returning the qualifications that the candidate get 
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    protected function searchGetQualificationsFromCandidates(int $key_candidate): ?Array {
        $request= "SELECT * FROM Get_qualifications WHERE key_Candidates = :key_candidate";

        $params = [ 'key_candidate' => $key_candidate ];

        return $this->get_request($request, $params);
    }
    /**
     * Public method searching one job in the database
     *
     * @param Int|String $job The job primary key or intitule
     * @return Array
     */
    public function searchJobs(int|string $job): Array {
        if(is_numeric($job)) 
            $request = "SELECT * FROM Jobs WHERE Id = :job";    
        elseif(is_string($job)) 
            $request = "SELECT * FROM Jobs WHERE Titled = :job";
        
        $params = [ "job" => $job ];

        return $this->get_request($request, $params, true, true);
    }

    /**
     * Public method one source in the database
     *
     * @param Int|String $source The source primary key or intitule
     * @return Array
     */
    public function searchSources(int|string $source): Array {
        if(is_numeric($source)) 
            $request = "SELECT * FROM sources WHERE Id = :source";
        elseif(is_string($source)) 
            $request = "SELECT * FROM sources WHERE Titled = :source";
        
        $params = [ "source" => $source ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching and returning one meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @return Array The array containing the meeting's data
     */
    public function searchMeetings(int $key_meeting): Array {
        $request = "SELECT * FROM Meetings WHERE Id = :key_meeting";

        $params = [ 'key_meeting' => $key_meeting ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Protected method searching one assistance in the database
     *
     * @param Int|String $aide The assistance primary key or intitule
     * @return Array
     */
    protected function searchHelps(int|string $key_helps): Array {
        if(is_numeric($key_helps)) {
            $request = "SELECT * FROM Helps WHERE Id = :id";

            $params = [ "id" => $key_helps ];

            $result = $this->get_request($request, $params, true, true);

        } elseif(is_string($key_helps)) {
            $request = "SELECT * FROM Helps WHERE titled = :titled";

            $params = [ "titled" => $key_helps ];

            $result = $this->get_request($request, $params, true);
        } 

        return $result;
    }
    /**
     * Protected method searching the helps that a candidate has the right to got
     *
     * @param Int $key_candidate The candidate's primary key
     * @return Array|NULL
     */
    protected function searchHaveTheRightToFromCandidate(int $key_candidate): ?Array {
        $request = "SELECT * FROM Have_the_right_to WHERE Key_Candidates = :key_candidate";

        $params = [ 'key_candidate' => $key_candidate ];

        return $this->get_request($request, $params);
    }
    /**
     * Public method searching one application in the database
     *
     * @param Int $application The application primary key
     * @return Array
     */
    public function searchApplications(int $key_application): Array {
        $request = "SELECT * FROM Applications WHERE Id = :key_application";

        $params = [ 'key_application' => $key_application ];

        return $this->get_request($request, $params, true, true);
    }
    /**
     * Public method searching one type of contracts in the database 
     *
     * @param Int|String $contract The types of contracts primary key or intitule
     * @return Array The array of Type of contract information
     */
    public function searchTypesOfContracts(int|string $contract): Array {
        if(is_numeric($contract)) {
            $request = "SELECT * FROM Types_of_contracts WHERE Id = :id";
            $params = [ 'id' => $contract ];

        } elseif(is_string($contract)) {
            $request =  "SELECT * FROM Types_of_contracts WHERE titled = :titled";
            $params = [ 'titled' => $contract ];
        }
        
        $result = $this->get_request($request, $params, true, true);

        return $result;
    }
    /**
     * Protected method searching one contract in the database
     *
     * @param Int $key_contract The contract's primary key
     * @return Array
     */
    protected function searchContracts(int $key_contract): Array {
        $request  = "SELECT * FROM Contracts WHERE Id = :key_contract";

        $params = [ 'key_contract' => $key_contract ];

        return $this->get_request($request, $params, true, true);
    }
    


    // * INSCRIPT * //

    /**
     * protected method registering one user in the database
     *
     * @param Array $user The user's data Array
     * @return Int The primary key of the new service
     */
    protected function inscriptUsers(array $user): Int {
        $request = "INSERT INTO Users (Identifier, Name, Firstname, Email, Password, Key_Establishments, Key_Roles)
                    VALUES (:identifier, :name, :firstname, :email, :password, :key_establishments, :key_roles)";

        $this->post_request($request, $user);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one action in the database
     *
     * @param Int $key_user The user's primary key
     * @param Int $key_action The action primary key
     * @param String $description The action description
     * @throws Exception If the action's informtions is invalid or no complet
     * @return Int The primary key og the new Action
     */
    protected function inscriptActions(int $key_user, int $key_action, string $description = null): Int {
        if(!empty($description)) {
            $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions, Description) VALUES (:user_id, :type_id, :description)";
            $params = [
                "user_id"     => $key_user,
                "type_id"     => $key_action,
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

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one candidate in the database
     *
     * @param Candidate $candidate The candidate's data 
     * @return Int The primary key of the new Candidate
     */
    // protected function inscriptCandidates(Candidate $candidate): Int {
    //     $request = "INSERT INTO Candidates (Name, Firstname, Gender, Phone, Email, Address, City, PostCode, Availability";
    //     $values_request = " VALUES (:name, :firstname, :gender, :phone, :email, :address, :city, :post_code, :availability";
    // 
    //     if($candidate->getMedicalVisit()) {
    //         $request .= " , MedicalVisit";
    //         $values_request .= ", :visite";
    //     }
    // 
    //     $request .= ")" . $values_request . ")";
    //     unset($values_request);
    // 
    //     $this->post_request($request, $candidate->exportToSQL());
    // 
    //     $lastId = $this->getConnection()->lastInsertId();
    // 
    //     return $lastId;
    // }
    /**
     * Protected method registering one Get_qualfications in the database
     * 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_qualification The degree primary key
     * @param String $date The year of obtaining
     * @return Int The primary key of the new GetQualifications
     */
    protected function inscriptGetQualifications(int $key_candidate, int $key_qualification, string $date): Int {
        $request = "INSERT INTO Get_qualifications (Key_Candidates, Key_Qualifications, Date) VALUES (:key_candidate, :key_qualification, :date)";
        $params = [
            "key_candidate"     => $key_candidate,
            "key_qualification" => $key_qualification,
            "date"              => $date
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one Have_the_right_to in the database
     * 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_helps The assistance primary key
     * @param Int $key_employee The recommander's primary key
     * @return Int The primary key of the new HaveTheRightTo
     */
    protected function inscriptHaveTheRightTo(int $key_candidate, int $key_helps, int $key_employee = null): Int {
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

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one meeting in the database 
     *
     * @param Int $key_user The user's primary key (recruiter) 
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_establishment The establishment primary key
     * @param String $moment The meeting's moment 
     * @return Int The primary key of the new Meeting
     */
    protected function inscriptMeetings(int $key_user, int $key_candidate, int $key_establishment, string $moment): Int {
        $request = "INSERT INTO Meetings (Date, Key_Users, Key_Candidates, Key_Establishments) VALUES (:moment, :key_user, :key_candidate, :key_establishment)";
        $params = [
            "moment"            => $moment,
            "key_user"          => $key_user,
            "key_candidate"     => $key_candidate,
            "key_establishment" => $key_establishment
        ];
    
        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected methood registering a new contract
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_job The job's primary key
     * @param Int $key_service The service's primary key
     * @param Int $key_establishment The establishment's primary key
     * @param Int $key_type_of_contract The type of contracts primary key
     * @param String $start_date The start date 
     * @param String|Null $end_date The end date 
     * @param String|Null $signature_date The signature date 
     * @param Int|Null $salary The candidate's salary
     * @param Int|Null $hourly_rate The number of hours to be completed in a working week
     * @param Bool|Null $night_work If the candidate has to work on nights
     * @param Bool|Null $wk_work If the candidate has to work on week-ends
     * @return Int The primary key of the new Contract
     */
    protected function inscriptContracts(int $key_candidate, int $key_job, int $key_service, int $key_establishment, int $key_type_of_contract, string $start_date, ?string $end_date = null, ?string $signature_date = null, ?int $salary = null, ?int $hourly_rate = null, ?bool $night_work = false, ?bool $wk_work = false): Int {
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

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }

    /**
     * Protected method registering one job in the database
     *
     * @param String $titled The job intitule
     * @param String $titledFeminin The job description
     * @return Int The primary key of the new Job
     */
    protected function inscriptJobs(string $titled, string $titledFeminin): Int {
        $request = "INSERT INTO Jobs (Titled, TitledFeminin) VALUES (:titled, :titledFeminin)";
        $params = [
            "titled"        => $titled,
            "titledFeminin" => $titledFeminin
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one service in the database
     *
     * @param String $service The service intitule
     * @param String|Null $description The description of the new service
     * @return Int The primary key of the new service
     */
    protected function inscriptServices(string $service, ?string $description): Int {
        $request = "INSERT INTO Services (Titled, Description) VALUES (:service, :description)";
        $params = [
            'service'       => $service,
            'description'   => $description
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one establishment
     *
     * @param String $titled The establishment title
     * @param String $titled The establishment address
     * @param String $titled The establishment city
     * @param Int $titled The establishment postcode
     * @param Int/Null $titled The primary key of the hub containing the establishment 
     * @return Int The primary key of the new Establishment
     */
    protected function inscriptEstablishments(string $titled, string $address, string $city, int $postcode, ?int $key_poles = null): Int {
        $request = "INSERT INTO Establishments (Titled, Address, City, PostCode, Key_Poles) 
                    VALUES (:titled, :address, :city, :postcode, :key_poles)";
        $params = [
            'titled'    => $titled,
            'address'   => $address,
            'city'      => $city,
            'postcode'  => $postcode,
            'key_poles' => $key_poles
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Undocumented function
     *
     * @param Int $key_service The primary key of the service
     * @param Int $key_establishment The primary key of the establishment
     * @return Int The primary key of the new BelongTo
     */
    protected function inscriptBelongTo(int $key_service, int $key_establishment): Int {
        $request = "INSERT INTO Belong_to (Key_Establishments, Key_Services) VALUES (:key_establishment, :key_service)";
        $params = [
            'key_service'       => $key_service,
            'key_establishment' => $key_establishment
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Protected method registering one hub in the database
     *
     * @param String $titled The hub titled
     * @param String $description The hub description
     * @return Int The primary key of the new Pole
     */
    protected function inscriptPoles(string $titled, string $description): Int {
        $request = "INSERT INTO Poles (Titled, Description) VALUES (:titled, :desc)";
        $params = [
            'titled' => $titled,
            'desc'   => $description
        ];

        $this->post_request($request, $params);

        $lastId = $this->getConnection()->lastInsertId();

        return $lastId;
    }
    /**
     * Public method registering a new qualification
     *
     * @param String $titled The titled of the new qualification
     * @param Boolean $medical_staff Boolean showing if the new qualification is for medical jobs or not
     * @param String|Null $abbreviation The abbreviation of the titled
     * @return Void
     */
    protected function inscriptQualifications(string $titled, bool $medical_staff = false, ?string $abbreviation = null) {
        $request = "INSERT INTO Qualifications (Titled, MedicalStaff, Abreviation) VALUES (:titled, :medical_staff, :abbreviation)";
        $params = [
            "titled"        => $titled,
            "medical_staff" => $medical_staff ? 1 : 0,
            "abbreviation"  => $abbreviation
        ];

        $this->post_request($request, $params);
    }


    // * UPDATE * // 

    /**
     * Public method updating one user's password 
     *
     * @param String $password The new user's password
     * @return Void
     */
    public function updatePassword(string $password) {
        $request = "UPDATE Users
            SET Password = :password, PasswordTemp = false
            WHERE Id = :key";
        
        $params = [
            'key'      => $_SESSION['user_key'],
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->post_request($request, $params);
    }
    /**
     * Public method updating one user's data
     *
     * @param Int $key_users The user's primary key
     * @param String $name The user's name
     * @param String $firstname The user's firstname
     * @param String $email The user's email
     * @param Int $key_roles The kprimary key of the user's role
     * @return Void
     */
    public function updateUsers(int $key_users, string $name, string $firstname, string $email, int $key_roles) {
        $request = "UPDATE Users
            SET Name = :name, Firstname = :firstname, Email = :email, Key_Roles = :role
            WHERE Id = :cle";

        $params = [
            'name'      => $name,
            'firstname' => $firstname,
            'email'     => $email,
            'role'      => $key_roles,
            'cle'       => $key_users
        ];

        return $this->get_request($request, $params);
    }
    /**
     * public method updating one candidate's evaluation
     *
     * @param Int $cle_candidat The candidate's primary key
     * @param Int $rating the candidate's rating 
     * @param String|Null $description the candidate's description 
     * @param Int optionnal $a The first important criteria to the recruitement (1 -> true ; 0 -> false) 
     * @param Int optionnal $b The first important criteria to the recruitement (1 -> true ; 0 -> false)  
     * @param Int optionnal $c The first important criteria to the recruitement (1 -> true ; 0 -> false)  
     * @return Void
     */
    public function updateRatings(int $key_candidate, int $rating, string|null $description = null, int $a = 0, int $b = 0, int $c = 0) {
        $request = "UPDATE Candidates SET Rating = :rating, Description = :description, A = :a, B = :b, C = :c WHERE Id = :key_candidate";
        $params = [
            'rating'        => $rating,
            'description'   => $description,
            'a'             => $a,
            'b'             => $b,
            'c'             => $c,
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
    public function updateCandidates(int $key_candidate, string $name, string $firstname, ?string $email = null, ?string $phone = null, ?string $address = null, ?string $city = null, ?int $post_code = null) {
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
            'post_code'     => $post_code,
            'key_candidate' => $key_candidate
        ];

        $this->post_request($request, $params);
    }
    /**
     * Public method updating one candidate's meeting
     *
     * @param Int $key_meeting The meeting's primary key
     * @param Int $key_user The user's primary key
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_establishment The establishment's primary key
     * @param String $moment The moment when the meetind is
     * @param String $description The meeting's description
     * @return Void
     */
    public function updateMeetings(int $key_meeting, int $key_user, int $key_candidate, int $key_establishment, string $moment, string $description) {
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
    protected function deleteMeetings(int $key_meeting) {
        $request = "DELETE FROM Meetings WHERE Id = :key_meeting";

        $params = [ 'key_meeting' => $key_meeting ];

        $this->post_request($request, $params);
    }
    /**
     * Protected method deleting an Have_the_right_to 
     *
     * @param Int $key_candidate The candidate's primary key
     * @param Int $key_help The help's primary key
     * @return Void
     */
    protected function deleteHaveTheRightTo(int $key_candidate, int $key_help) {
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
    protected function deleteGetQualifications(int $key_candidate, int $key_qualifications) {
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
     * @return Bool TRUE if it is in ; FALSE if it is not
     */
    public function verifyServices(int $key_services, int $key_establishments): Bool {
        return !empty($this->searchBelongTo($key_services, $key_establishments));
    }
}