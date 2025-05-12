<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Role;

/**
 * Class representing a repository of Roles 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class RoleRepository extends Repository {
    /**
     * Public method searching a role by its primary key
     * 
     * @param int $id The primary key opf the role
     * @return ?Role the role
     */
    public function get(int $id): ?Role {
        $request = "SELECT * FROM ROLES WHERE Id = :id";

        $params = array("id" => $id);

        $response = $this->get_request($request, $params, true, true);

        return Role::fromArray($response);
    }

    /**
     * Public method searching the list of roles
     *
     * @return array
     */
    public function getList(): array {
        $request = "SELECT * FROM ROLES";

        $fetch = $this->get_request($request);

        return array_map(function($obj) {
            return Role::fromArray($obj);
        }, $fetch);
    }
}