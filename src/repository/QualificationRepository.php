<?php

namespace App\Repository;

use App\Models\Qualification;
use App\Repository\Repository;

/**
 * Class representing a repository of qualifications 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class QualificationRepository extends Repository {
    // * GET * //
    /**
     * Public method returnin one qualification from its primary key
     * 
     * @param int $key_qualification The qualification primary key
     * @return Qualification
     */
    public function get(int $key_qualification): Qualification {
        $request = "SELECT * FROM Qualifications WHERE Id = :id";

        $params = array("id" => $key_qualification);

        $fetch = $this->get_request($request, $params, true, true);

        return Qualification::fromArray($fetch);
    }

    /**
     * Public method returning the list of qualifications
     * 
     * @return array
     */
    public function getList(): array {
        $request = "SELECT * FROM Qualifications";

        $fetch = $this->get_request($request);

        $reponse = array_map(function($c) {
            return Qualification::fromArray($c);
        }, $fetch);

        return $reponse;
    }


    // * GET FROM * //
    /**
     * Public method searching and returning the qualifications that the candidate get 
     * 
     * @param int $key_cadidate The primary key of the candidate
     * @return array
     */
    public function getListFromCandidate(int $key_candidate): array {
        $request = "SELECT 
            q.Id, 
            q.Titled, 
            q.MedicalStaff,
            q.Abreviation

            FROM Qualifications AS q
        
            INNER JOIN Get_qualifications AS g ON q.Id = g.Key_Qualifications
            
            WHERE g.Key_Candidates = :id";

        $params = array("id" => $key_candidate);

        $fetch = $this->get_request($request, $params);

        $response = array_map(function($c) {
            return Qualification::fromArray($c);
        }, $fetch);

        return $response;
    }

    // * SEARCH * //
    public function searchDate(int $key_candidate, int $key_qualification): string {
        $request = "SELECT Date FROM Get_qualifications WHERE Key_candidates = :key_candidate AND Key_Qualifications = :key_qualification";

        $params = [
            "key_candidate" => $key_candidate,
            "key_qualification" => $key_qualification
        ];

        return $this->get_request($request, $params, true, true)["Date"];
    }
}