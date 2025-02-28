<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Contract;

/**
 * Class representing a repository of contracts 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class ContractRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one contract from his primary key
     * 
     * @param int $key_contract The contract's primary key
     * @return Contract
     */
    public function get(int $key_contract): Contract {
        $request = "SELECT * FROM Contracts WHERE Id = :key";

        $params = array("key" => $key_contract);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Contract::fromArray($fetch);

        return $response;
    }
    /**
     * Public function returning the liste of contracts
     * 
     * @return array
     */
    public function getList(): array {
        $resquest = "SELECT * FROM Contracts";

        $fetch = $this->get_request($resquest);

        $response = array_map(function($c) {
            return Contract::fromArray($c);
        }, $fetch);

        return $response;
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

    // * INSCRIPT * //
    /**
     * Public method registering a new contract in the database
     * 
     * @param Contract $contract The contract to registering
     * @return int The primary key of the new contract
     */
    public function inscript(Contract &$contract) {
        $request = "INSERT INTO Contracts (StartDate, Key_Candidates, Key_Jobs, Key_Services, Key_Establishments, Key_Types_of_contracts";
        $values_request = " VALUES (:start_date, :candidate, :job, :service, :establishment, :type";

        if(!empty($contract->getSalary())) {
            $request .= ", Salary";
            $values_request .= ", :salary";
        }

        if(!empty($contract->getHourlyRate())) {
            $request .= ", HourlyRate";
            $values_request .= ", :hourly_rate";
        }

        if(!empty($contract->getNightWork())) {
            $request .= ", NightWork";
            $values_request .= ", :night_work";
        }

        if(!empty($contract->getWkWork())) {
            $request .= ", WeekEndWork";
            $values_request .= ", :week_end_work";
        }

        $request .= ")" . $values_request . ")";

        return $this->post_request($request, $contract->toSQL());
    }

    /**
     * Public method registering the signature date of a contract in the database 
     * 
     * @param Contract $contract The contract to sign
     * @return int The primary key of the contract
     */
    public function sign(Contract &$contract): int {
        $request = "UPDATE Contracts SET SignatureDate = :signature WHERE Id = :key";

        $params = array(
            "key"       => $contract->getId(),
            "signature" => $contract->getSignature()
        );

        return $this->post_request($request, $params);
    }

    // * UPDATE * //

    // * DELETE * //
    /**
     * public method refusing an offer
     * 
     * @param Contract $contract The contract to refuse
     * @return int The primary key of the contract
     */
    public function reject(Contract &$contract) {
        $request = "UPDATE Contracts SET IsRefused = 1 WHERE Id = :key";

        $params = array("key" => $contract->getId());

        return $this->post_request($request, $params);
    }
    /**
     * Public method registering the resignation of a contract in the database
     */
    public function dismiss(Contract &$contract) {
        $request = "UPDATE Contracts SET ResignationDate = :resignation WHERE Id = :key";

        $params = array(
            "key"         => $contract->getId(),
            "resignation" => $contract->getResignation()
        );

        return $this->post_request($request, $params);
    }
}