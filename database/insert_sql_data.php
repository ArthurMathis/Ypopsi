<?php

require_once("../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once('../define.php');


class registering {
    public $candidate;
    public $application;
    public $contract;
}


/**
 * Class manipulating the database connection
 * 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class sqlInserter {
    /**
     * Protected attribute containing the connection to the database
     *
     * @var PDO
     */
    protected $connection;

    /**
     * Constructor class
     */
    public function __construct() { $this->connect(); }

    /**
     * Protected method making the connection
     *
     * @throws PDOExceptions If the connection failed
     * @return PDO
     */
    protected function connect(): PDO {
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

    // * GET * //
    /**
     * Protected method returning the connection
     *
     * @return PDO
     */
    protected function getConnection(): PDO { return $this->connection; }

    /**
     * Public method making a post request at the database
     *
     * @param string $request The request
     * @param array $params The params of the request
     * @return int The primary key of the new registration
     */
    public function post_request(string &$request, array &$params): int {
        try {
            $query = $this->getConnection()->prepare($request);

            $query->execute($params);

            $lastId = $this->getConnection()->lastInsertId();

            return $lastId;

        } catch(PDOException $e){
            forms_manip::error_alert([
                'title' => 'Erreur lors de la requête à la base de données',
                'msg' => $e
            ]);
        }
    }
    /**
     * Public method executing a GET request to the database
     *
     * @param String $request The SQL request
     * @param Array<String> $params The request data parameters
     * @param Boolean $unique TRUE if the waiting result is one unique item, FALSE otherwise
     * @param Boolean $present TRUE if if the waiting result can't be null, FALSE otherwise
     * @return Array|Null
     */
    public function get_request(string $request, ?array $params = [], bool $unique = false, bool $present = false): ?Array { 
        if(empty($unique) || empty($present)) {
            $present = false;
        }

        $query = $this->getConnection()->prepare($request);

        $query->execute($params);

        $result = $unique ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC);

        if(empty($result)) {
            if($present) {
                throw new Exception("Requête: " . $request ."\nAucun résultat correspondant");
            } else {
                return null;
            } 
        } else {
            return $result;
        }

        return null;
    }
}


/**
 * Class analzing an arrray and making a database request 
 */
class sqlInterpreter {
    public static $BASED_INDEX = -1;

    public static $REQUIRED = true;
    public static $NOT_REQUIRED = false;

    public static $MALE = "M";
    public static $FEMALE = "F";

    /// Name of column 
    public static $NAME_ROW = "NOM";
    public static $FIRSTNAME_ROW = "PRENOM";
    public static $PHONE_ROW = "Telephone";
    public static $EMAIL_ROW = "Email";
    public static $GENDER_ROW = "Sexe";

    public static $ADDRESS_ROW = "Adresse";
    public static $CITY_ROW = "Ville";
    public static $POSTCODE_ROW = "Code postal";

    public static $SERVICE_ROW = "Service";
    public static $ESTABLISHMENT_ROW = "Etablissement";
    public static $JOB_ROW = "POSTE";

    public static $QUALIFICATIONS_ROW = "Qualifications";
    public static $QUALIFICATIONS_date_ROW = "Date de Diplôme";
    public static $RATING_ROW = "Notation (de 1 à 5)";
    public static $BL_A_ROW = "B.L. A";
    public static $BL_B_ROW = "B.L. B";
    public static $BL_C_ROW = "B.L. C"; 
    public static $DESCRIPTION_ROW = "Observations";

    public static $TYPE_OF_CONTRACTS_ROW = "Type de contrat";
    public static $HELPS_ROW = "Aides (recrutement)";
    public static $SOURCE_ROW = "Sources";

    public static $STARTING_DATE_ROW = "DATE DEBUT";
    public static $ENDING_DATE_ROW = "DATE FIN";

    public static $CANDIDATE_TABLE = "Candidats";
    public static $APPLICATION_TABLE = "Candidatures";
    public static $CONTRACT_TABLE = "Contrats";

    protected $sql_inserter;

    /**
     * Constructor class
     *
     * @param array $rowStructure The structure of rows 
     */
    public function __construct(protected array $rowStructure) { $this->sql_inserter = new sqlInserter(); }

    // * GET * //
    /**
     * Protected method returning the structure of rows
     *
     * @return array
     */
    protected function getStructure(): array { return $this->rowStructure; }

