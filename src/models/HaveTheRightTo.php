<?php

namespace App\Models;

use App\Core\Tools\DataFormat\DataFormatManager;
use App\Exceptions\HaveTheRightToExceptions;

class HaveTheRightTo {
    /**
     * Constructor class
     *
     * @param ?int $candidate The candidate's primary key
     * @param int $help The primary key of the help
     * @param ?int $employee The employee's primary key
     * @throws HaveTheRightToExceptions if any piece of data is invalid
     */
    public function __construct(
        protected ?int $candidate,
        protected int $help,
        protected ?int $employee
    ) {
        if(!is_null($candidate) && !DataFormatManager::isValidKey($candidate)) {
            throw new HaveTheRightToExceptions("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");
        }

        if(!DataFormatManager::isValidKey($help)) {
            throw new HaveTheRightToExceptions("Clé primaire de l'aide invalide : {$help}. Clé attendue strictement positive.");
        }

        if(!is_null($employee) && !DataFormatManager::isValidKey($employee)) {
            throw new HaveTheRightToExceptions("Clé primaire de l'employé invalide : {$employee}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Get the candidate's primary key
     *
     * @return ?int
     */
    public function getCandidate(): ?int { return $this->candidate; }
    /**
     * Get the help's primary key
     *
     * @return int
     */
    public function getHelp(): int { return $this->help; }
    /**
     * Get the employee's primary key
     *
     * @return ?int
     */
    public function getEmployee(): ?int { return $this->employee; }

    // * SET * //
    /**
     * Set the candidate's primary key
     *
     * @param int $candidate
     * @throws HaveTheRightToExceptions if the primary key is invalid
     * @return void
     */
    public function setCandidate(int $candidate): void {
        if(!DataFormatManager::isValidKey($candidate)) {
            throw new HaveTheRightToExceptions("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");
        }

        $this->candidate = $candidate;
    }

    // * CONVERT * //
    /**
     * Public static method returning an HaveTheRightTo building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws HaveTheRightToExceptions If any piece of information is invalid
     * @return HaveTheRightTo The HaveTheRightTo
     */
    public static function fromArray(array $data): ?HaveTheRightTo {
        if(empty($data)) {
            throw new HaveTheRightToExceptions("Erreur lors de la génération du droit à l'aide. Tableau de données absent.");
        }

        return new HaveTheRightTo(
            $data["Key_Candidates"],
            $data["Key_Helps"],
            $data["Key_Employee"]
        );
    }

    /**
     * Public function returning the HaveTheRightTo into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "candidate" => $this->getCandidate(),
            "help"      => $this->getHelp(),
            "employee"  => $this->getEmployee()
        );
    }

    /**
     * Public function returning the HaveTheRightTo into an array
     *
     * @throws HaveTheRightToExceptions If the primary key of the candidate is invalid
     * @return array
     */
    public function toSQL(): array {
        if(empty($this->getCandidate())) {
            throw new HaveTheRightToExceptions("Erreur lors de la génération de la requête SQL. Clé primaire du candidat absente.");
        }

        $response = array(
            "candidate" => $this->getCandidate(),
            "help"      => $this->getHelp()
        );

        if($this->getEmployee()) {
            $response["employee"] = $this->getEmployee();
        }

        return $response;
    }
}