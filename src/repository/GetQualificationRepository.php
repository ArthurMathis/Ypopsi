<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\GetQualification;
use App\Exceptions\GetQualificationExceptions;

/**
 * Class representing a repository of GetQualification
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class GetQualificationRepository extends Repository {
    // * GET * //
    /**
     * Get a GetQualification by its primary key
     *
     * @param int $key_candidate The candidate's primary key
     * @param int $key_qualification The qualification's primary key
     * @return GetQualification
     */
    public function get(int $key_candidate, int $key_qualification): GetQualification {
        $request = "SELECT * FROM Get_qualifications WHERE Candidate = :candidate AND Qualification = :qualification";

        $params = array(
            "candidate" => $key_candidate,
            "qualification" => $key_qualification
        );

        $fetch = $this->get_request($request, $params, true, true);

        $response = GetQualification::fromArray($fetch);

        return $response;
    }

    /**
     * Get a list of GetQualifications
     *
     * @return ?array The list of GetQualifications
     */
    public function getList(): ?array {
        $request = "SELECT * FROM Get_qualifications";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return GetQualification::fromArray($c);
        }, $fetch);

        return $response;
    }

    // * INSCRIPT * //
    /**
     * Insert a GetQualification
     *
     * @param GetQualification $get The GetQualification to insert
     * @return void
     */
    public function inscript(GetQualification &$get) {
        $request = "INSERT INTO Get_qualifications (Key_Candidates, Key_Qualifications, Date) VALUES (:candidate, :qualification, :date)";
        $this->post_request($request, $get->toSQL());
    }
}