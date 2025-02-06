<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Action;

class ActionRepository extends Repository {
    // * LOGS * //
    /**
     * Public method recording application logs
     * 
     * @param Action The action to write in the logs
     * @return Void
     */
    public function writeLogs(Action $act) {
        $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions, Description) VALUES (:user, :type, :description)";
        $params = [
            "user"        => $act->getUser(),
            "type"        => $this->searchType($act->getType())['Id'],
            'description' => $act->getDescription()
        ];

        return $this->post_request($request, $params);
    }

    // * SEARCH * //
    /**
     * Public method searching one type of action in the database
     * 
     * @param int|string $action The primary key og the type of action 
     * @return array
     */
    Public function searchType(int|string $act): Array {
        if(is_int($act)) {
            $request = "SELECT * FROM Types_of_actions WHERE Id = :action"; 
        } else {
            $request = "SELECT * FROM Types_of_actions WHERE Titled = :action";
        }
        
        $params = [ "action" => $act ];

        return $this->get_request($request, $params, true, true);
    }
}