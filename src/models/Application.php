<?php

namespace App\Models;

use App\Exceptions\ApplicationExceptions;
use App\Core\Tools\DataFormatManager;
use App\Core\Tools\TimeManager;

/**
 * Class representing an application
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Application {
    /**
     * Constructor class
     * 
     * @param ?int $id
     * @param bool $is_accepted
     * @param bool $is_refused
     * @param string date
     * @param int $candidate_key
     * @param int job_key
     * @param ?int $type_key
     * @param int $source
     * @param ?int $need_key
     * @param ?int $establishment_key 
     * @param ?int $service_key
     * @throws ApplicationExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected bool $is_accepted,
        protected bool $is_refused,
        protected ?string $date, 
        protected int $candidate_key, 
        protected int $job_key, 
        protected ?int $type_key, 
        protected int $source_key, 
        protected ?int $need_key, 
        protected ?int $establishment_key, 
        protected ?int $service_key
    ) {
        // The primary key
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new ApplicationExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // The date
        if(!is_null($date) && !TimeManager::isFullDate($date)) {
            throw new ApplicationExceptions("Date invalide : {$date}.");
        }

        // The candidate's primary key
        if(!DataFormatManager::isValidKey($candidate_key)) {
            throw new ApplicationExceptions("Clé primaire du candidat invalide : {$candidate_key}. Clé attendue strictement positive.");
        }

        // The job's primary key
        if(!DataFormatManager::isValidKey($job_key)) {
            throw new ApplicationExceptions("Clé primaire du poste invalide : {$job_key}. Clé attendue strictement positive.");
        }

        // The type of contract's primary key
        if(!is_null($type_key) && !DataFormatManager::isValidKey($type_key)) {
            throw new ApplicationExceptions("Clé primaire du type de contrat invalide : {$type_key}. Clé attendue strictement positive.");
        }

        // The source's primary key
        if(!DataFormatManager::isValidKey($source_key)) {
            throw new ApplicationExceptions("Clé primaire de la source invalide : {$source_key}. Clé attendue strictement positive.");
        }

        // The candidate's primary key
        if(!is_null($need_key) && !DataFormatManager::isValidKey($need_key)) {
            throw new ApplicationExceptions("Clé primaire du besoin invalide : {$need_key}. Clé attendue strictement positive.");
        }

        // The candidate's primary key
        if(!is_null($establishment_key) && !DataFormatManager::isValidKey($establishment_key)) {
            throw new ApplicationExceptions("Clé primaire de l'établissement invalide : {$establishment_key}. Clé attendue strictement positive.");
        }

        // The candidate's primary key
        if(!is_null($service_key) && !DataFormatManager::isValidKey($service_key)) {
            throw new ApplicationExceptions("Clé primaire du service invalide : {$service_key}. Clé attendue strictement positive.");
        }

        // todo : tester la contrainte sql
    }

    /**
     * Public static method building and returning a new Application
     * 
     * @param int $candidate
     * @param int $job 
     * @param int $source
     * @param ?int $type
     * @param ?int $establishment
     * @param ?int $service
     * @param ?int $need 
     * @return Application
     */
    public static function create(
        int $candidate, 
        int $job, 
        int $source, 
        ?int $type = null, 
        ?int $establishment = null, 
        ?int $service = null, 
        ?int $need = null
    ): Application {
        return new Application(
            null, 
            false, 
            false, 
            null, 
            $candidate,
            $job, 
            $type, 
            $source, 
            $need, 
            $establishment, 
            $service
        );
    }

    // * GET * //
    /**
     * Public function returning the primary key of the application
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public function returning if the application is accepted
     * 
     * @return bool
     */
    public function getAccepted(): bool { return $this->is_accepted; }
    /**
     * Public function returning if the application is refused
     * 
     * @return bool
     */
    public function getRefused(): bool { return $this->is_refused; }
    /**
     * Public function returning the date of the application
     * 
     * @return string
     */
    public function getDate(): ?string { return $this->date; }
    /**
     * Public function returning the primary key of the candidate
     * 
     * @return int
     */
    public function getCandidate(): int { return $this->candidate_key; }
    /**
     * Public function returning the primary key of the job
     * 
     * @return int
     */
    public function getJob(): int { return $this->job_key; }
    /**
     * Public function returning the primary key of the type of the contract
     * 
     * @return ?int
     */
    public function getType(): ?int { return $this->type_key; }
    /**
     * Public function returning the primary key of the source of the application
     * 
     * @return int
     */
    public function getSource(): int { return $this->source_key; }
    /**
     * Public function returning the primary key of the need
     * 
     * @return ?int
     */
    public function getNeed(): ?int { return $this->need_key; } 
    /**
     * Public function returning the primary key of the establishment
     * 
     * @return ?int
     */
    public function getEstablishment(): ?int { return $this->establishment_key; } 
    /**
     * Public function returning the primary key of the service
     * 
     * @return ?int
     */
    public function getService(): ?int { return $this->service_key; } 

    // * CONVERT * //
    /**
     * Public static method returning an Application building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws ApplicationExceptions If any piece of information is invalid
     * @return Application The application
     */
    public static function fromArray(array $data): ?Application {
        if(empty($data)) {
            throw new ApplicationExceptions("Erreur lors de la génération de l'action. Tableau de données absent.");
        }

        return new Application(
            $data["Id"],
            $data["IsAccepted"],
            $data["IsRefused"],
            $data["Moment"],
            $data["Key_Candidates"],
            $data["Key_Jobs"],
            $data["Key_Types_of_contracts"],
            $data["Key_Sources"],
            $data["Key_Needs"],
            $data["Key_Establishments"],
            $data["Key_Services"]
        );
    }

    /**
     * Public function returning the application into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "id"            => $this->getId(),
            "accepted"      => $this->getAccepted(),
            "refused"       => $this->getRefused(),
            "date"          => $this->getDate(),
            "candidate"     => $this->getCandidate(),
            "job"           => $this->getJob(),
            "type"          => $this->getType(),
            "source"        => $this->getSource(),
            "need"          => $this->getNeed(),
            "establishment" => $this->getEstablishment(),
            "service"       => $this->getService()
        );
    }

    /**
     * Public function returning the application into an array for SQL registering
     * 
     * @return array The application
     */
    public function toSQL(): array {
        $response = array(
            "candidate" => $this->getCandidate(),
            "job"       => $this->getJob(),
            "source"    => $this->getSource()
        );

        if(!empty($this->getType())) {
            $response["type"] = $this->getType();
        }

        if(!empty($this->getservice()) && !empty($this->getEstablishment())) {
            $response["service"]       = $this->getservice();
            $response["establishment"] = $this->getEstablishment();
        }

        return $response;
    }
}