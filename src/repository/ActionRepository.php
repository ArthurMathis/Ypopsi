<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Action;
use App\Models\TypeOfActions;
use App\Models\User;

/**
 * Class representing a repository of actions 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class ActionRepository extends Repository {
    // * LOGS * //
    /**
     * Public method recording application logs
     * 
     * @param Action The action to write in the logs
     * @return void
     */
    public function writeLogs(Action $act) {
        $request = "INSERT INTO Actions (Key_Users, Key_Types_of_actions, Description) VALUES (:user, :type, :description)";

        $params = [
            "user"        => $act->getUser(),
            "type"        => $act->getType(),
            'description' => $act->getDescription()
        ];

        return $this->post_request($request, $params);
    }

    // * SEARCH * //
    /**
     * Public method searching one type of action in the database
     * 
     * @param int|string $action The primary key og the type of action 
     * @return TypeOfActions
     */
    Public function searchType(int|string $act): TypeOfActions {
        if(is_int($act)) {
            $request = "SELECT * FROM Types_of_actions WHERE Id = :action"; 
        } else {
            $request = "SELECT * FROM Types_of_actions WHERE Titled = :action";
        }
        
        $params = array("action" => $act);

        $fetch = $this->get_request($request, $params, true, true);

        $response = TypeOfActions::fromArray($fetch);

        return $response;
    }

    /**
     * Public method searching the first connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserFirstConnection(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions = :type
        ORDER BY Moment 
        LIMIT 1";

        $params = [
            "user" => $user->getId(),
            "type" => $this->searchType("Connexion")->getId()
        ];

        return Action::fromArray($this->get_request($request, $params, true));
    }

    /**
     * Public method searching the last connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserLastConnection(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions = :type
        ORDER BY Moment DESC
        LIMIT 1";

        $params = [
            "user" => $user->getId(),
            "type" => $this->searchType("Connexion")->getId()
        ];

        return Action::fromArray($this->get_request($request, $params, true));
    }
}