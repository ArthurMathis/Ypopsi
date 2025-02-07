<?php

namespace App\Repository;

use App\Repository\Repository;

class ContractRepository extends Repository {
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
}