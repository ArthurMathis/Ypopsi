<?php

namespace App\Models;

use App\Exceptions\ActionExceptions;

/**
 * Class representing an action
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Action {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the action
     * @param ?string $description The description of action 
     * @param ?string $date The date of action 
     * @param ?int $user_key The primary key of the user 
     * @param ?int $type_key The primary key of the type of the action 
     * @throws ActionExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected ?string $description, 
        protected ?string $date, 
        protected int $user_key,
        protected int $type_key 
    ) {
        // The primary key
        if(!empty($id) && $id <= 0) {
            throw new ActionExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // The user's primary key
        if($user_key <= 0) {
            throw new ActionExceptions("Clé primaire de l'utilisateur invalide : {$user_key}. Clé attendue strictement positive.");
        }
        
        // The candidate's primary key
        if($type_key <= 0) {
            throw new ActionExceptions("Clé primaire du type d'action invalide : {$type_key}. Clé attendue strictement positive.");
        }
    }

    /**
     * Public static method building a new action
     * 
     * @param int $user The primary key of the user
     * @param int $type The primary key of the type of the action
     * @param string $description The description of the action
     * @return Action The new action
     */
    public static function createAction(int $user, int $type, ?string $description = null): Action {
        return new Action(
            null, 
            $description,
            null, 
            $user,
            $type
        );
    }

    // * GET * //
    /**
     * Public method returning the primary key of the action
     * 
     * @return int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the descrption of the action
     * 
     * @return string
     */
    public function getDescription(): ?string { return $this->description; }
    /**
     * Public method returning the date of the action
     * 
     * @return string
     */
    public function getDate(): ?string { return $this->date; }
    /**
     * Public method returning the primary key of the user
     * 
     * @return int
     */
    public function getUser(): int { return $this->user_key; }
    /**
     * Public method returning the primary key of the type of the action
     * 
     * @return int
     */
    public function getType(): int { return $this->type_key; }


    // * CONVERT * //
    /**
     * Public static method returning an Action building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws ActionExceptions If any piece of information is invalid
     * @return Action The action
     */
    public static function fromArray(array $data): ?Action {
        if(empty($data)) {
            throw new ActionExceptions("Erreur lors de la génération de l'action. Tableau de données absent.");
        }

        return new Action(
            $data['Id'],
            $data['Description'], 
            $data['Moment'], 
            $data['Key_Users'], 
            $data['Key_Types_of_actions']
        );
    }

    /**
     * Public function returning the action into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return [
            'id'          => $this->getId(),
            'description' => $this->getDescription(),
            'date'        => $this->getDate(),
            'user'        => $this->getUser(),
            'type'        => $this->getType()
        ];
    }
}