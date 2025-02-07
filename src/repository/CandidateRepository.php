<?php 

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Candidate;

/**
 * Class representing a repository of candidates 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidateRepository extends Repository {
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