    /**
     * Protected method returning the sqlInserter
     *
     * @return sqlInserter
     */
    protected function getInserter(): sqlInserter { return $this->sql_inserter; }

    /**
     * Protected method returning the index of a column
     *
     * @param string $titled The title of the column
     * @return int
     */
    protected function getIndex(string &$titled): int {
        $index = sqlInterpreter::$BASED_INDEX;

        $structure = $this->getStructure();

        $i = 0;

        $size = count($structure);

        while($index === sqlInterpreter::$BASED_INDEX && $i < $size) {
            if($structure[$i] == $titled) {
                $index = $i;
            }

            $i++;
        }

        return $index;
    }

    /**
     * Protected function returning the content of a column 
     *
     * @param array $data The row
     * @param string $column The title of the column 
     * @param boolean $present Boolean indicating if data must be present
     * @param string $table_err The name of the table 
     * @return void
     */
    protected function getColumnContent(array &$data, string $column, bool $present = false, string $table_err) {
        $index = $this->getIndex($column);

        $response = $data[$index];

        if($present && empty($response)) {
            throw new Exception("Impossible d'enregistrer un(e) nouveau(elle) {$table_err} sans {$column}.");
        }

        return $response;
    }

    // * ANALYSE * //
    /**
     * Public function analyzing a row 
     *
     * @param array $data The row
     * @return void
     */
    public function rowAnalyse(array &$data) {
        $registering = new Registering();

        $registering->candidate = $this->makecandidate($data); 
        
        $registering->application = $this->makeApplication($data, $registering->candidate);

        $registering->contract = $this->makeContract($data, $registering->candidate, $registering->application);
    }

