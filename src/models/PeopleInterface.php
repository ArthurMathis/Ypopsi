<?php

namespace App\Models;

/**
 * Interface representing a people
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
interface PeopleInterface {
    /**
     * Public function returning the name of the candidate
     * 
     * @return string
     */
    public function getName(): string;
    /**
     * Public function returning the firstname of the candidate
     * 
     * @return string
     */
    public function getFirstname(): string;
    /**
     * Public method erturning the complete candidate's name 
     *
     * @return string
     */
    public function getCompleteName(): string;
}