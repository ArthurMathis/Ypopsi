<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Feature;

class FeatureRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning a feature from its primary key
     *
     * @param int $key_feature
     * @return Feature
     */
    public function get(int $key_feature): Feature {
        $request = "SELECT * FROM Features WHERE Id = :id";

        $params = array("id" => $key_feature);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Feature::fromArray($fetch);

        return $response;
    }

    /**
     * Public method searching and returning the list of features
     *
     * @return array
     */
    public function getList(): array {
        $request = "SELECT * FROM Features";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Feature::fromArray($c);
        }, $fetch);

        return $response;
    }
}