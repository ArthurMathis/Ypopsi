<?php

namespace App\Repository;

use App\Repository\Repository;

class ApplicationRepository extends Repository {
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
}