<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Meeting;

/**
 * Class representing a repository of meetings 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class MeetingRepository extends Repository {
    // * GET * //
    public function get(int $key_meeting): Meeting {
        $request = "SELECT * FROM Meetings WHERE Id = :id";

        $params = array("id" => $key_meeting);

        $fetch = $this->get_request($request, $params, true, true);

        return Meeting::fromArray($fetch);
    }
    /**
     * Public method searching the metting list
     *
     * @return ?array
     */
    public function getReductList(): ?array {
        $request = "SELECT 
            c.Name AS Nom, 
            c.Firstname AS Prenom,
            DATE_FORMAT(meet.Date, '%d/%m/%Y') AS Jour,
            DATE_FORMAT(meet.Date, '%H:%i') AS Heure
            
            FROM Meetings AS meet
            INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id
            WHERE meet.Key_Users = :cle AND NOW() <= meet.Date
            ORDER BY meet.Date";

        $params = [ 'cle' => $_SESSION['user']->getId() ];

        return $this->get_request($request, $params);
    }

    public function getListFromCandidate(int $key_candidate): ?array {
        $request = "SELECT 
            meet.Id AS key_meeting,
            u.Name AS nom,
            u.Firstname AS prenom,
            DATE(meet.Date) AS date,
            DATE_FORMAT(meet.Date, '%H:%i') AS heure,
            e.Titled AS etablissement,
            meet.Description AS description

            FROM  Meetings AS meet
            INNER JOIN Users AS u ON meet.Key_Users = u.Id
            INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id
            INNER JOIN Establishments AS e ON e.Id = meet.Key_Establishments

            WHERE meet.Key_Candidates = :key";

        $params = array("key" => $key_candidate);
    
        return $this->get_request($request, $params);
    }

    // * INSCRIPT * //
    /**
     * Public method registering a new meeting
     */
    public function inscript(Meeting $meeting): int {
        $request = "INSERT INTO Meetings (Date, Key_Users, Key_Candidates, Key_Establishments) VALUES (:moment, :key_user, :key_candidate, :key_establishment)";
        
        $params = array(
            "moment"            => $meeting->getDate(),
            "key_user"          => $meeting->getUser(),
            "key_candidate"     => $meeting->getCandidate(),
            "key_establishment" => $meeting->getEstablishment()
        );
    
        return $this->post_request($request, $params);
    }

    // * EDIT * //
    
    
    // * DELETE * //
    /**
     * Public function deleting a meeting
     */
    public function delete(Meeting $meeting) {
        $request = "DELETE FROM Meetings WHERE Id = :key_meeting";

        $params = array("key_meeting" => $meeting->getId());

        $this->post_request($request, $params);
    }
}