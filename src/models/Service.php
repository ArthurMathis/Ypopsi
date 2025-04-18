<?php

namespace App\Models;

use App\Exceptions\ServiceExceptions;
use App\Core\Tools\DataFormatManager;

/**
 * Class representing a foundation's service
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Service {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the service
     * @param string $titled The title of the service
     * @param ?string $description The description of the service
     * @throws ServiceExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled, 
        protected ?string $description
    ) {
        // The primary key
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new ServiceExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }


    // * GET * //
    /**
     * Public method returing the primary key of the service
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returing the titled of the service
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public method returing the description of the service
     * 
     * @return ?string
     */
    public function getDescription(): ?string { return $this->description; }


    // * CONVERT * //
    /**
     * Public static method creating and retuning a new service from the data array
     * 
     * @param array $data The data array
     * @throws ServiceExceptions If any piece of information is invalid
     * @return Service The service
     */
    static public function fromArray(array $data): ?Service {
        if(empty($data)) {
            throw new ServiceExceptions("Erreur lors de la génération du service. Tableau de données absent.");
        }

        return new Service(
            $data['Id'],
            $data['Titled'], 
            $data['Description']
        );
    }

    /**
     * Public method returning the service's data in a array
     * 
     * @return array The array that contains the data of the service
     */
    public function toArray(): array {
        return array(
            'id'          => $this->getId(),
            'title'       => $this->getTitled(),
            'description' => $this->getDescription()
        );
    }
}