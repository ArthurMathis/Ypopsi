<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Role;

class RoleRepository extends Repository {
    /**
     * Public method searching a role by its primary key
     * 
     * @param int $id The primary key opf the role
     * @return ?Role the role
     */
    public function searchById(int $id): ?Role {
        $request = "SELECT * FROM ROLES WHERE Id = :id";
        $params = [ "id" => $id ];

        $response = $this->get_request($request, $params, true, true);

        return Role::fromArray($response);
    }
}