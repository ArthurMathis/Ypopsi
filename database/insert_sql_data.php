<?php

require_once("../vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

require_once('../define.php');

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
}

/**
 * Class analzing an arrray and making a database request 
 */
class sqlInterpreter {
    /**
     * Public static attribute containing the default index of a search column
     *
     * @var int
     */
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
    public function rowAnalyse(array &$data) {
        $key_candidate = $this->makecandidate($data); 
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

    // * INSCRIPT * //
    /**
     * Undocumented function
     *
     * @param array $candidate The candidate
     * @return int The candidate's primary key
     */
    protected function inscriptCandidate(array &$candidate): int {
        $request = "INSERT INTO Candidates (Name, Firstname, Gender, Phone, Email, Address, City, PostCode, Description, Rating, A, B, C " 
                    . "VALUES (:name, :firstname, :gender, :phone, :email, :address, :city, :post_code, :availability, :description, :rating: a, :b, :c";

        $lastId = $this->getInserter()->post_request($request, $candidate);

        return $lastId;
    }
}

class fileReader {
    public function __construct(
        protected string $filePath,
        protected int $page
    ) {
        if($page < 0) {
            die("Il est impossble de lire une feuille d'indice négatif");
        }
    }


    // * GET * //
    public function getPath(): string { return $this->filePath; }

    public function getPage(): int { return $this->page; }


    // * READ * //
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

        for($rowCount = 2; $rowCount <= $size; $rowCount++) {
            $rowData = $this->readLine($sheet, $rowCount);

            if(! $this->isEmptyRow($rowData)) {
                var_dump($rowData);
                echo "<br>";
            }
        }
    }

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

function main() {
    $file_reader = new fileReader("pole_recrutement_donnees.xlsx", 0);

    $file_reader->readFile();
}

main();