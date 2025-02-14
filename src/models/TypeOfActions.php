<?php

namespace App\Models;

use App\Exceptions\TypeOfActionsExceptions;

class TypeOfActions {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the type of actions
     * @param string $titled The title of the type of actions
     * @throws TypeOfActionsExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled
    ) {
        if(!empty($id) && $id <= 0) {
            throw new TypeOfActionsExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public method returning the primary key of the type of actions
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the title of the type of actions
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }

    // * CONVERT * //
    /**
     * Public static method creating and retuning a new TypeOfActions from the data array
     * 
     * @param array $data The data array
     * @throws UserExceptions If any piece of information is invalid
     * @return ?TypeOfActions The type of action
     */
    public static function fromArray(array $data): ?TypeOfActions {
        if(empty($data)) {
            throw new TypeOfActionsExceptions("Erreur lors de la génération du type d'actions. Tableau de données absent.");
        }

        return new TypeOfActions(
            $data['Id'],
            $data['Titled']
        );
    }

    /**
     * Public method returning the data of the type of action in a array
     * 
     * @return array
     */
    public function toArray(): array {
        return array(
            "id"     => $this->getId(),
            "titled" => $this->getTitled()
        );
    }
}