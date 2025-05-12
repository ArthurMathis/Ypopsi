<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Source;

/**
 * Class representing a repository of Sources
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class SourceRepository extends Repository {
    // * GET * //
    /**
     * Public function searching and returning one source
     * 
     * @param int $key_source The primary key of the source
     * @return Source The source
     */
    public function get(int $key_source): Source {
        $request = "SElECT * FROM Sources WHERE Id = :id";

        $params = array("id" => $key_source);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Source::fromArray($fetch);

        return $response;
    }

    /**
     * Public function returning the list of sources 
     * 
     * @return array The list
     */
    public function getList(): array {
        $request = "SElECT * FROM Sources";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return Source::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method returning the list of sources for AutoComplet items
     * 
     * @return array The list of sources
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
    // * SEARCH * //
    /**
     * Public function searching and returning one source from his name
     *
     * @param string $source The source's name
     * @return Source
     */
    public function search(string &$source): Source {
        $request = "SELECT * FROM Sources WHERE Titled = :titled";

        $params = array("titled" => $source);

        $fetch = $this->get_request($request, $params, true, true);

        return Source::fromArray($fetch);
    }
}