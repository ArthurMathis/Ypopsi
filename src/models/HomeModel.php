<?php

namespace App\Models;

use App\Models\Model;

/**
 * Class representing the home page model
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HomeModel extends Model {
    /**
     * Public method searching the unprocessed application in the database
     *
     * @return Void
     */
    public function getNonTraiteeCandidatures(): ?Array {
        $request = "SELECT 
            c.Id AS Cle,
            j.Titled AS Poste, 
            c.Name AS Nom, 
            c.Firstname AS Prénom, 
            c.Email AS Email, 
            c.Phone AS Téléphone, 
            s.Titled AS Source

            FROM applications as app
            INNER JOIN Candidates as c on app.Key_Candidates = c.Id
            INNER JOin jobs as j on app.Key_Jobs = j.Id
            INNER JOIN sources as s on app.Key_Sources = s.Id
            WHERE app.IsAccepted = FALSE AND app.IsRefused = FALSE
            
            ORDER BY app.Id DESC";
    
        return $this->get_request($request);
    }
    /**
     * Public method searching the contract proposals in the database
     *
     * @return Void
     */
    public function getReductProposition(): ?Array {
        $request = "SELECT 
            j.Titled AS Poste,
            can.Name AS Nom, 
            can.Firstname AS Prenom

            FROM Contracts AS con
            INNER JOIN Candidates AS can ON con.Key_Candidates = can.Id
            INNER JOIN Jobs AS j ON con.Key_Jobs = j.Id
            WHERE con.SignatureDate = NULL
            
            ORDER BY con.Id DESC";

        return $this->get_request($request);
    }
    /**
     * Public method searching the metting list
     *
     * @return Array|Null
     */
    public function getReductRendezVous(): ?Array {
        $request = "SELECT 
            c.Name AS Nom, 
            c.Firstname AS Prenom,
            DATE_FORMAT(meet.Date, '%d/%m/%Y') AS Jour,
            DATE_FORMAT(meet.Date, '%H:%i') AS Heure
            
            FROM Meetings AS meet
            INNER JOIN Candidates AS c ON meet.Key_Candidates = c.Id
            WHERE meet.Key_Users = :cle AND NOW() <= meet.Date
            ORDER BY meet.Date";
            
        $params = ['cle' => $_SESSION['user_key']];

        return $this->get_request($request, $params);
    }
}