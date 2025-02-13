<?php

namespace App\Repository;

use App\Repository\Repository;

/**
 * Class representing a repository of contracts 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
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

    /**
     * Public method searching and returning the liste of candidate's contracts
     *
     * @param int $key_candidate The candidate's primary key
     * @return ?array
     */ 
    public function getListFromCandidates(int $key_candidate): ?array {
        $request = "SELECT 
            c.Id AS cle,
            j.titled AS poste,
            s.titled AS service,
            e.titled AS etablissement,
            t.titled AS type_de_contrat,
            c.StartDate AS date_debut,
            c.EndDate AS date_fin,
            c.PropositionDate AS proposition,
            c.SignatureDate AS signature,
            c.ResignationDate AS demission,
            c.IsRefused AS statut, 
            c.Salary AS salaire,
            c.HourlyRate AS heures,
            c.NightWork AS nuit,
            c.WeekEndWork AS week_end

            FROM Contracts as c
            INNER JOIN Jobs AS j ON c.Key_Jobs = j.Id
            INNER JOIN Services AS s ON c.Key_services = s.Id
            INNER JOIN Establishments AS e ON c.Key_Establishments = e.Id
            INNER JOIN Types_of_contracts AS t ON c.Key_Types_of_contracts = t.Id

            WHERE c.Key_Candidates = :key
            
            ORDER BY c.Id DESC";

        $params = array("key" => $key_candidate);

        return $this->get_request($request, $params);
    }
}