<?php 

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Candidate;

/**
 * Class representing a repository of candidates 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidateRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one candidate from his primary key
     *
     * @param int $key_candidate The candidate's primary key
     * @return Candidate
     */
    public function get(int $key_candidate): Candidate {
        $request = "SELECT * FROM Candidates WHERE Id = :id";
        $params = [ 'id' => $key_candidate ];

        $fetch = $this->get_request($request, $params, true, true);

        return Candidate::fromArray($fetch);
    }

    /**
     * Public method returning the list of candidates 
     *
     * @return array The list
     */
    public function getList(): array {
        $request = "SELECT * FROM Candidates";

        $response = $this->get_request($request);

        $response = array_map(function($c) {
            return Candidate::fromArray($c);
        }, $response);

        return $response;
    }
}