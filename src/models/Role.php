<?php

namespace App\Models;

use App\Exceptions\RoleExceptions;

/**
 * Class representing a meeting
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Role {
    /**
     * Constructor class
     * 
     * @param int $id The primary key of the role
     * @param string $titled The title of the role
     */
    public function __construct(
        protected int $id, 
        protected string $titled
    ) {}

    // * GET * //
    /**
     * Public method returning the primary key of the role
     * 
     * @return int
     */
    public function getId(): int { return $this->id; }
    /**
     * Public method returning the title of the role
     * 
     * @return string
     */
    public function getTitled(): string { return $this->titled; }

    // * CONVERT * //
    /**
     * Public static method building a Role from an array
     * 
     * @throws RoleExceptions If any piece of information is invalid
     * @return ?Role The role
     */
    public static function fromArray(array $data): ?Role {
        if(empty($data)) {
            throw new RoleExceptions("Erreur lors de la génération du rôle. Tableau de données absent.");
        }

        return new Role(
            $data['Id'], 
            $data['Titled']
        );
    }
}