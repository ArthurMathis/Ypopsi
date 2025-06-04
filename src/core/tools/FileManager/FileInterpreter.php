<?php

namespace App\Core\Tools\FileManager;

use \Exception;
use App\Exceptions\DataInsertionExceptions;
use App\Core\Tools\Registering;
use App\Core\Tools\DataFormat\TimeManager;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Contract;
use App\Models\GetQualification;
use App\Models\HaveTheRightTo;
use App\Repository\ApplicationRepository;
use App\Repository\CandidateRepository;
use App\Repository\ContractRepository;
use App\Repository\EstablishmentRepository;
use App\Repository\GetQualificationRepository;
use App\Repository\HaveTheRightToRepository;
use App\Repository\HelpRepository;
use App\Repository\JobRepository;
use App\Repository\QualificationRepository;
use App\Repository\ServiceRepository;
use App\Repository\SourceRepository;
use App\Repository\TypeOfContractsRepository;
use InvalidArgumentException;

/**
 * Class analzing an arrray and making a database request 
 */
class FileInterpreter {
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


    /**
     * Constructor class
     *
     * @param array $rowStructure The structure of rows 
     */
    public function __construct(protected array $rowStructure) {}

    // * GET * //
    /**
     * Protected method returning the structure of rows
     *
     * @return array
     */
    protected function getStructure(): array { return $this->rowStructure; }

