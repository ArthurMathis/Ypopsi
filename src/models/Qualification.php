<?php 

namespace App\Models;

use App\Core\Tools\DataFormatManager;
use App\Exceptions\QualificationExceptions;

/**
 * Class representing a qualification
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Qualification {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the qualification
     * @param string $id The title of the qualification
     * @param bool $id Boolean indicatinf if the qualification corresponds to a medical staff job
     * @param ?string $abreviation The abreviation of the title of the qualification
     * @throws QualificationExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id,
        protected string $title,
        protected bool $medical,
        protected ?string $abreviation
    ) {
        // The primary key
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new QualificationExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }


    // * GET * //
    /**
     * Public method returning the primary key of the qualification
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the title of the qualification
     * 
     * @return string
     */
    public function getTitle(): string { return $this->title; }
    /**
     * Public method returning if the qualification corresponds to a medical staff job
     * 
     * @return bool
     */
    public function getMedical(): bool { return $this->medical; }
    /**
     * Public method returning the abreviation of the title of the qualification
     * 
     * @return ?string
     */
    public function getAbreviation(): ?string { return $this->abreviation; }


    // * CONVERT * //
    /**
     * Public static method returning an Qualification building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws QualificationExceptions If any piece of information is invalid
     * @return Qualification The qualification
     */
    public static function fromArray(array $data): ?Qualification {
        if(empty($data)) {
            throw new QualificationExceptions("Erreur lors de la génération de la qualification. Tableau de données absent.");
        }
        
        return new Qualification(
            $data['Id'],
            $data['Titled'],
            $data['MedicalStaff'],
            $data['Abreviation']
        );
    }

    /**
     * Public function returning the qualification into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "id"          => $this->getId(),
            "titled"      => $this->getTitle(),
            "medical"     => $this->getMedical(),
            "abreviation" => $this->getAbreviation()
        );
    }
}