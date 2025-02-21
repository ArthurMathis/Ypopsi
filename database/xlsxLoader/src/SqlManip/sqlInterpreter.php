<?php

namespace DB\SqlManip;

use \Exception;
use DB\SqlManip\sqlInserter;
use DB\RegisterManip\registering;

/**
 * Class analzing an arrray and making a database request 
 */
class sqlInterpreter {
    public static int $BASED_INDEX = -1;
    public static string $STR_SEPARATOR = ";";

    public static bool $REQUIRED = true;
    public static bool $NOT_REQUIRED = false;

    public static string $MALE = "M";
    public static string $FEMALE = "F";

    /// Name of column 
    public static string $NAME_ROW = "NOM";
    public static string $FIRSTNAME_ROW = "PRENOM";
    public static string $PHONE_ROW = "Telephone";
    public static string $EMAIL_ROW = "Email";
    public static string $GENDER_ROW = "Sexe";

    public static string $ADDRESS_ROW = "Adresse";
    public static string $CITY_ROW = "Ville";
    public static string $POSTCODE_ROW = "Code postal";

    public static string $SERVICE_ROW = "Service";
    public static string $ESTABLISHMENT_ROW = "Etablissement";
    public static string $JOB_ROW = "POSTE";

    public static string $QUALIFICATIONS_ROW = "Qualifications";
    public static string $QUALIFICATIONS_DATE_ROW = "Date de Diplôme";
    public static string $RATING_ROW = "Notation (de 1 à 5)";
    public static string $BL_A_ROW = "B.L. A";
    public static string $BL_B_ROW = "B.L. B";
    public static string $BL_C_ROW = "B.L. C"; 
    public static string $DESCRIPTION_ROW = "Observations";

    public static string $TYPE_OF_CONTRACTS_ROW = "Type de contrat";
    public static string $HELPS_ROW = "Aides (recrutement)";
    public static string $SOURCE_ROW = "Sources";

    public static string $STARTING_DATE_ROW = "DATE DEBUT";
    public static string $ENDING_DATE_ROW = "DATE FIN";

    public static string $CANDIDATE_TABLE = "Candidat";
    public static string $QUALIFICATION_TABLE = "Qualification";
    public static string $HELPS_TABLE = "Aide au recrutement";
    public static string $APPLICATION_TABLE = "Candidature";
    public static string $CONTRACT_TABLE = "Contrat";

    protected sqlInserter $sql_inserter;

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
     * @return void
     */
    public function rowAnalyse(registering &$registering, array &$data) {
        echo "<h2>On enregistre un nouveau candidat</h2>";

        $registering->candidate = $this->makecandidate($data); 

        $registering->application = $this->makeApplication($data, $registering->candidate);

        $registering->contract = $this->makeContract($data, $registering->candidate, $registering->application);

        $registering->qualifications = $this->makeQualifications($data, $registering->candidate);

        $registering->helps = $this->makeHelps($data, $registering->candidate);
    }

