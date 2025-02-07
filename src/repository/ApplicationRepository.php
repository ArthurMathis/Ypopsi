<?php

namespace App\Repository;

use App\Repository\Repository;

/**
 * Class representing a repository of applications 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class ApplicationRepository extends Repository {
    /**
     * Public function returning the liste of applications
     *
     * @return ?array The liste of applications
     */
    public function getCandidatures(): ?array { 
        return $this->get_request(
            "SELECT 
            c.id AS Cle,
            CASE 
                WHEN app.IsAccepted = 1 THEN 'Acceptée'
                WHEN app.IsRefused = 1 THEN 'Refusée'
                ELSE 'Non-traitée' 
            END AS Statut,
            c.name AS Nom, 
            c.firstname AS Prenom, 
            j.titled AS Poste,
            c.email AS Email, 
            c.phone AS Telephone, 
            s.titled AS Source, 
            c.availability AS Disponibilite

            FROM Applications as app
            INNER JOIN Candidates as c on app.Key_Candidates = c.Id
            INNER JOin Jobs as j on app.Key_Jobs = j.Id
            INNER JOIN sources as s on app.Key_Sources = s.Id
            
            ORDER BY app.Id DESC"
        );
    }

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