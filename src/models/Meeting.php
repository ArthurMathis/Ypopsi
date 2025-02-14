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
     * @param ?int $id The primary key of the meeting
     * @param string $date The date of the meeting
     * @param ?string $description The description of the meeting
     * @param int $user_key The primary key of the user
     * @param int $candidate_key The primary key of the candidate
     * @throws MeetingExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $date, 
        protected ?string $description, 
        protected int $user_key, 
        protected int $candidate_key,
        protected int $establishment_key
    ) {
        // The primary key
        if(!empty($id) & $id <= 0) {
            throw new MeetingExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // The user's primary key
        if($user_key <= 0) {
            throw new MeetingExceptions("Clé primaire de l'utilisateur invalide : {$user_key}. Clé attendue strictement positive.");
        }
        
        // The candidate's primary key
        if($candidate_key <= 0) {
            throw new MeetingExceptions("Clé primaire du candidat invalide : {$candidate_key}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public method returning the primary key of the meeting
     * 
     * @return int
     */
    public function getId(): ?int { return $this->id; }
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
    /**
     * Public method returning the primary key of the establishment
     * 
     * @return int
     */
    public function getEstablishment(): int { return $this->establishment_key; }


    // * CONVERT * //
    /**
     * Public static method creating and retuning a new meeting from the data array
     * 
     * @param array $data The data array
     * @throws MeetingExceptions If any piece of information is invalid
     * @return Meeting The meeting
     */
    static public function fromArray(array $data): ?Meeting {
        if(empty($data)) {
            throw new MeetingExceptions("Erreur lors de la génération du rendez-vous. Tableau de données absent.");
        }

        return new Meeting(
            $data['Id'],
            $data['Date'], 
            $data['Description'], 
            $data['Key_Users'], 
            $data['Key_Candidates'], 
            $data['Key_Establishemnts']
        );
    }

    /**
     * Public method returning the user's data in a array
     * 
     * @return array The array that contains the data of the meeting
     */
    public function toArray(): array {
        return [
            'id'            => $this->getId(),
            'date'          => $this->getDate(),
            'description'   => $this->getDescription(),
            'user'          => $this->getUser(),
            'candidate'     => $this->getCandidate(),
            'establishment' => $this->getDescription()
        ];
    }
}