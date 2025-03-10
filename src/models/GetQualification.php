<?php

namespace App\models;

use App\Exceptions\GetQualificationExceptions;

/**
 * Class representing a getQualification
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class getQualification {
    /**
     * Constructor class
     *
     * @param ?int $candidate The candidate's primary key
     * @param int $qualification The prmary key of the qualification
     * @param string $date The date of the qualification
     * @throws GetQualificationExceptions if any piece of data is invalid
     */
    public function __construct(
        protected ?int $candidate,
        protected int $qualification,
        protected string $date 
    ) {
        // The primary key
        if(!empty($candidate) && $candidate <= 0) {
            throw new GetQualificationExceptions("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");
        }

        // The primary key
        if($qualification <= 0) {
            throw new GetQualificationExceptions("Clé primaire de la qualification invalide : {$candidate}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Get the candidate's primary key
     *
     * @return int
     */
    public function getCandidate(): int { return $this->candidate; }
    /**
     * Get the qualification's primary key
     *
     * @return int
     */
    public function getQualification(): int { return $this->qualification; }
    /**
     * Get the date of the qualification
     *
     * @return string
     */
    public function getDate(): string { return $this->date; }

    // * SET * //
    /**
     * Set the candidate's primary key
     *
     * @param int $candidate
     * @throws GetQualificationExceptions If the primary key of the candidate is invalid
     * @return void 
     */
    public function setCandidate(int $candidate): void { 
        if($candidate <= 0) {
            throw new GetQualificationExceptions("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");
        }

        $this->candidate = $candidate;
    }

    // * CONVERT * //
    /**
     * Public static method returning an GetQualification building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws GetQualificationExceptions If any piece of information is invalid
     * @return GetQualification The GetQualification
     */
    public static function fromArray(array $data): ?GetQualification {
        if(empty($data)) {
            throw new GetQualificationExceptions("Erreur lors de la génération du candidat. Tableau de données absent.");
        }

        return new GetQualification(
            $data["Key_Candidates"],
            $data["Key_Qualifications"],
            $data["Date"]
        );
    }

    /**
     * Public function returning the GetQualification into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "candidate"     => $this->getCandidate(),
            "qualification" => $this->getQualification(),
            "date"          => $this->getDate()
        );
    }

    /**
     * Public function returning the GetQualification into an array
     *
     * @throws GetQualificationExceptions If the primary key of the candidate is invalid
     * @return array
     */
    public function toSQL(): array {
        if(empty($this->getCandidate())) {
            throw new GetQualificationExceptions("Erreur lors de la génération de la requête SQL. Clé primaire du candidat absente.");
        }

        return $this->toArray();
    }
}