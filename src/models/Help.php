<?php

namespace App\Models;

use App\Exceptions\HelpExceptions;
use App\Core\Tools\DataFormat\DataFormatManager;

/**
 * Class representing a recruitement help for candidates
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Help {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key help of the help
     * @param string $titled The title help of the help
     * @param ?string $titled The description help of the help
     * @throws HelpExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id,
        protected string $titled, 
        protected ?string $description
    ) {
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new HelpExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public method returning the primary key of the help
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the title of the help
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public method returning the description of the help
     * 
     * @return ?string
     */
    public function getDescription(): ?string { return $this->description; }

    // * CONVERT * //
    /**
     * Public static method returning an Help building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws HelpExceptions If any piece of information is invalid
     * @return Help The help
     */
    public static function fromArray(array $data): ?Help {
        if(empty($data)) {
            throw new HelpExceptions("Erreur lors de la génération de l'aide. Tableau de données absent.");
        }

        return new Help(
            $data['Id'],
            $data['Titled'], 
            $data['Description']
        );
    }

    /**
     * Public function returning the help into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            'id'          => $this->getId(),
            'titled'      => $this->getTitled(),
            'description' => $this->getDescription()
        );
    }
}