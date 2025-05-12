<?php 

namespace App\Repository;

use App\Models\TypeOfContracts;
use App\Repository\Repository;

/**
 * Class representing a repository of TypesOfContracts
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TypeOfContractsRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one type of contracts from its primary key
     * 
     * @param int $key_type_of_contracts The primary key of the type of contracts
     * @return TypeOfContracts The type of contracts
     */
    public function get(int $key_type_of_contracts): TypeOfContracts {
        $request = "SELECT * FROM Types_of_contracts WHERE Id = :id";

        $params = array("id" => $key_type_of_contracts);

        $fetch = $this->get_request($request, $params, true, true);

        $response = TypeOfContracts::fromArray($fetch);

        return $response;
    }

    /**
     * Public method returning the list of type of contracts
     * 
     * @return array The list
     */
    public function getList(): array {
        $request = "SELECT * FROM Types_of_contracts";

        $fetch = $this->get_request($request);

        $response = array_map(function($c) {
            return TypeOfContracts::fromArray($c);
        }, $fetch);

        return $response;
    }

    /**
     * Public method returning the list of type of contracts for AutoComplet items
     * 
     * @return array The list of type of contracts
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
     * Public method searching and returning one type of contracts from its name
     *
     * @param string $type_of_contracts The name of the type of contracts
     * @return TypeOfContracts
     */
    public function search(string &$type_of_contracts): TypeOfContracts {
        $request = "SELECT * FROM Types_of_contracts WHERE Titled LIKE :search";

        $params = array("search" => $type_of_contracts);

        $fetch = $this->get_request($request, $params, true, true);

        return TypeOfContracts::fromArray($fetch);
    }
}