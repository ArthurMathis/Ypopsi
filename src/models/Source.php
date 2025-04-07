<?php

namespace App\Models;

use App\Exceptions\SourceExceptions;

class Source {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the source
     * @param string $id The title of the source
     * @param ?int $type The type of the source
     * @throws SourceExceptions If any piece of inforation is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled,
        protected ?int $type
    ) {
        if(!empty($id) && $id <= 0) {
            throw new SourceExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        if(!empty($type) && $type <= 0) {
            throw new SourceExceptions("Clé primaire du type de sources invalide : {$type}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public method returning the primary key of the source
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the title of the source
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public method returning the type of the source
     *
     * @return ?int
     */
    public function getType(): ?int { return $this->type; }

    // * CONVERT * //
    /**
     * Public static method creating and retuning a new source from the data array
     * 
     * @param array $data The data array
     * @throws SourceExceptions If any piece of information is invalid
     * @return Source The source
     */
    static public function fromArray(array $data): ?Source {
        if(empty($data)) {
            throw new SourceExceptions("Erreur lors de la génération de la source. Tableau de données absent.");
        }

        return new Source(
            $data['Id'],
            $data['Titled'],
            $data['Types_of_sources'] ?? null
        );
    }

    /**
     * Public method returning the source's data in a array
     * 
     * @return array The array that contains the data of the source
     */
    public function toArray(): array {
        return array(
            'id'    => $this->getId(),
            'title' => $this->getTitled(),
            'type'  => $this->getType()
        );
    }
}