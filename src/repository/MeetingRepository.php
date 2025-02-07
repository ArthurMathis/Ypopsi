<?php

namespace App\Repository;

use App\Repository\Repository;

class MeetingRepository extends Repository {
    /**
     * Public method searching the metting list
     *
     * @return ?array
     */
    public function getReductRendezVous(): ?array {
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
}