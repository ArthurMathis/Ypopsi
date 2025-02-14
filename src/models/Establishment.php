<?php

namespace App\Models;

use App\Exceptions\EstablishmentExceptions;

/**
 * Class represeting an establishment
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Establishment {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the establishment
     * @param string $titled The title of the establishment
     * @param string $address The address of the establishment
     * @param string $city The city of the establishment
     * @param string $postcode The postcode of the establishment
     * @param string $description The description of the establishment
     * @param string $pole The primary key of the hub of the establishment
     * @throws EstablishmentExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled,
        protected string $address, 
        protected string $city, 
        protected string $postcode, 
        protected ?string $description, 
        protected ?int $pole
    ) {
        // Primary key
        if(!empty($id) && $id <= 0) {
            throw new EstablishmentExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // Key pole
        if(!empty($pole) && $pole <= 0) {
            throw new EstablishmentExceptions("Clé de pôle invalide : {$pole}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public ethod returning the primary key of the establishment
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public ethod returning the title of the establishment
     * 
     * @return string 
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public ethod returning the address of the establishment
     * 
     * @return string
     */
    public function getAddress(): string { return $this->address; }
    /**
     * Public ethod returning the city of the establishment
     * 
     * @return string
     */
    public function getCity(): string { return $this->city; }
    /**
     * Public ethod returning the postcode of the establishment
     * 
     * @return string
     */
    public function getPostcode(): string { return $this->postcode; }
    /**
     * Public ethod returning the description of the establishment
     * 
     * @return string
     */
    public function getDescription(): string { return $this->description; }
    /**
     * Public ethod returning the primary key of the hub of the establishment
     * 
     * @return ?int
     */
    public function getPole(): ?int { return $this->pole; }

    // * CONVERT * //
    /**
     * Public static method returning an Establishment building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws EstablishmentExceptions If any piece of information is invalid
     * @return Establishment The establishment
     */
    public static function fromArray(array $data): Establishment {
        if(empty($data)) {
            throw new EstablishmentExceptions("Erreur lors de la génération de l'action. Tableau de données absent.");
        }

        return new Establishment(
            $data['Id'],
            $data['Titled'],
            $data['Address'],
            $data['City'],
            $data['PostCode'],
            $data['Description'],
            $data['Key_Poles']
        );
    }

    /**
     * Public function returning the establishment into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return [
            'id'          => $this->getId(),
            'address'     => $this->getAddress(),
            'address'     => $this->getCity(),
            'address'     => $this->getPostcode(),
            'description' => $this->getDescription(),
            'pole'        => $this->getPole()
        ];
    }
}