    /**
     * Protected method returning the index of a column
     *
     * @param string $titled The title of the column
     * @return int
     */
    protected function getIndex(string &$titled): int {
        $index = FileInterpreter::$BASED_INDEX;
        $structure = $this->getStructure();

        $i = 0;
        $size = count($structure);
        while($index === FileInterpreter::$BASED_INDEX && $i < $size) {
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
    protected function getColumnContent(
        array &$data, 
        string $column, 
        string $table_err, 
        bool $present = false
    ): ?string {
        $index = $this->getIndex($column);
        if($index == FileInterpreter::$BASED_INDEX) {
            throw new DataInsertionExceptions("La colonne {$column} est introuvable");
        }

        $response = $data[$index];
        if($present && empty($response)) {
            throw new DataInsertionExceptions("Impossible d'enregistrer un(e) nouveau(elle) {$table_err} sans {$column}.");
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
        $registering->candidate = $this->makecandidate($data); 
        $registering->application = $this->makeApplication($data, $registering->candidate);
        $registering->contract = $this->makeContract($data, $registering->candidate, $registering->application);
        $registering->qualification = $this->makeQualification($data, $registering->candidate);
        $registering->helps = $this->makeHelps($data, $registering->candidate);
    }

    // * MAKE * //
    /**
     * Protected method getting the candidate's information and register him in the database
     *
     * @param array $data The row
     * @return int The candidate's primary key
     */
    protected function makeCandidate(array &$data): int {
        $str_gender = $this->getColumnContent(
            $data, 
            FileInterpreter::$GENDER_ROW, 
            FileInterpreter::$CANDIDATE_TABLE
        );
        $gender = null;
        switch($str_gender) {
            case FileInterpreter::$MALE: 
                $gender = true;
                break; 

            case FileInterpreter::$FEMALE:
                $gender = false;
                break;

            default : throw new Exception("Impossible d'enregistrer un candidat avec un sexe invalide. Valeur attendue : " 
                            . FileInterpreter::$MALE . " - pour homme et " . FileInterpreter::$FEMALE . " - pour femme.");
        }

        $availability = $this->getColumnContent(
            $data, 
            FileInterpreter::$STARTING_DATE_ROW, 
            FileInterpreter::$CANDIDATE_TABLE
        );
        $availability = $availability ? $this->completeDate($availability) : null;

        $candidate = new Candidate(
            id  : null,
            name: (string) $this->getColumnContent(
                    $data, 
                    FileInterpreter::$NAME_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            firstname: (string) $this->getColumnContent(
                    $data, 
                    FileInterpreter::$FIRSTNAME_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            gender: $gender,
            email : $this->getColumnContent(
                    $data, 
                    FileInterpreter::$EMAIL_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            phone: $this->getColumnContent(
                    $data, 
                    FileInterpreter::$PHONE_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            address: $this->getColumnContent(
                    $data, 
                    FileInterpreter::$ADDRESS_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            city: $this->getColumnContent(
                    $data,
                    FileInterpreter::$CITY_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            postcode: $this->getColumnContent(
                    $data, 
                    FileInterpreter::$POSTCODE_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            rating: $this->getColumnContent(
                    $data, 
                    FileInterpreter::$RATING_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            description: $this->getColumnContent(
                    $data, 
                    FileInterpreter::$DESCRIPTION_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                ),
            availability: $availability,
            a: (bool) !empty($this->getColumnContent(
                    $data, 
                    FileInterpreter::$BL_A_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                )), 
            b: (bool) !empty($this->getColumnContent(
                    $data,
                    FileInterpreter::$BL_B_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                )), 
            c: (bool) !empty($this->getColumnContent(
                    $data, 
                    FileInterpreter::$BL_C_ROW, 
                    FileInterpreter::$CANDIDATE_TABLE
                )), 
            visit  : null,
            deleted: false
        );

        return (new CandidateRepository())->inscript($candidate);
    }

    /**
     * Protected method geeting the information of an application and register its in the database
     *
     * @param array $data The row 
     * @param int $key_candidate The candidate's primary key
     * @throws DataInsertionExceptions If the application is invalid
     * @throws PDOException If any piece of the application's data is invalid
     * @return int The primary key of the application
     */
    protected function makeApplication(array &$data, int $key_candidate): int {
        $job = (string) $this->getColumnContent(
            $data, 
            FileInterpreter::$JOB_ROW, 
            FileInterpreter::$APPLICATION_TABLE, 
            FileInterpreter::$REQUIRED
        );

        $service = $this->getColumnContent(
            $data, 
            FileInterpreter::$SERVICE_ROW, 
            FileInterpreter::$APPLICATION_TABLE
        );
        $estbablishment = $this->getColumnContent(
            $data, 
            FileInterpreter::$ESTABLISHMENT_ROW, 
            FileInterpreter::$APPLICATION_TABLE
        );

        $source = (string) $this->getColumnContent(
            $data, 
            FileInterpreter::$SOURCE_ROW, 
            FileInterpreter::$APPLICATION_TABLE,
            FileInterpreter::$REQUIRED
        );

        $type = $this->getColumnContent(
            $data, 
            FileInterpreter::$TYPE_OF_CONTRACTS_ROW, 
            FileInterpreter::$APPLICATION_TABLE
        );

        $gender = (new CandidateRepository())->get($key_candidate)->getGender();

        $application = new Application(
            id               : null,
            candidate_key    : $key_candidate,
            job_key          : (new JobRepository())->search($job, $gender)->getId(),
            establishment_key: is_string($estbablishment) ? (new EstablishmentRepository())->search($estbablishment)->getId() : null,
            service_key      : is_string($service) ? (new ServiceRepository())->search($service)->getId() : null,
            source_key       : (new SourceRepository())->search($source)->getId(),
            type_key         : is_string($type) ? (new TypeOfContractsRepository())->search($type)->getId() : null,
            need_key         : null,
            date             : null,
            is_accepted      : false,
            is_refused       : false,
        );

        return (new ApplicationRepository())->inscript($application);
    }

    /**
     * Protected method geeting the information of a contract and register its in the database
     *
     * @param array $data The row
     * @param int $key_candidate The candidate's primary key 
     * @param int $key_application The primary key of the application
     * @throws DataInsertionExceptions If the contract is invalid
     * @throws PDOException If any piece of the contract's data is invalid
     * @return ?int
     */
    protected function makeContract(array &$data, int $key_candidate, int $key_application): ?int {
        $application = (new ApplicationRepository())->get($key_application);                                                        // fetching the application
        $completed_application = !empty($application->getService()) 
                                && !empty($application->getEstablishment()) 
                                && !empty($application->getType());

        $start_date = (string) $this->getColumnContent(                                                                             // Getting the start date
            $data, 
            FileInterpreter::$STARTING_DATE_ROW, 
            FileInterpreter::$CONTRACT_TABLE,
            FileInterpreter::$NOT_REQUIRED
        );
        $start_date = $this->completeDate($start_date);
        if(!$completed_application || empty($start_date)) {                                                                         // Testing data integrity
            return null;
        }

        $end_date = (string) $this->getColumnContent(                                                                               // Getting the end date
            $data,
            FileInterpreter::$ENDING_DATE_ROW, 
            FileInterpreter::$CONTRACT_TABLE
        );
        $end_date = $end_date ? $this->completeDate($end_date) : null;

        $contract = new Contract(
            id               : null,
            start_date       : $start_date,
            end_date         : $end_date,
            proposition_date : $start_date,
            signature_date   : $start_date,
            resignation_date : null,
            refused          : false,
            salary           : null,
            hourly_rate      : null,
            night_work       : false,
            wk_work          : false,
            candidate_key    : $key_candidate,
            job_key          : $application->getJob(),
            service_key      : $application->getService(),
            establishment_key: $application->getEstablishment(),
            type_key         : $application->getType()
        );

        return (new ContractRepository())->inscript(contract: $contract, data_insert: true);                                                                     // Registering the contract
    }

    /**
     * Protected method geeting the information of qualification and register them in the database 
     *
     * @param array $data The row
     * @param int $key_candidate The candidate's primary key 
     * @throws DataInsertionExceptions If the qualification is invalid
     * @throws PDOException If any piece of the qualification's data is invalid
     * @return ?int
     */
    protected function makeQualification(array $data, int $key_candidate): ?int {
        $qualification = (string) $this->getColumnContent(                                                            // Getting the qualifications
            $data, 
            FileInterpreter::$QUALIFICATIONS_ROW,
            FileInterpreter::$QUALIFICATION_TABLE
        );

        $qualification_date = (string) $this->getColumnContent(                                                       // Getting the qualifications' date
            $data, 
            FileInterpreter::$QUALIFICATIONS_DATE_ROW,
            FileInterpreter::$QUALIFICATION_TABLE
        );
        $qualification_date = $qualification_date ? $this->completeDate($qualification_date) : null;

        if(empty($qualification) && empty($qualification_date)) {                                                     // Testing if the qualifications are empty
            return null;
        }

        $get_qualification = new GetQualification(
            candidate    : $key_candidate,
            qualification: (new QualificationRepository())->search($qualification)->getId(),
            date         : $qualification_date
        );

        $lastId = (new GetQualificationRepository())->inscript($get_qualification);                                 // Registering the qualification
        return $lastId;
    }

    /**
     * Protected method geeting the information of helps and register them in the database
     * 
     * todo : gérer les primes de cooptations ?
     *
     * @param array $data The row
     * @param integer $key_candidate The candidate's primary key 
     * @throws DataInsertionExceptions If the help is invalid
     * @throws PDOException If any piece of the help's data is invalid
     * @return array
     */
    protected function makeHelps(array $data, int $key_candidate): array {
        $helps_str = (string) $this->getColumnContent(                                                           // Getting the helps
            $data,
            FileInterpreter::$HELPS_ROW,
            FileInterpreter::$HELPS_TABLE
        );

        if(empty($helps)) {                                                                                     // Testing if the helps are empty
            return [];
        }

        $helps = explode(";", $helps_str);
        $helps = array_map(function($c) {
            return trim($c);
        }, $helps);

        $response = [];
        $help_repo = new HelpRepository();
        $have_repo = new HaveTheRightToRepository();
        foreach($helps as $obj) {
            $help = $help_repo->search($obj);
            $have = new HaveTheRightTo(
                candidate: $key_candidate,
                help: $help->getId(),
                employee: null
            );

            $lastId = $have_repo->inscript($have);
            array_push($response, $lastId);
        }

        return $response;
    }

    // * DELETE * //
    /**
     * Public method deleting a Registering
     *
     * @param Registering $register The registering
     * @return void
     */
    public function deleteRegistering(Registering $register) {
        if(!empty($register->application)) {                                                            // Deleting the application
            (new ApplicationRepository())->securityRemove($register->application);
        }

        if(!empty($register->contract)) {                                                               // Deleting the contract
            (new ContractRepository())->securityRemove($register->contract);
        }

        if(!empty($register->qualifications)) {                                                         // Deleting the qualification
            (new GetQualificationRepository())->securityRemove($register->qualification);
        }

        if(!empty($register->helps)) {                                                                  // Deleting the helps
            (new HaveTheRightToRepository())->securityRemove($register->helps[0]["candidate"]);
        }

        if(!empty($register->candidate)) {                                                              // Deleting the candidate
            (new CandidateRepository())->securityRemove($register->candidate);
        }
    }

    // * CONVERT * //
        /**
     * Protected method converting an Excel date to a string
     * 
     * 25569 est le nombre de jours entre le 1er janvier 1900 et le 1er janvier 1970
     *
     * @param int $excelDate The Excel date
     * @return string
     */
    protected function excelToDate(int $excelDate): string {
        $unixDate = ($excelDate - 25569) * 86400; 
        return date('Y-m-d', $unixDate);
    }

    /**
     * Protected method adapting the date format 
     *
     * @param string $date The date
     * @return string
     */
    protected function completeDate(string $date): string {
        switch($date) {
            case TimeManager::isYmdDate($date, 'Y-m-d'): 
                return $date;

            case TimeManager::isYmdDate($date . '-01', 'Y-m-d'): 
                return $date . '-01';

            case TimeManager::isYmdDate($date . '-01-01', 'Y-m-d'): 
                return $date . '-01-01';

            case (bool) preg_match('/^\d{5}$/', $date):
                return $this->excelToDate((int) $date);

            default: throw new InvalidArgumentException("Impossible d'enregistrer une date invalide : {$date}.");
        }
    }
}