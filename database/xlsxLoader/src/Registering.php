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
}