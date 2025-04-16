<?php

namespace App\models;

use App\Core\Tools\DataFormatManip;
use App\Exceptions\GetQualificationExceptions;
use App\Core\Moment;

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
        if(!is_null($candidate) && !DataFormatManip::isValidKey($candidate)) {
            throw new GetQualificationExceptions("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");
        }

        // The primary key
        if(!DataFormatManip::isValidKey($qualification)) {
            throw new GetQualificationExceptions("Clé primaire de la qualification invalide : {$qualification}. Clé attendue strictement positive.");
        }

        if(!Moment::isDate($date)) {
            throw new GetQualificationExceptions("Date de la qualification invalide : {$qualification}.");
        }
    }

    // * GET * //
    /**
     * Get the candidate's primary key
     *
     * @return int
     */
    public function getCandidate(): ?int { return $this->candidate; }
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
        if(!DataFormatManip::isValidKey($candidate)) {
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