    // * ANALYSE * //
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
            sqlInterpreter::$CANDIDATE_TABLE
        );
        if(!empty($email)) {
            $candidate["email"] = $email;
        }

        $phone = $this->getColumnContent(
            $data, 
            sqlInterpreter::$PHONE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        if(!empty($email)) {
            $candidate["phone"] = $phone;
        }

        $address = $this->getColumnContent(
            $data, 
            sqlInterpreter::$ADDRESS_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        $city = $this->getColumnContent(
            $data,
            sqlInterpreter::$CITY_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        $postcode = $this->getColumnContent(
            $data, 
            sqlInterpreter::$POSTCODE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        if(!empty($address) && !empty($city) && !empty($postcode)) {
            $candidate["address"]  = $address;
            $candidate["city"]     = $city;
            $candidate["postcode"] = $postcode;
            
        } elseif(!(empty($address) && empty($city) && empty($postcode))) {
            throw new Exception("Impossible d'enregistrer un candidat avec une adresse partielle. Valeur attendue : adresse + ville + code postale ou complètement vide");
        }

        $candidate["availability"] = $this->getColumnContent(
            $data, 
            sqlInterpreter::$STARTING_DATE_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );

        $description = $this->getColumnContent(
            $data, 
            sqlInterpreter::$DESCRIPTION_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        if(!empty($description)) {
            $candidate["description"] = $description;
        }
        $rating =  $this->getColumnContent(
            $data, 
            sqlInterpreter::$RATING_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        );
        if(!empty($rating)) {
            $candidate["rating"] = $rating;
        }
        
        $a = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_A_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        ));
        if($a) {
            $candidate["a"] = $a;
        }

        $b = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_B_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        ));
        if($b) {
            $candidate["b"] = $b;
        }

        $c = !empty($this->getColumnContent(
            $data, 
            sqlInterpreter::$BL_C_ROW, 
            sqlInterpreter::$CANDIDATE_TABLE
        ));
        if($c) {
            $candidate["c"] = $c;
        }

        return $this->inscriptCandidate($candidate);
    }

    /**
     * Protected method adapting the date format 
     *
     * @param string $date The date
     * @return string
     */
    protected function completeDate(string $date): string {
        if (preg_match('/^\d{2}\/\d{4}$/', $date)) {
            return "01/" . $date;
        }
    
        if (preg_match('/^\d{4}$/', $date)) {
            return "01/01/" . $date;
        }
    
        return $date;
    }

    /**
     * Protected method geeting the information of an application and register its in the database
     *
     * @param array $data The row 
     * @param int $key_candidate The candidate's primary key
     * @throws Exception If the application is invalid
     * @return int The primary key of the application
     */
    protected function makeApplication(array &$data, int $key_candidate): int {
        $application = [];
        $application["candidate"] = $key_candidate;

        $job = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$JOB_ROW, 
            sqlInterpreter::$APPLICATION_TABLE, 
            sqlInterpreter::$REQUIRED
        );
        $application["job"] = $this->searchJobId($job);

        $source = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$SOURCE_ROW, 
            sqlInterpreter::$APPLICATION_TABLE,
            sqlInterpreter::$REQUIRED
        );
        $application["source"] = $this->searchSourceId($source);

        $service = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$SERVICE_ROW, 
            sqlInterpreter::$APPLICATION_TABLE
        );
        $estbablishment = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$ESTABLISHMENT_ROW, 
            sqlInterpreter::$APPLICATION_TABLE
        );
        if(!empty($service) && !empty($estbablishment)) {
            $application["service"]       = $this->searchServiceId($service);
            $application["establishment"] = $this->searchEstablishmentId($estbablishment);
        }

        if(!empty($application["service"]) && empty($application["establishment"])) {
            throw new Exception("Impossible d'enregistrer une candidature avec un service et sans établissement. Valeurs du service : " . $application["service"] . " ; valeur du l'établissement : " . $application["establishment"] . ".");

        } else if(empty($application["service"]) && !empty($application["establishment"])) {
            throw new Exception("Impossible d'enregistrer une candidature avec un établissement et sans service. Valeurs du service : " . $application["service"] . " ; valeur du l'établissement : " . $application["establishment"] . ".");
        }

        $type = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$TYPE_OF_CONTRACTS_ROW, 
            sqlInterpreter::$APPLICATION_TABLE
        );
        if(!empty($type)) {
            $application["type"] = $this->searchTypeId($type);
        }

        return $this->inscriptApplication($application);
    }

    /**
     * Protected method geeting the information of a contract and register its in the database
     *
     * @param array $data The row
     * @param int $key_candidate The candidate's primary key 
     * @param int $key_application The primary key of the application
     * @return ?int
     */
    protected function makeContract(array &$data, int $key_candidate, int $key_application): ?int {
        $application = $this->searchApplication($key_application);                                                                  // fetching the application

        $completed_application = !empty($application["Key_Services"]) 
                                && !empty($application["Key_Applications"]) 
                                && !empty($application["Key_Types_of_contracts"]);

        $start_date = (string) $this->getColumnContent(                                                                             // Getting the start date
            $data, 
            sqlInterpreter::$STARTING_DATE_ROW, 
            sqlInterpreter::$CONTRACT_TABLE,
            sqlInterpreter::$NOT_REQUIRED
        );
        $start_date = $this->completeDate($start_date);


        $end_date = (string) $this->getColumnContent(                                                                                       // Getting the end date
            $data,
            sqlInterpreter::$ENDING_DATE_ROW, 
            sqlInterpreter::$CONTRACT_TABLE
        );
        $end_date = $this->completeDate($end_date);


        if(!$completed_application || empty($start_date)) {
            return null;
        }


        if(!empty($start_date) && !$completed_application) {                                                                        // Testing datat integrity
            throw new Exception("Impossible d'enregistrer un contrat sans : un service, un établissement et un type de contrat.");
        }

        if($application["Key_Types_of_contracts"] !== $this->searchTypeId("CDI") && empty($end_date)) {                                                                                                      // Testing datat integrity
            throw new Exception("Impossible d'enregistrer un contrat à durée déterminée sans date de fin de contrat.");
        }

        $contract = array(
            "candidate"        => $key_candidate,
            "job"              => $application["Key_Jobs"],
            "service"          => $application["Key_Services"],
            "establishment"    => $application["Key_Types_of_contracts"],
            "start_date"       => $start_date,
            "proposition_date" => $start_date,
            "signature_date"   => $start_date
        );

        unset($application);

        if(!empty($end_date)) {
            $contracts["end_date"] = $end_date;
        }

        return $this->inscriptContract($contract);
    }

    /**
     * Protected method geeting the information of qualifications and register them in the database 
     *
     * @param array $data The row
     * @param int $key_candidate The candidate's primary key 
     * @return array
     */
    protected function makeQualifications(array $data, int $key_candidate): array {
        $qualifs = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$QUALIFICATIONS_ROW,
            sqlInterpreter::$QUALIFICATION_TABLE
        );
        $qualifs_date = (string) $this->getColumnContent(
            $data, 
            sqlInterpreter::$QUALIFICATIONS_DATE_ROW,
            sqlInterpreter::$QUALIFICATION_TABLE
        );

        if(empty($qualifs) && empty($qualifs_date)) {
            return [];
        }


        if(empty($qualifs) && !empty($qualifs_date)) {
            throw new Exception("Impossible de rensigner une qualification sans son intitulé");
        }

        if(!empty($qualifs) && empty($qualifs_date)) {
            throw new Exception("Impossible de rensigner une qualification sans sa date d'obtention");
        }


        $qualifs = explode(";", $qualifs);
        $qualifs = array_map(function($c) {
            return trim($c);
        }, $qualifs); 

        $qualifs_date = explode(";", $qualifs_date);
        $qualifs_date = array_map(function($c) {
            $temp = trim($c);
            $response = $this->completeDate($temp);
            return $response;
        }, $qualifs_date); 

        $qualifs_count = count($qualifs);
        $qualifs_date_count = count($qualifs_date);
        if($qualifs_count !== $qualifs_date_count) {
            throw new Exception("Impossible d'enregistrer une qualification sans sa date d'obtenion. Le nombre de qualifications : {$qualifs_count} ne coincide pas avec le nombre de dates : {$qualifs_date_count}");
        }

        $arr = array();

        for($i = 0; $i < $qualifs_count; $i++) {
            $key_qualification = $this->searchQualificationId($qualifs[$i]);

            $this->inscriptQualification($key_candidate, $key_qualification, $qualifs_date[$i]);

            $lastId = array(
                "candidate"     => $key_candidate,
                "qualification" => $key_qualification
            );

            array_push($arr, $lastId);
        }

        return $arr;
    }

    /**
     * Protected method geeting the information of helps and register them in the database
     *
     * @param array $data The row
     * @param integer $key_candidate The candidate's primary key 
     * @return array
     */
    protected function makeHelps(array $data, int $key_candidate): array {
        $helps_str = (string) $this->getColumnContent(
            $data,
            sqlInterpreter::$HELPS_ROW,
            sqlInterpreter::$HELPS_TABLE
        );

        if(empty($helps)) {
            return [];
        }


        $helps = explode(";", $helps_str);
        $helps = array_map(function($c) {
            return trim($c);
        }, $helps);

        $arr = array();

        foreach($helps as $obj) {
            $key_help = $this->searchHelpId($obj);
            $lastId = $this->inscriptHelp($key_candidate, $key_help);
            array_push($arr, $lastId);
        }

        return $arr;
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

        $inserter = $this->getInserter();
        return $inserter->post_request($request, $candidate);
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

        if(!empty($candidate["service"]) && !empty($application["establishment"])) {
            $request .= ", Key_Services, Key_Establishments";
            $values_request .= ", :service, :estbalishment";
        }

        if(!empty($application["type"])) {
            $request .= ", Key_Types_of_contracts";
            $values_request .= ", :type";
        }

        $request .= ")" . $values_request . ")";

        $inserter = $this->getInserter();
        return $inserter->post_request($request, $application);
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

        if(!empty($contract["end_date"])) {
            $request .= ", EndDate";
            $values_request .= ", :end_date";
        }

        $request .= ")" . $values_request . ")";

        echo "<h4>Request</h4>";
        var_dump($request);
        echo "<br>";

        echo "<h4>Params</h4>";
        var_dump($contract);
        echo "<br>";

        $inserter = $this->getInserter();
        $lastId = $inserter->post_request($request, $candidate);

        echo "<h4>Id</h4>";
        var_dump($lastId);
        echo "<br>";
        
        return $lastId;
    }

    /**
     * protected method registering a new qualification 
     *
     * @param int $key_qualification The primary key of the qualification
     * @param string $date The date 
     * @return int The primary key of the registering
     */
    protected function inscriptQualification(int $key_candidate, int $key_qualification, string $date): int {
        $request = "INSERT INTO Get_qualifications (Key_Candidates, Key_Qualifications, Date) VALUES (:candidate, :qualification, :date)";

        $params = array(
            "candidate"     => $key_candidate,
            "qualification" => $key_qualification,
            "date"          => $date
        );

        $inserter = $this->getInserter();

        return $inserter->post_request($request, $params);
    }

    /**
     * protected method registering a new help 
     *
     * @param int $key_qualification The primary key of the help
     * @return int The primary key of the registering
     */
    protected function inscriptHelp(int $key_candidate, int $key_help): int {
        $request = "INSERT INTO Have_the_right_to (Key_Candidates, Key_Helps, Date) VALUES (:candidate, :help)";

        $params = array(
            "candidate" => $key_candidate,
            "help"      => $key_help
        );

        $inserter = $this->getInserter();

        return $inserter->post_request($request, $params);
    }


    // * DELETE * //
    /**
     * Public method deleting a Registering
     *
     * @param Registering $register The registering
     * @return void
     */
    public function deleteRegistering(Registering $register) {
        echo "<b>On lance la procédure de supression </b>";

        if(!empty($register->application)) {                                                            // Deleting the application
            $this->deleteApplication($register->application);
        }

        if(!empty($register->contract)) {                                                               // Deleting the contract
            $this->deleteContract($register->contract);
        }

        if(!empty($register->qualifications)) {                                                         // Deleting the qualifications
            foreach($register->qualifications as $obj) {
                $this->deleteQualification($obj["qualification"], $obj["candidate"]);
            }
        }

        if(!empty($register->helps)) {                                                                  // Deleting the helps
            foreach($register->helps as $obj) {
                $this->deleteHelp($obj);
            }
        }

        if(!empty($register->candidate)) {                                                              // Deleting the candidate
            $this->deleteCandidate($register->candidate);
        }

        echo "Register effacé : " . print_r($register) . "<br>";
    }

    /**
     * Protected method deleting a Candidate
     *
     * @param int $key_candidate The candidate's primary key
     * @return void
     */
    protected function deleteCandidate(int $key_candidate) {
        $request = "DELETE FROM Candidates WHERE Id = :id";

        $params = array("id" => $key_candidate);

        $inserter = $this->getInserter();
        
        $inserter->post_request($request, $params);
    }

    /**
     * Protected method deleting an Application
     *
     * @param int $key_application The primary key of the application
     * @return void
     */
    protected function deleteApplication(int $key_application) {
        $request = "DELETE FROM Applications WHERE Id = :id";

        $params = array("id" => $key_application);

        $inserter = $this->getInserter();
        
        $inserter->post_request($request, $params);
    }

    /**
     * Protected method deleting a Contract
     *
     * @param int $key_contract The primary key of the contract
     * @return void
     */
    protected function deleteContract(int $key_contract) {
        $request = "DELETE FROM Contracts WHERE Id = :id";

        $params = array("id" => $key_contract);

        $inserter = $this->getInserter();
        
        $inserter->post_request($request, $params);
    }

    /**
     * Protected method deleting an Help
     *
     * @param int $key_help The primary key of the help
     * @return void
     */
    protected function deleteHelp(int $key_help) {
        $request = "DELETE FROM Have_the_right_to WHERE Id = :id";

        $params = array("id" => $key_help);

        $inserter = $this->getInserter();
        
        $inserter->post_request($request, $params);
    }

    /**
     * Protected method deleting a Qualification
     *
     * @param int $key_qualification The primary key of the qualification
     * @return void
     */
    protected function deleteQualification(int $key_qualification, int $key_candidate) {
        $request = "DELETE FROM Get_qualifications WHERE Key_Candidates = :candidate AND Key_Qualifications = :qualification";

        $params = array(
            "candidate"     => $key_candidate,
            "qualification" => $key_qualification
        );

        $inserter = $this->getInserter();
        
        $inserter->post_request($request, $params);
    }


    // * SEARCH * //
    /**
     * Protected method searching an application in the database
     *
     * @param int $key_application The primary key of the application
     * @return array The application
     */
    protected function searchApplication(int $key_application): array {
        $request = "SELECT * FROM Applications WHERE Id = :id";

        $params = array("id" => $key_application);

        $response = $this->getInserter()->get_request($request, $params, true, true);

        return $response;
    }
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
     * Protected method searching a source in the database
     *
     * @param string $titled The title of the source
     * @return int The primary key of the source
     */
    protected function searchSourceId(string $titled): int {
        $request = "SELECT Id FROM Sources WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $response = $this->getInserter()->get_request($request, $params, true, true)['Id'];

        return $response;
    }
    /**
     * Protected ùethod searching a Qualification in the database
     *
     * @param string $titled The title of the qualification
     * @return int The primary key of the qulification
     */
    protected function searchQualificationId(string $titled): int {
        $request = "SELECT Id FROM Qualifications WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $inserter = $this->getInserter();

        return $inserter->get_request($request, $params, true, true)["Id"];
    }
    /**
     * Protected ùethod searching a Help in the database
     *
     * @param string $titled The title of the help
     * @return int The primary key of the help
     */
    protected function searchHelpId(string $titled): int {
        $request = "SELECT Id FROM Helps WHERE Titled = :titled";

        $params = array("titled" => $titled);

        $inserter = $this->getInserter();

        return $inserter->get_request($request, $params, true, true)["Id"];
    }
}