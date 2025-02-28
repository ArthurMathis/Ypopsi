<?php

namespace App\Models;

use App\Exceptions\ContractExceptions;

/**
 * The contract class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
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
        if(!empty($id) && $id <= 0) {
            throw new ContractExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // The candidate's primary key
        if($candidate_key <= 0) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$candidate_key}. Clé attendue strictement positive.");
        }

        // The primary key of the job
        if($job_key <= 0) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$job_key}. Clé attendue strictement positive.");
        }

        // The primary key of the service
        if($service_key <= 0) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$service_key}. Clé attendue strictement positive.");
        }

        // The primary key of the establishment
        if($establishment_key <= 0) {
            throw new ContractExceptions("Clé primaire de l'utilisateur invalide : {$establishment_key}. Clé attendue strictement positive.");
        }

        // The primary key of the type
        if($type_key <= 0) {
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
        bool $wk_work = false
    ): Contract {
        return new Contract(
            null,
            $start_date,
            $end_date,
            null,
            null,
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
    public function addSignature(string $signature = null): void {
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
    public function addResignation(string $resignation = null): void {
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
     * @return array The Contract
     */
    public function toSQL(): array {
        $response = array(
            "start_date"     => $this->getStartDate(),
            "candidate"      => $this->getCandidate(),
            "job"            => $this->getJob(),
            "service"        => $this->getService(),
            "establishment" => $this->getEstbalishement(),
            "type"           => $this->getType()
        );

        if(!empty($this->getSalary())) {
            $response["salary"] = $this->getSalary();
        }

        if(!empty($this->getHourlyRate())) {
            $response["hourly_rate"] = $this->getHourlyRate();
        }

        if(!empty($this->getNightWork())) {
            $response["night_work"] = $this->getNightWork();
        }

        if(!empty($this->getWkWork())) {
            $response["wk_work"] = $this->getWkWork();
        }

        return $response;
    }
}