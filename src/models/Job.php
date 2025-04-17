<?php

namespace App\Models;

use App\Exceptions\JobExceptions;
use App\Core\Tools\DataFormatManip;

/**
 * Class representing a recruitement job
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Job {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the job
     * @param string $titled The title of the job
     * @param string $titled The title for women of the job
     * @throws JobExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id,
        protected string $titled, 
        protected string $titled_feminin
    ) {
        if(!is_null($id) && !DataFormatManip::isValidKey($id)) {
            throw new JobExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }
    }


    // * GET * //
    /**
     * Public method returning the primary key of the job 
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public method returning the title of the job 
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }
    /**
     * Public method returning the title for women of the job 
     * 
     * @return string
     */
    public function getTitledFeminin(): string { return $this->titled_feminin; }


    // * CONVERT * //
    /**
     * Public static method creating and retuning a new job from the data array
     * 
     * @param array $data The data array
     * @throws JobExceptions If any piece of information is invalid
     * @return Job The job
     */
    static public function fromArray(array $data): ?Job {
        if(empty($data)) {
            throw new JobExceptions("Erreur lors de la génération de poste. Tableau de données absent.");
        }

        return new Job(
            $data['Id'],
            $data['Titled'], 
            $data['TitledFeminin']
        );
    }

    /**
     * Public method returning the job's data in a array
     * 
     * @return array The array that contains the data of the job
     */
    public function toArray(): array {
        return array(
            'id'            => $this->getId(),
            'title'         => $this->getTitled(),
            'title_feminin' => $this->getTitledFeminin()
        );
    }
}