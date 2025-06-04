<?php

namespace App\Models;

use App\Exceptions\ContractExceptions;
use App\Core\Tools\DataFormatManager;
use App\Core\Tools\TimeManager;

/**
 * The contract class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Contract {
    /**
     * The constructor class
     * 
     * @param ?int $id The primary key of the contract
     * @param string $start_date The start date of the contract
     * @param ?string $end_date The end date of the contract
     * @param ?string $proposition_date The proposition date of the contract
     * @param ?string $signature_date The signature date of the contract
     * @param ?string $resignation_date The resignation date of the contract
     * @param bool $refused If the contract has been refused
     * @param ?int $salary The salary of the contract
     * @param ?int $hourly_rate The hourly rate of the contract
     * @param bool $night_work If the contract contains night work
     * @param bool $wk_work If the contract contains week-end work
     * @param int $candidate_key The primary key of the candidate
     * @param int $job_key The primary key of the job
     * @param int $service_key The primary key of the service
     * @param int $establishment_key The primary key of the establishment
     * @param int $type_key The primary key of the type
     * @throws ContractExceptions If any piece of information is invalid
     * @return void
     */
    public function __construct(
        protected ?int $id, 
        protected string $start_date,
        protected ?string $end_date,
        protected ?string $proposition_date, 
        protected ?string $signature_date,
        protected ?string $resignation_date,
        protected bool $refused, 
        protected ?int $salary, 
        protected ?int $hourly_rate,
        protected bool $night_work,
        protected bool $wk_work, 
        protected int $candidate_key,
        protected int $job_key,
        protected int $service_key,
        protected int $establishment_key,
        protected int $type_key
    ) {
        // The primary key
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new ContractExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // The start date
        if(!TimeManager::isDate($start_date)) {
            throw new ContractExceptions("Date de début invalide : {$start_date}.");
        }

        // The end date
        if(!is_null($end_date) && !TimeManager::isDate($end_date)) {
            throw new ContractExceptions("Date de fin invalide : {$end_date}.");
        }

        // The proposition date
        if(!is_null($proposition_date) && !TimeManager::isDate($proposition_date)) {
            throw new ContractExceptions("Date de proposition invalide : {$proposition_date}.");
        }

        // The signature date
        if(!is_null($signature_date) && !TimeManager::isDate($signature_date)) {
            throw new ContractExceptions("Date de signature invalide : {$signature_date}.");
        }

        // The resignation date
        if(!is_null($resignation_date) && !TimeManager::isDate($resignation_date)) {
            throw new ContractExceptions("Date de démission invalide : {$resignation_date}.");
        }

        // The hourly rate
        if(!is_null($hourly_rate) && !self::isValidHourlyRate($hourly_rate)) {
            throw new ContractExceptions("Taux horaire invalide : {$hourly_rate}. Taux horaire attendu entre 0 et 48.");
        }

        // The salary
        if(!is_null($salary) && !self::isValidSalary($salary)) {
            throw new ContractExceptions("Salaire invalide : {$salary}. Salaire attendu strictement positif.");
        }

        // The candidate's primary key
        if(!DataFormatManager::isValidKey($candidate_key)) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$candidate_key}. Clé attendue strictement positive.");
        }

        // The primary key of the job
        if(!DataFormatManager::isValidKey($job_key)) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$job_key}. Clé attendue strictement positive.");
        }

        // The primary key of the service
        if(!DataFormatManager::isValidKey($service_key)) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$service_key}. Clé attendue strictement positive.");
        }

        // The primary key of the establishment
        if(!DataFormatManager::isValidKey($establishment_key)) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$establishment_key}. Clé attendue strictement positive.");
        }

        // The primary key of the type
        if(!DataFormatManager::isValidKey($type_key)) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$type_key}. Clé attendue strictement positive.");
        }
    }

    /**
     * Public static method method building and returning a new contract
     * 
     * @param int $candidate The candidate's primary key
     * @param int $job The primary key of the job
     * @param int $service The primary key of the service
     * @param int $estbalishement The primary key of the establishment
     * @param int $type The primary key of the type
     * @param string $start_date The start date of the contract
     * @param ?string $end_date The end date of the contract
     * @param ?int $salary The salary of the contract
     * @param ?int $hourly_rate The hourly rate of the contract
     * @param bool $night_work If the contract contains night work
     * @param bool $wk_work If the contract contains week-end work
     * @param ?string $signature The date of the signature
     * @return Contract The contract
     */
    public static function create(
        int $candidate, 
        int $job, 
        int $service, 
        int $estbalishement, 
        int $type, 
        string $start_date, 
        ?string $end_date = null, 
        ?int $salary = null,
        ?int $hourly_rate = null,
        bool $night_work = false,
        bool $wk_work = false,
        ?string $signature = null
    ): Contract {
        return new Contract(
            null,
            $start_date,
            $end_date,
            null,
            $signature,
            null,
            false,
            $salary,
            $hourly_rate,
            $night_work,
            $wk_work,
            $candidate,
            $job,
            $service,
            $estbalishement,
            $type
        );
    }

    // * GET * //
    /**
     * Public function returning the primary key of the contract
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public function returning the start date of the contract
     * 
     * @return string
     */
    public function getStartDate(): string { return $this->start_date; }
    /**
     * Public function returning the end date of the contract
     * 
     * @return ?string
     */
    public function getEndDate(): ?string { return $this->end_date; }
    /**
     * Public function returning the proposition date of the contract
     * 
     * @return ?string
     */
    public function getProposition(): ?string { return $this->proposition_date; }
    /**
     * Public function returning the signature date of the contract
     * 
     * @return ?string
     */
    public function getSignature(): ?string { return $this->signature_date; }
    /**
     * Public function returning the resignation date of the contract
     * 
     * @return ?string
     */
    public function getResignation(): ?string { return $this->resignation_date; }
    /**
     * Public function returning if the contract has been refused
     * 
     * @return bool
     */
    public function getRefused(): bool { return $this->refused; }
    /**
     * Public function returning the salary of the contract
     * 
     * @return ?int
     */
    public function getSalary(): ?int { return $this->salary; }
    /**
     * Public function returning the hourly rate of the contract
     * 
     * @return ?int
     */
    public function getHourlyRate(): ?int { return $this->hourly_rate; }
    /**
     * Public function returning if the contract contains night work
     * 
     * @return bool
     */
    public function getNightWork(): bool { return $this->night_work; }
    /**
     * Public function returning  if the contract contains week-end work
     * 
     * @return bool
     */
    public function getWkWork(): bool { return $this->wk_work; }
    /**
     * Public function returning the primary key of the candidate
     * 
     * @return ?int
     */
    public function getCandidate(): int { return $this->candidate_key; }
    /**
     * Public function returning the primary key of the job
     * 
     * @return ?int
     */
    public function getJob(): int { return $this->job_key; }
    /**
     * Public function returning the primary key of the service
     * 
     * @return ?int
     */
    public function getService(): int { return $this->service_key; }
    /**
     * Public function returning the primary key of the establishment
     * 
     * @return ?int
     */
    public function getEstbalishement(): int { return $this->establishment_key; }
    /**
     * Public function returning the primary key of the type
     * 
     * @return ?int
     */
    public function getType(): int { return $this->type_key; }

    // * ADD * // 
    /**
     * Public method adding a signature to the contract
     * 
     * @param string $signature The signature date
     * @return void
     */
    public function addSignature(?string $signature = null): void {
        if(empty($signature)) {
            $signature = date("Y-m-d");
        }

        $this->signature_date = $signature;
    }
    /**
     * Public method adding a resignation to the contract
     * 
     * @param string $resignation The resignation date
     * @return void
     */
    public function addResignation(?string $resignation = null): void {
        if(empty($resignation)) {
            $resignation = date("Y-m-d");
        }

        $this->resignation_date = $resignation;
    }

    // * CONVERT * //
    /**
     * Public static method returning an Contract building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws ContractExceptions If any piece of information is invalid
     * @return Contract The contract
     */
    public static function fromArray(array $data): ?Contract {
        if(empty($data)) {
            throw new ContractExceptions("Erreur lors de la génération de l'action. Tableau de données absent.");
        }

        return new Contract(
            $data["Id"],
            $data["StartDate"], 
            $data["EndDate"], 
            $data["PropositionDate"], 
            $data["SignatureDate"],
            $data["ResignationDate"],
            $data["IsRefused"],
            $data["Salary"],
            $data["HourlyRate"],
            $data["NightWork"],
            $data["WeekEndWork"],
            $data["Key_Candidates"],
            $data["Key_Jobs"],
            $data["Key_Services"],
            $data["Key_Establishments"],
            $data["Key_Types_of_contracts"]
        );
    }

    /**
     * Public function returning the action into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "id"            => $this->getId(),
            "start_date"    => $this->getStartDate(),
            "end_date"      => $this->getEndDate(),
            "proposition"   => $this->getProposition(),
            "signature"     => $this->getSignature(),
            "resignation"   => $this->getResignation(),
            "refused"       => $this->getRefused(),
            "salary"        => $this->getSalary(),
            "hourly_rate"   => $this->getHourlyRate(),
            "night_work"    => $this->getNightWork(),
            "wk_work"       => $this->getWkWork(),
            "candidate"     => $this->getCandidate(),
            "job"           => $this->getJob(),
            "service"       => $this->getService(),
            "establishment" => $this->getEstbalishement(),
            "type"          => $this->getType()
        );
    }

    /**
     * Public function returning the action into an array  for SQL registering
     * 
     * @param boolean $data_insert Boolean showing if, false: it's a classic registering (from the application) or, true : a data insert from xlsx
     * @return array The Contract
     */
    public function toSQL(bool $data_insert = false): array {
        $response = [
            "start_date"    => $this->getStartDate(),
            "candidate"     => $this->getCandidate(),
            "job"           => $this->getJob(),
            "service"       => $this->getService(),
            "establishment" => $this->getEstbalishement(),
            "type"          => $this->getType()
        ];

        if($data_insert) {
            $response["proposition_date"] = $this->getStartDate();
            $response["signature_date"]   = $this->getStartDate();
        }

        if(!is_null($this->getEndDate())) {
            $response["end_date"] = $this->getEndDate();
        }

        if(!is_null($this->getSalary())) {
            $response["salary"] = $this->getSalary();
        }

        if(!is_null($this->getHourlyRate())) {
            $response["hourly_rate"] = $this->getHourlyRate();
        }

        if($this->getNightWork() == true) {
            $response["night_work"] = $this->getNightWork();
        }

        if($this->getWkWork() == true) {
            $response["week_end_work"] = $this->getWkWork();
        }

        return $response;
    }

    // * CHECK * //
    /**
     * public static method checking if the hourly rate is valid
     *
     * @param int $rate The hourly rate
     * @return boolean
     */
    public static function isValidHourlyRate(int $rate): bool {
        return 0 < $rate && $rate < 48;
    }

    /**
     * public static method checking if the salary is valid
     *
     * @param int $salary The salary
     * @return boolean
     */
    public static function isValidSalary(int $salary): bool {
        return 0 < $salary;
    }
}