    /**
     * Protected method getting the candidate's information and register him in the database
     *
     * @param array $data The row
     * @return int The candidate's primary key
     */
    protected function makeCandidate(array &$data): int {
        $candidate = [];

        $candidate["name"] = $this->getColumnContent($data, sqlInterpreter::$NAME_ROW, sqlInterpreter::$REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $candidate["firstname"] = $this->getColumnContent($data, sqlInterpreter::$FIRSTNAME_ROW, sqlInterpreter::$REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);


        $gender = $this->getColumnContent($data, sqlInterpreter::$GENDER_ROW, sqlInterpreter::$REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        switch($gender) {
            case sqlInterpreter::$MALE: 
                $candidate["gender"] = true;
                break; 

            case sqlInterpreter::$FEMALE:
                $candidate["gender"] = false;
                break;

            default : throw new Exception("Impossible d'enregistrer un candidat avec un sexe invalide. Valeur attendue : " 
                            . sqlInterpreter::$MALE . " - pour homme et " . sqlInterpreter::$FEMALE . " - pour femme.");
        }


        $candidate["email"] = $this->getColumnContent($data, sqlInterpreter::$EMAIL_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $candidate["phone"] = $this->getColumnContent($data, sqlInterpreter::$PHONE_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);


        $address = $this->getColumnContent($data, sqlInterpreter::$ADDRESS_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $city = $this->getColumnContent($data, sqlInterpreter::$ADDRESS_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $postcode = $this->getColumnContent($data, sqlInterpreter::$ADDRESS_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        if((! empty($address) && ! empty($city) && ! empty($postcode)) || (empty($address) && empty($city) && empty($postcode))){
            $candidate["address"] = $address;

            $candidate["city"] = $city;

            $candidate["postcode"] = $postcode;
            
        } else {
            throw new Exception("Impossible d'enregistrer un candidat avec une adresse partielle. Valeur attendue : adresse + ville + code postale ou complètement vide");
        }


        $candidate["description"] = $this->getColumnContent($data, sqlInterpreter::$DESCRIPTION_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $candidate["rating"] = $this->getColumnContent($data, sqlInterpreter::$RATING_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        $candidate["availability"] = $this->getColumnContent($data, sqlInterpreter::$STARTING_DATE_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE);

        
        $candidate["a"] = $this->getColumnContent($data, sqlInterpreter::$BL_A_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE) ?? true;

        $candidate["b"] = $this->getColumnContent($data, sqlInterpreter::$BL_B_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE) ?? true;

        $candidate["c"] = $this->getColumnContent($data, sqlInterpreter::$BL_C_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$CANDIDATE_TABLE) ?? true;


        return $this->inscriptCandidate($candidate);
    }

    /**
     * Protected method geeting the information of an application and register its in the database
     *
     * @param array $data The row 
     * @param integer $key_candidate The candidate's primary key
     * @throws Exception If the application is invalid
     * @return int The primary key of the application
     */
    protected function makeApplication(array &$data, int $key_candidate): int {
        $application = [];

        $application["candidate"] = $key_candidate;


        $job = (string) $this->getColumnContent($data, sqlInterpreter::$JOB_ROW, sqlInterpreter::$REQUIRED, sqlInterpreter::$APPLICATION_TABLE);

        $application["job"] = $this->searchJobId($job);


        $service = (string) $this->getColumnContent($data, sqlInterpreter::$SERVICE_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$APPLICATION_TABLE);

        $estbablishment = (string) $this->getColumnContent($data, sqlInterpreter::$ESTABLISHMENT_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$APPLICATION_TABLE);

        $application["service"] = $this->searchServiceId($service);

        $application["establishment"] = $this->searchEstablishmentId($estbablishment);

        if(! empty($application["service"]) && empty($application["establishment"])) {
            throw new Exception("Impossible d'enregistrer une candidature avec un service et sans établissement. Valeurs du service : " . $application["service"] . " ; valeur du l'établissement : " . $application["establishment"] . ".");

        } else if(empty($application["service"]) && ! empty($application["establishment"])) {
            throw new Exception("Impossible d'enregistrer une candidature avec un établissement et sans service. Valeurs du service : " . $application["service"] . " ; valeur du l'établissement : " . $application["establishment"] . ".");
        }


        $type = (string) $this->getColumnContent($data, sqlInterpreter::$TYPE_OF_CONTRACTS_ROW, sqlInterpreter::$NOT_REQUIRED, sqlInterpreter::$APPLICATION_TABLE);

        $application["type"] = $this->searchTypeId($type);


        return $this->inscriptApplication($application);
    }

    /**
     * Protected method geeting the information of a contract ang register its in the database
     *
     * @param array $data The row
     * @param integer $key_candidate The candidate's primary key 
     * @param integer $key_application The primary key of the application
     * @return ?int
     */
    protected function makeContract(array &$data, int $key_candidate, int $key_application): ?int {
        $contract = ["candidate" => $key_candidate];


        $application = $this->searchApplication($key_application);


        $contract["job"] = $application["Key_Jobs"];

        $contract["service"] = $application["Key_Services"];

        $contract["establishment"] = $application["Key_Applications"];

        $contract["type"] = $application["Key_Types_of_contracts"];

        if(empty($contract["type"])) {
            throw new Exception("Impossible d'inscrire un contrat sans type de contrat. Valeur : " . $contract["type"] . ".");
        }


        unset($application);


        $contract["start_date"] = $this->getColumnContent($data, sqlInterpreter::$STARTING_DATE_ROW, sqlInterpreter::$REQUIRED, sqlInterpreter::$CONTRACT_TABLE);

        $contract["proposition_date"] = $contract["start_date"];

        $contract["signature_date"] = $contract["start_date"];

        
        $cdi_id = $this->searchTypeId("CDI");

        $required = $contract["type"] !== $cdi_id;

        $contract["end_date"] = $this->getColumnContent($data, sqlInterpreter::$ENDING_DATE_ROW, $required, sqlInterpreter::$CONTRACT_TABLE);


        return $this->inscriptContract($contract);
    }

    // * INSCRIPT * //
    /**
     * Protected method registering a new candidate in the database
     *
     * @param array $candidate The candidate
     * @return int The candidate's primary key
     */
    protected function inscriptCandidate(array &$candidate): int {
        $request = "INSERT INTO Candidates (Name, Firstname, Gender, Phone, Email, Address, City, PostCode, Description, Rating, A, B, C)" 
                    . " VALUES (:name, :firstname, :gender, :phone, :email, :address, :city, :post_code, :availability, :description, :rating: a, :b, :c)";

        $lastId = $this->getInserter()->post_request($request, $candidate);

        return $lastId;
    }

    /**
     * Protected method registering a new application in the database
     *
     * @param array $application The application
     * @return int The primary key of the application
     */
    protected function inscriptApplication(array &$application): int {
        $request = "INSERT INTO Applications (Key_Candidates, Key_Jobs, Key_sources";
                    
        $values_request = " VALUES (:candidate, :job, :source";


        if(! empty($candidate["service"]) && ! empty($application["establishment"])) {
            $request .= ", Key_Services, Key_Establishments";

            $values_request .= ", :service, :estbalishment";
        }



        if(! empty($application["type"])) {
            $request .= ", Key_Types_of_contracts";

            $values_request .= ", :type";
        }


        $request .= ")" . $values_request . ")";


        $lastId = $this->getInserter()->post_request($request, $application);

        return $lastId;
    }

    /**
     * Protected method registering a new contract in the database
     *
     * @param array $contract The contract
     * @return int The primary key of the contract
     */
    protected function inscriptContract(array $contract): int {
        $request = "INSERT INTO Contracts (PropositionDate, SignatureDate, StartDate, Key_Candidates, Key_Jobs, Key_Services, Key_Establishments, Key_Types_of_contracts";

        $values_request = " VALUES (:proposition_date, :signature_date, :start_date, :candidate, :job, :service, :establishment, :type";


        if(! empty($contract["end_date"])) {
            $request .= ", EndDate";

            $values_request .= ", :end_date";
        }


        $request .= ")" . $values_request . ")";


        $lastId = $this->getInserter()->post_request($request, $candidate);

        return $lastId;
    }

    // * SEARCH * //
    protected function searchJobId(string $titled): int {
        $request = "SELECT Id FROM Jobs WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }

    protected function searchServiceId(string $titled): int {
        $request = "SELECT Id FROM Services WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }

    protected function searchEstablishmentId(string $titled): int {
        $request = "SELECT Id FROM Establishments WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }

    protected function searchTypeId(string $titled): int {
        $request = "SELECT Id FROM Types_of_contracts WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }

    protected function searchApplication(int $key_application): array {
        $request = "SELECT * FROM Types_of_contracts WHERE Id = :id";

        $params = array("id" => $key_application);

        $response = $this->getInserter()->get_request($request, $params, true, true);

        return $response;
    }
}


/**
 * Class reading a file 
 */
class fileReader {
    /**
     * Constructor class
     *
     * @param string $filePath The path of the file 
     * @param int $page The index of the page
     */
    public function __construct(
        protected string $filePath,
        protected int $page
    ) {
        if($page < 0) {
            die("Il est impossble de lire une feuille d'indice négatif");
        }
    }


    // * GET * //
    /**
     * Public method returning the path of file
     *
     * @return string The path
     */
    public function getPath(): string { return $this->filePath; }

    /**
     * Public method returning the index of the page
     *
     * @return int The index
     */
    public function getPage(): int { return $this->page; }


    // * READ * //
    /**
     * Public method reading a file
     *
     * @return void
     */
    public function readFile() {
        echo "On débute la procédure<br>";

        $file = IOFactory::load($this->getPath());                                                  // Loading the file

        echo "Fichier ouvert<br>";


        $sheet = $file->getSheet($this->getPage());                                                 // Loading the page
        
        echo "Page sélectionnée<br>";


        $size = $sheet->getHighestRow();

        echo "{$size} lignes trouvées<br>";

        echo "On débute la lecture<br>";


        $rowStructure = $this->readLine($sheet, 1);

        for($rowCount = 2; $rowCount <= $size; $rowCount++) {                                       // Reading the file
            $rowData = (array) $this->readLine($sheet, $rowCount);

            if(! $this->isEmptyRow($rowData)) {
                var_dump($rowData);
                echo "<br>";
            }
        }
    }

    /**
     * Protected method reading a line of the Excel 
     *
     * @param $sheet The file to read
     * @param int $row The index of the row
     * @return void
     */
    protected function readLine($sheet, int $row) {
        $rowData = [];

        $cellIterator = $sheet->getRowIterator($row)->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); 

        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue();
        }

        return $rowData;
    }

    // * OTHER * //
    /**
     * Peotected method testing if a row is empty or not
     *
     * @param array $row The rom
     * @return boolean 
     */
    protected function isEmptyRow(array $row): bool {
        $i = 0;

        $empty = true;

        $size = count($row);

        while($empty && $i < $size) {
            if(! is_null($row[$i]) || ! empty($row[$i])) {
                $empty = false;
            }

            $i++;
        }

        return $empty;
    }
}

//// MAIN ////
function main() {
    $file_reader = new fileReader("pole_recrutement_donnees.xlsx", 0);

    $file_reader->readFile();
}

main();