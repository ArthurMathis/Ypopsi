<?php

namespace App\Repository;

use App\Models\HaveTheRightTo;
use App\Repository\Repository;

/**
 * Class representing a repository of HaveTheRightTo
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class HaveTheRightToRepository extends Repository {
    // * GET * //
    /**
     * Get a HaveTheRightTo by its primary key
     *
     * @param int $key_candidate The candidate's primary key
     * @param int $key_help The help's primary key
     * @return HaveTheRightTo
     */
    public function get(int $key_candidate, int $key_help): HaveTheRightTo {
        $request = "SELECT * FROM have_the_right_to WHERE Key_Candidates = :candidate AND Key_Helps = :help";

        $params = array(
            "candidate" => $key_candidate,
            "help"      => $key_help
        );

        $fetch = $this->get_request($request, $params, true, true);

        $response = HaveTheRightTo::fromArray($fetch);

        return $response;
    }

    /**
     * Get a list of HaveTheRightTo
     *
     * @return ?array The list of HaveTheRightTo
     */
    public function getList(): ?array {
        $request = "SELECT * FROM have_the_right_to";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return HaveTheRightTo::fromArray($c);
        }, $fetch);

        return $response;
    }

    public function getListFromcandidate(int $key_candidate): ?array {
        $request = "SELECT * FROM have_the_right_to WHERE Key_Candidates = :candidate";

        $params = array("candidate" => $key_candidate);

        $fetch = $this->get_request($request, $params);

        $response = array_map(function($c) {
            return HaveTheRightTo::fromArray($c);
        }, $fetch);

        return $response;
    }

    // * INSCRIPT * //
    /**
     * Insert a HaveTheRightTo
     *
     * @param HaveTheRightTo $have The HaveTheRightTo to insert
     * @return void
     */
    public function inscript(HaveTheRightTo &$have) {
        $request = "INSERT INTO have_the_right_to (Key_Candidates, key_Helps";
        $values_request = " VALUES (:candidate, :help";

        if(!empty($have->getEmployee())) {
            $request .= ", key_Employee";
            $values_request .= ", :employee";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);

        $this->post_request($request, $have->toSQL());
    }

    // * DELETE * //
    /**
     * Public method deleting a HaveTheRightTo
     *
     * @param HaveTheRightTo $have The haveTheRightTo to delete
     * @return void
     */
    public function delete(HaveTheRightTo &$have): void {
        $request = "DELETE FROM Have_the_right_to WHERE Key_Candidates = :candidate AND Key_Helps = :help";

        $params = array(
            "candidate" => $have->getCandidate(),
            "help" => $have->getHelp()
        );

        $this->post_request($request, $params);
    }
}