<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Service;

/**
 * Class representing a repository of services 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class ServiceRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one service from its primary key
     * 
     * @param int $key_service The primary key of the service
     * @return Service The service
     */
    public function get(int $key_service): Service {
        $request = "SELECT * FROM Services WHERE Id = :id";

        $params = array("id" => $key_service);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Service::fromArray($fetch);

        return $response;
    }

    /**
     * Public method returning the list of jobs
     * 
     * @return array The list
     */
    public function getList(): array {
        $request = "SELECT * FROM Services";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Service::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method returning the list of establishments for AutoComplet items
     * 
     * @return array The list of estbablishment
     */
    public function getAutoCompletion(): array {
        $fetch = $this->getList();

        $response = array_map(function($c) {
            return array(
                "id"   => $c->getId(),
                "text" => $c->getTitled()
            );
        }, $fetch);

        return $response;
    }
}