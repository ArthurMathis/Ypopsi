<?php 

namespace DB;

/**
 * Class containing the primary key of the objects of a row registering
 */
class registering {
    /**
     * Public attribute containing the candidate's primary key
     *
     * @var int
     */
    public int $candidate;
    /**
     * Public attribute containing the primary key of the application
     *
     * @var int
     */
    public int $application;
    /**
     * Public attribute containing the primary key of the contract
     *
     * @var int
     */
    public int $contract;

    /**
     * Public method returning the registering in an array
     *
     * @return array
     */
    public function toArray(): array {
        return array(
            "Candidat"    => $this->candidate,
            "Candidature" => $this->application,
            "Contrat"     => $this->contract,
        );
    }

    /**
     * Public static function returning the xlsx header for registering
     *
     * @return array
     */
    public static function toXlsx(): array {
        return array(
            "Candidat", "Candidature", "Contrat"
        );
    }
}