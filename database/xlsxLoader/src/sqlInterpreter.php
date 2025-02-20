<?php

namespace DB;

use \Exception;
use DB\sqlInserter;
use DB\Registering;

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
    protected function getColumnContent(array &$data, string $column, string $table_err, bool $present = false) {
        $index = $this->getIndex($column);

        if($index == sqlInterpreter::$BASED_INDEX) {
            throw new Exception("La colonne {$column} est introuvable");
        }

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
     * @return Registering
     */
    public function rowAnalyse(array &$data): Registering {
        echo "<h2>On enregistre un nouveau candidat</h2>";

        
        $registering = new Registering();

        $registering->candidate = $this->makecandidate($data); 


        echo "<h3>Profile : {$registering->candidate}</h3>";

        
        $registering->application = $this->makeApplication($data, $registering->candidate);


        echo "<h3>Candidature : {$registering->application}</h3>";


        $registering->contract = $this->makeContract($data, $registering->candidate, $registering->application);


        echo "<h3>Candidature : {$registering->contract}</h3>";

        // todo : qualifications
        // todo : aides
        // todo : coopteur 

        return $registering;
    }

    /**
     * Protected method getting the candidate's information and register him in the database
     *
     * @param array $data The row
     * @return int The candidate's primary key
     */
    protected function makeCandidate(array &$data): int {
        $candidate = [];

        $candidate["name"] = $this->getColumnContent(
            $data,
            sqlInterpreter::$NAME_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$REQUIRED
        );
        $candidate["firstname"] = $this->getColumnContent(
            $data, 
            sqlInterpreter::$FIRSTNAME_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$REQUIRED
        );

        $gender = $this->getColumnContent(
            $data, 
            sqlInterpreter::$GENDER_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$REQUIRED
        );
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

        $email = $this->getColumnContent(
            $data, 
            sqlInterpreter::$EMAIL_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        if(!empty($email)) {
            $candidate["email"] = $email;
        }

        $phone = $this->getColumnContent(
            $data, 
            sqlInterpreter::$PHONE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        if(!empty($email)) {
            $candidate["phone"] = $phone;
        }

        $address = $this->getColumnContent(
            $data, 
            sqlInterpreter::$ADDRESS_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        $city = $this->getColumnContent(
            $data,
            sqlInterpreter::$CITY_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        $postcode = $this->getColumnContent(
            $data, 
            sqlInterpreter::$POSTCODE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        if(!empty($address) && !empty($city) && !empty($postcode)) {
            $candidate["address"]  = $address;
            $candidate["city"]     = $city;
            $candidate["postcode"] = $postcode;
            
        } elseif(empty($address) && empty($city) && empty($postcode)) {
            throw new Exception("Impossible d'enregistrer un candidat avec une adresse partielle. Valeur attendue : adresse + ville + code postale ou complètement vide");
        }

        $candidate["availability"] = $this->getColumnContent(
            $data, 
            sqlInterpreter::$STARTING_DATE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );

        $description = $this->getColumnContent(
            $data, 
            sqlInterpreter::$DESCRIPTION_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        if(!empty($description)) {
            $candidate["description"] = $description;
        }
        $rating =  $this->getColumnContent(
            $data, 
            sqlInterpreter::$RATING_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        );
        if(!empty($rating)) {
            $candidate["rating"] = $rating;
        }
        
        $a = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_A_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        ));
        if($a) {
            $candidate["a"] = $a;
        }

        $b = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_B_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        ));
        if($b) {
            $candidate["b"] = $b;
        }

        $c = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_C_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE, 
            sqlInterpreter::$NOT_REQUIRED
        ));
        if($c) {
            $candidate["c"] = $c;
        }

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
        $request = "INSERT INTO Candidates (Name, Firstname, Gender, Availability";
        $values_request = " VALUES (:name, :firstname, :gender, :availability";

        if(!empty($candidate["email"])) {
            $request .= ", Email";
            $values_request .= ", :email";
        }

        if(!empty($candidate["phone"])) {
            $request .= ", Phone";
            $values_request .= ", :phone";
        }

        if(!empty($candidate["address"]) && !empty($candidate["city"]) && !empty($candidate["postcode"])) {
            $request .= ", Address, City, PostCode";
            $values_request .= ", :address, :city, :postcode";
        }

        if(!empty($candidate["description"])) {
            $request .= ", Description";
            $values_request .= ", :description";
        }

        if(!empty($candidate["rating"])) {
            $request .= ", Rating";
            $values_request .= ", :rating";
        }

        if(!empty($candidate["a"])) {
            $request .= ", A";
            $values_request .= ", :a";
        }

        if(!empty($candidate["b"])) {
            $request .= ", B";
            $values_request .= ", :b";
        }

        if(!empty($candidate["c"])) {
            $request .= ", C";
            $values_request .= ", :c";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);

        echo "<h4>Request : </h4>";
        var_dump($request);
        echo "<br>";

        echo "<h4>Params : </h4>";
        var_dump($candidate);
        echo "<br>";

        $lastId = null;

        try {
            $inserter = $this->getInserter();
            $lastId = $inserter->post_request($request, $candidate);
        } catch(Exception $e) {
            echo $e->getMessage();
        }

        

        echo "<h4>Id : </h4>";
        var_dump($lastId);
        echo "<br>";

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
    /**
     * Protected method searching a job in the database
     *
     * @param string $titled The title of the job
     * @return int The primary key of the title
     */
    protected function searchJobId(string $titled): int {
        $request = "SELECT Id FROM Jobs WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }
    /**
     * Protected method searching a service in the database
     *
     * @param string $titled The title of the service
     * @return int The primary key of the service
     */
    protected function searchServiceId(string $titled): int {
        $request = "SELECT Id FROM Services WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }
    /**
     * Protected method searching an establishment in the database
     *
     * @param string $titled The title of the establishment
     * @return int The primary key of the establishment
     */
    protected function searchEstablishmentId(string $titled): int {
        $request = "SELECT Id FROM Establishments WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }
    /**
     * Protected method searching a type of contract in the database
     * 
     * @param string $titled The title of the type
     * @return int The primary key of the type
     */
    protected function searchTypeId(string $titled): int {
        $request = "SELECT Id FROM Types_of_contracts WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }
    /**
     * Protected method searching an application in the database
     *
     * @param integer $key_application The primary key of the application
     * @return array The application
     */
    protected function searchApplication(int $key_application): array {
        $request = "SELECT * FROM Types_of_contracts WHERE Id = :id";

        $params = array("id" => $key_application);

        $response = $this->getInserter()->get_request($request, $params, true, true);

        return $response;
    }
}