<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Action;
use App\Models\TypeOfActions;
use App\Models\User;

/**
 * Class representing a repository of Actions 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
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

    // * GET * //
    /**
     * Public method returning the list of connections
     *
     * @return array Tist of connections
     */
    public function getConnectionList(): array {
        $request = "SELECT 
            act.Id AS Cle,
            type.Titled AS Intitulé,
            r.Titled AS Role,
            CONCAT(UPPER(u.name), ' ', u.firstname) AS Utilisateur,
            Date(act.TimeManager) AS Date,
            Time(act.TimeManager) AS Heure


            FROM Actions AS act
            INNER JOIN Users AS u ON u.Id = act.Key_Users
            INNER JOIN Roles AS r on r.Id = u.Key_Roles
            INNER JOIN Types_of_actions AS type ON act.Key_Types_of_actions = type.Id

            WHERE Key_Types_of_actions  IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion', 'Déconnexion')
            )";

        return $this->get_request($request);
    }

    /**
     * Public method returning the list of actions
     *
     * @return ?array
     */
    public function getActionList(): ?array {
        $request = "SELECT 
            act.Id AS Cle,
            type.Titled AS Intitulé,
            r.Titled AS Role,
            CONCAT(UPPER(u.name), ' ', u.firstname) AS Utilisateur,
            Date(act.TimeManager) AS Date,
            Time(act.TimeManager) AS Heure


            FROM Actions AS act
            INNER JOIN Users AS u ON u.Id = act.Key_Users
            INNER JOIN Roles AS r on r.Id = u.Key_Roles
            INNER JOIN Types_of_actions AS type ON act.Key_Types_of_actions = type.Id

            WHERE Key_Types_of_actions NOT IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion', 'Déconnexion')
            )";

        return $this->get_request($request);
    }

    /**
     * Public function returning the user's list of connections
     *
     * @param int $key_user The user's primary key
     * @return ?array
     */
    public function getUserConnectionList(int $key_user): ?array {
        $request = "SELECT 
            act.Id AS Cle,
            type.Titled AS Intitulé,
            Date(act.TimeManager) AS Date,
            Time(act.TimeManager) AS Heure
            
            FROM Actions AS act
            INNER JOIN Types_of_actions AS type ON act.Key_Types_of_actions = type.Id

            WHERE act.Key_Users = :user AND Key_Types_of_actions  IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion', 'Déconnexion')
            )";

        $params = [
            "user" => $key_user
        ];

        return $this->get_request($request, $params);
    }

    /**
     * Public function returning the user's list of actions
     *
     * @param int $key_user The user's primary key
     * @return ?array
     */
    public function getUserActionList(int $key_user): ?array {
        $request = "SELECT 
            act.Id AS Cle,
            type.Titled AS Intitulé,
            Date(act.TimeManager) AS Date,
            Time(act.TimeManager) AS Heure
            
            FROM Actions AS act
            INNER JOIN Types_of_actions AS type ON act.Key_Types_of_actions = type.Id

            WHERE act.Key_Users = :user AND NOT Key_Types_of_actions  IN (
                SELECT id
                FROM Types_of_actions
                WHERE Titled IN ('Connexion', 'Déconnexion')
            )";

        $params = [
            "user" => $key_user
        ];

        return $this->get_request($request, $params);
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
        ORDER BY TimeManager 
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $fetch = $this->get_request($request, $params, true);

        return $fetch ? Action::fromArray($fetch) : null;
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
        ORDER BY TimeManager DESC
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $fetch = $this->get_request($request, $params, true);

        return $fetch ? Action::fromArray($fetch) : null;
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
        WHERE Key_Users = :user AND Key_Types_of_actions IN (
            SELECT Id
            FROM Types_of_actions
            WHERE Titled IN ('Mise à jour mot de passe')
        ) 
        ORDER BY TimeManager 
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $response = $this->get_request($request, $params, true);
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
        ORDER BY TimeManager DESC
        LIMIT 1";

        $params = [
            "user" => $user->getId()
        ];

        $response = $this->get_request($request, $params, true);
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
}