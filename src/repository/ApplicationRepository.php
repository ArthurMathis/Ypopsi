<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Application;

/**
 * Class representing a repository of applications 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ApplicationRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one application from his primary key
     *
     * @param int $key_application The primary key of the application
     * @return Application
     */
    public function get(int $key_application): Application {
        $request = "SELECT * FROM Applications WHERE Id = :id";

        $params = array("id" => $key_application);

        $fetch = $this->get_request($request, $params, true, true);

        $response = Application::fromArray($fetch);

        return $response;
    }
    /**
     * Public function returning the liste of applications
     *
     * @return ?array The liste of applications
     */
    public function getList(): ?array { 
        $request = "SELECT 
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
            
            ORDER BY app.Id DESC";

        return $this->get_request($request);
    }

    /**
     * Public method searching the unprocessed application in the database
     *
     * @return Void
     */
    public function getNonTraiteeList(): ?Array {
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
     * Public method searching and returning the liste of candidate's applications
     *
     * @param int $key_candidate The candidate's primary key
     * @return ?array 
     */
    public function getListFromCandidates(int $key_candidate, bool $gender = true): ?array {
        $request = "SELECT 
            app.Id AS cle,
            app.IsAccepted AS acceptee, 
            app.IsRefused AS refusee, 
            s.titled AS source, 
            t.titled AS type_de_contrat,
            app.Moment AS date,
            j.titled AS poste,
            j.titledFeminin AS posteFeminin,
            serv.titled AS service,
            e.titled AS etablissement
            
            FROM Applications AS app
            INNER JOIN Sources AS s ON app.key_sources = s.Id
            INNER JOIN Jobs AS j ON app.key_jobs = j.Id
            LEFT JOIN Types_of_contracts AS t ON app.Key_Types_of_contracts = t.Id
            LEFT JOIN Services as serv ON app.Key_Services = serv.Id
            LEFT JOIN Establishments AS e ON app.Key_Establishments = e.id

            WHERE app.Key_Candidates = :cle

            ORDER BY cle DESC";

        $params = array("cle" => $key_candidate);

        $fetch = $this->get_request($request, $params);


        $response = array_map(function($c) use ($gender) {
            if(!$gender) {
                $c["poste"] = $c["posteFeminin"];
            }

            unset($c["posteFeminin"]);
            
            return $c;
        }, $fetch);


        return $response;
    }

    // * INSCRIPT * //

    /**
     * Public method registering a new application in the database
     * 
     * @param Application $application The application to registering
     * @return int The primary key of the new application
     */
    public function inscript(Application &$application): int {
        $request = "INSERT INTO Applications(Key_Candidates, Key_Jobs, Key_Sources";

        $values_request = "VALUES (:candidate, :job, :source";

        if(!empty($application->getType())) {
            $request .= ", Key_Types_of_contracts";
            $values_request .= ", :type";
        }

        if(!empty($application->getService()) && !empty($application->getEstablishment())) {
            $request .= ", Key_Services, Key_Establishments";
            $values_request .= ", :service, :establishment";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);

        return $this->post_request($request, $application->toSQL());
    }

    // * MANIPULATION * //
    /**
     * Public function accepting an application
     * 
     * @param int $key_application The primary key of the application
     * @return int The primary key of the application
     */
    public function accept(int $key_application): int {
        $request = "UPDATE Applications SET IsAccepted = TRUE, IsRefused = FALSE WHERE Id = :key_application";

        $params = array("key_application" => $key_application);

        return $this->post_request($request, $params);
    }
    /**
     * Public function rejecting an application
     * 
     * @param int $key_application The primary key of the application
     * @return int The primary key of the application
     */
    public function reject(Application &$application): int {
        $request = "UPDATE Applications SET IsAccepted = FALSE, IsRefused = TRUE WHERE Id = :key_application";

        $params = array("key_application" => $application->getId());

        return $this->post_request($request, $params);
    }
}