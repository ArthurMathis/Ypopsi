<?php

namespace App\Models;

use App\Exceptions\MeetingExceptions;

/**
 * Class representing a meeting
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Meeting {
    /**
     * Constructor class
     * 
     * @param int $id The primary key of the meeting
     * @param string $date The date of the meeting
     * @param ?string $description The description of the meeting
     * @param int $user_key The primary key of the user
     * @param int $candidate_key The primary key of the candidate
     */
    public function __construct(
        protected int $id, 
        protected string $date, 
        protected ?string $description, 
        protected int $user_key, 
        protected int $candidate_key
    ) {
        $this->setId($id);
        $this->setUser($user_key);
        $this->setCandidate($candidate_key);
    }

    // * GET * //
    /**
     * Public method returning the primary key of the meeting
     * 
     * @return int
     */
    public function getId(): int { return $this->id; }
    /**
     * Public method returning the date of the meeting
     * 
     * @return string
     */
    public function getDate(): string { return $this->date; }
    /**
     * Public method returning the description of the meeting
     * 
     * @return ?string
     */
    public function getDescription(): ?string { return $this->description; }
    /**
     * Public method returning the primary key of the user
     * 
     * @return int
     */
    public function getUser(): Int { return $this->user_key; }
    /**
     * Public method returning the primary key of the candidate
     * 
     * @return int
     */
    public function getCandidate(): Int { return $this->candidate_key; }

    // * SET * //
    /**
     * Protected method setting the id of the meeting 
     * 
     * @param int $id The new id
     * @throws MeetingExceptions If $id is invalid
     * @return void
     */
    protected function setId(int $id) {
        if($id <= 0) {
            throw new MeetingExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        $this->id = $id;
    }
    /**
     * Protected method setting the primary key of the user 
     * 
     * @param int $user_key The new primary key
     * @throws MeetingExceptions If $id is invalid
     * @return void
     */
    protected function setUser(int $user_key) {
        if($user_key <= 0) {
            throw new MeetingExceptions("Clé primaire de l'utilisateur invalide : {$user_key}. Clé attendue strictement positive.");
        }

        $this->user_key = $user_key;
    }
    /**
     * Protected method setting the primary key of the candidate 
     * 
     * @param int $candidate_key The new primary key
     * @throws MeetingExceptions If $id is invalid
     * @return void
     */
    protected function setCandidate(int $candidate_key) {
        if($candidate_key <= 0) {
            throw new MeetingExceptions("Clé primaire du candidat invalide : {$candidate_key}. Clé attendue strictement positive.");
        }

        $this->candidate_key = $candidate_key;
    }
}