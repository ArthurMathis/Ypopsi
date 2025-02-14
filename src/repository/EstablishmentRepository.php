<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Establishment;

class EstablishmentRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one establishment from his primary key
     *
     * @param int $key_candidate The primary key of the establishment
     * @return Establishment The establishment
     */
    public function get(int $key_establishment): Establishment {
        $request = "SELECT * FROM Establishments WHERE Id = :id";

        $params = array("id" => $key_establishment);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Establishment::fromArray($fetch);

        return $response;
    }

    /**
     * Public method returning the list of establishments
     * 
     * @return array The list of establishments
     */
    public function getList(): array {
        $request = "SELECT * FROM Establishments";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Establishment::fromArray($c);
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
                "key" => $c->getId(), 
                "text" => $c->getTitled()
            );
        }, $fetch);

        return $response;
    }
}