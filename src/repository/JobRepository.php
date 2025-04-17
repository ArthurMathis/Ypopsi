<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Job;

/**
 * Class representing a repository of jobs 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class JobRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one job from its primary key
     * 
     * @param int $key_job The primary key of the job
     * @return Job The job
     */
    public function get(int $key_job): Job {
        $request = "SELECT * FROM Jobs WHERE Id = :id";

        $params = array("id" => $key_job);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Job::fromArray($fetch);

        return $response;
    }

    /**
     * Public method returning the list of jobs
     * 
     * @return array The list
     */
    public function getList(): array {
        $request = "SELECT * FROM Jobs";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Job::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method returning the list of establishments for AutoComplet items
     * 
     * @param bool $gender Boolean indicating if it return the titled or the feminin titled
     * @return array The list of estbablishment
     */
    public function getAutoCompletion(bool $gender = true): array {
        $fetch = $this->getList();

        if($gender) {
            $response = array_map(function($c) {
                return array(
                    "id"   => $c->getId(),
                    "text" => $c->getTitled()
                );
            }, $fetch);

        } else {
            $response = array_map(function($c) {
                return array(
                    "id"   => $c->getId(),
                    "text" => $c->getTitledFeminin()
                );
            }, $fetch);
        }

        return $response;
    }
}