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

    //// GET USER ////
    /**
     * Public method searching the first connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserFirstUserConnection(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions  IN (
            SELECT id
            FROM Types_of_actions
            WHERE Titled IN ('Connexion')
        ) 
        ORDER BY Moment 
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        return Action::fromArray($this->get_request($request, $params, true));
    }

    /**
     * Public method searching the last connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserLastUserConnection(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions  IN (
            SELECT id
            FROM Types_of_actions
            WHERE Titled IN ('Connexion')
        ) 
        ORDER BY Moment DESC
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        return Action::fromArray($this->get_request($request, $params, true));
    }

    /**
     * Public method searching the first connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserFirstUserPasswordChange(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions  IN (
            SELECT id
            FROM Types_of_actions
            WHERE Titled IN ('Mise à jour mot de passe')
        ) 
        ORDER BY Moment 
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $response = $this->get_request($request, $params);
        return $response ? Action::fromArray($response) : null;
    }

    /**
     * Public method searching the last connection of a user
     *
     * @param User $user The user to search
     * @return ?Action
     */
    public function getUserLastUserPasswordChange(User &$user): ?Action {
        $request = "SELECT * 
        
        FROM Actions 
        WHERE Key_Users = :user AND Key_Types_of_actions  IN (
            SELECT id
            FROM Types_of_actions
            WHERE Titled IN ('Mise à jour mot de passe')
        ) 
        ORDER BY Moment DESC
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $response = $this->get_request($request, $params);
        return $response ? Action::fromArray($response) : null;
    }
    //// GET USER NUMBER //// 
    /**
     * Public method searching the number of connexions of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserConnexions(User &$user): int {
        $request = "SELECT COUNT(*) AS Number_of_connections 
            FROM Actions 
            WHERE Key_Users = :user AND Key_Types_of_actions  IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion')
            )";

        $params = [
            "user" => $user->getId()
        ];

        return (int) $this->get_request($request, $params, true)["Number_of_connections"];
    }
    /**
     * Public method searching the number of actions of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserActions(User $user): int {
        $request = "SELECT COUNT(*) AS Number_of_actions
            FROM Actions
            WHERE Key_Users = :user AND Key_Types_of_actions NOT IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion', 'Déconnexion')
            )";

        $params = [
            "user" => $user->getId()
        ];

        $result = $this->get_request($request, $params, true);

        return (int) $result["Number_of_actions"];
    }
    /**
     * Public method searching the number of applications of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserApplications(User $user): int {
        $request = "SELECT COUNT(*) AS Number_of_applications
            FROM Actions
            WHERE Key_Users = :user AND Key_Types_of_actions IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Nouvelle candidature')
            )";

        $params = [
            "user" => $user->getId()
        ];

        $result = $this->get_request($request, $params, true);

        return (int) $result["Number_of_applications"];
    }
    /**
     * Public method searching the number of offers of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserOffers(User $user): int {
        $request = "SELECT COUNT(*) AS Number_of_offers
            FROM Actions
            WHERE Key_Users = :user AND Key_Types_of_actions IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Nouvelle offre')
            )";

        $params = [
            "user" => $user->getId()
        ];

        $result = $this->get_request($request, $params, true);

        return (int) $result["Number_of_offers"];
    }
    /**
     * Public method searching the number of contracts of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserContracts(User $user): int {
        $request = "SELECT COUNT(*) AS Number_of_contracts
            FROM Actions
            WHERE Key_Users = :user AND Key_Types_of_actions IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Nouveau contrat')
            )";

        $params = [
            "user" => $user->getId()
        ];

        $result = $this->get_request($request, $params, true);

        return (int) $result["Number_of_contracts"];
    }
    /**
     * Public method searching the number of meetings of a user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfUserMeetings(User $user): int {
        $request = "SELECT COUNT(*) AS Number_of_meetings
            FROM Actions
            WHERE Key_Users = :user AND Key_Types_of_actions IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Nouveau rendez-vous')
            )";

        $params = [
            "user" => $user->getId()
        ];

        $result = $this->get_request($request, $params, true);

        return (int) $result["Number_of_meetings"];
    }
}