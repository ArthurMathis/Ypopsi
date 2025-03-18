<?php 

namespace App\Models;

use App\Exceptions\FeatureExceptions;

/**
 * Class represeting an feature
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Feature {
    /**
     * Constructor class
     *
     * @param ?int $id The feature's primary key
     * @param string $titled The feature's titled
     * @param string $description The feature's description
     * @param boolean $enable The feature's availability
     * @throws FeatureExceptions If the primary key is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $titled, 
        protected string $description, 
        protected bool $enable
    ) {
        if(!empty($id) && $id <= 0) {
            throw new FeatureExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }

    // * GET * //
    /**
     * Public method returning the feature's primary key
     *
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the feature's titled
     *
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public method returning the feature's description
     *
     * @return string
     */
    public function getDescription(): string { return $this->description; }
    /**
     * Public method returning the feature's availability
     *
     * @return bool
     */
    public function getEnable(): bool { return $this->enable; }

    // * CONVERT * //
    /**
     * Public static method returning an Feature building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws FeatureExceptions If any piece of information is invalid
     * @return Feature The feature
     */
    public static function fromArray(array $data): ?Feature {
        if(empty($data)) {
            throw new FeatureExceptions("Erreur lors de la génération de la fonctionnalité. Tableau de données absent.");
        }

        return new Feature(
            $data["Id"],
            $data["Titled"], 
            $data["Description"], 
            $data["Enable"]
        );
    }

    /**
     * Public function returning the action into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "id"          => $this->getId(),
            "titled"      => $this->getTitled(),
            "description" => $this->getDescription(),
            "enable"      => $this->getEnable()
        );
    }
}