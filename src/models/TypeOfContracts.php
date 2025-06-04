<?php

namespace App\Models;

use App\Exceptions\TypeOfContractsExceptions;
use App\Core\Tools\DataFormat\DataFormatManager;

/**
 * Class representing a type of contracts
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TypeOfContracts {
    // * CONSTRUCTOR * //
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the type of contracts
     * @param string $titled The title of the type of contracts
     * @param ?string $description The description of the type of contracts
     * @throws TypeOfContractsExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled, 
        protected ?string $description
    ) {
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new TypeOfContractsExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public function returning the primary key of the type of contracts
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public function returning the titled of the type of contracts
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public function returning the description of the type of contracts
     * 
     * @return ?string
     */
    public function getDescription(): ?string { return $this->description; }

    // * CONVERT * //
    /**
     * Public static method creating and retuning a new type of contract from the data array
     * 
     * @param array $data The data array
     * @throws TypeOfContractsExceptions If any piece of information is invalid
     * @return TypeOfContracts The type of contracts
     */
    static public function fromArray(array $data): ?TypeOfContracts {
        if(empty($data)) {
            throw new TypeOfContractsExceptions("Erreur lors de la génération du type de contrats. Tableau de données absent.");
        }

        return new TypeOfContracts(
            $data['Id'],
            $data['Titled'], 
            $data['Description']
        );
    }

    /**
     * Public method returning the type of contracts' data in a array
     * 
     * @return array The array that contains the data of the type of contracts
     */
    public function toArray(): array {
        return array(
            'id'          => $this->getId(),
            'title'       => $this->getTitled(),
            'description' => $this->getDescription()
        );
    }
}