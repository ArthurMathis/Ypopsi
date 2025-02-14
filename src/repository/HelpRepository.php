<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Help;

/**
 * Class representing a repository of helps 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HelpRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one help from his primary key
     *
     * @param int $key_candidate The primary key of the help
     * @return Help
     */
    public function get(int $key_help): Help {
        $request = "SELECT  * FROM Helps WHERE Id = :id";

        $params = array("id" => $key_help);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Help::fromArray($fetch);

        return $response;
    }
    /**
     * Public function returning the liste of helps
     *
     * @return array The liste of helps
     */
    public function getList(): array {
        $request = "SELECT * FROM Helps";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Help::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method searching and returning the list of help that the candidate thas the right to have
     * 
     * @param int $key_candidate The primary key of the candidate
     * @return ?array The list of helps
     */
    public function getListfromCandidates(int $key_candidate): ?array {
        $request = "SELECT 
            Id, 
            Titled, 
            Description
            
            FROM Helps
            INNER JOIN Have_the_right_to AS have ON Id = have.Key_Helps
            
            WHERE have.Key_Candidates = :key_candidate";

        $params = array("key_candidate" => $key_candidate);

        $fetch = $this->get_request($request, $params);

        $response = array_map(function($c) {
            return Help::fromArray($c);
        }, $fetch);

        return $response;
    }

    // * SEARCH * //
    public function searchCoopteurId(int $key_candidate) {
        $request = "SELECT Key_Employee AS Id From Have_the_right_to WHERE Key_Candidates = :id";

        $params = array("id" => $key_candidate);

        $response = $this->get_request($request, $params);

        return $response;
    }
}