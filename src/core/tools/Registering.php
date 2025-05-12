<?php 

namespace App\Core\Tools;

/**
 * Class containing the primary key of the objects of a row registering
 */
class Registering {
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
    public ?int $contract;
    /**
     * Public attribute conatining the list of qualifications 
     *
     * @var ?int
     */
    public ?int $qualification;
    /**
     * Public attribute conatining the list of helps 
     *
     * @var array
     */
    public array $helps;

    // * CONVERT * //
    /**
     * Public method returning the registering in an array
     *
     * @return array
     */
    public function toArray(): array {
        return [
            "Candidat"      => $this->candidate,
            "Candidature"   => $this->application,
            "Contrat"       => $this->contract,
            "Qualification" => $this->qualification,
            "Helps"         => $this->helpsToArray()
        ];
    }
    /**
     * Public method returning the list of helps in a string
     *
     * @return string
     */
    public function helpsToArray(): string {
        $str = "";

        if(!empty($this->helps)) {
            $str .= (string) $this->helps[0];

            for($i = 1; $i < count($this->helps); $i++) {
                $str .= " ; " . $this->helps[$i];
            }
        }

        return trim($str);
    }

    /**
     * Public static function returning the xlsx header for registering
     *
     * @return array
     */
    public static function toXlsx(): array {
        return [
            "Candidat", "Candidature", "Contrat", "Qualifications", "Aides"
        ];
    }
}