<?php 

namespace App\Repository;

use App\Repository\Repository;
use App\Models\Candidate;

/**
 * Class representing a repository of candidates 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class CandidateRepository extends Repository {
    // * GET * //
    /**
     * Public method searching and returning one candidate from his primary key
     *
     * @param int $key_candidate The candidate's primary key
     * @return Candidate
     */
    public function get(int $key_candidate): Candidate {
        $request = "SELECT * FROM Candidates WHERE Id = :id";
        $params = [ 'id' => $key_candidate ];

        $fetch = $this->get_request($request, $params, true, true);

        return Candidate::fromArray($fetch);
    }

    /**
     * Public method returning the list of candidates 
     *
     * @return array The list
     */
    public function getList(): array {
        $request = "SELECT * FROM Candidates";

        $response = $this->get_request($request);

        $response = array_map(function($c) {
            return Candidate::fromArray($c);
        }, $response);

        return $response;
    }

    /**
     * Public method returning the list of the employees
     *
     * @return array
     */
    public function getEmployee(): array {
        $request = "SELECT 
            Candidates.Id, 
            Candidates.Name, 
            Candidates.Firstname, 
            Candidates.Gender,
            Candidates.Email, 
            Candidates.Phone,
            Candidates.Address,
            Candidates.City, 
            Candidates.PostCode,
            Candidates.Availability, 
            Candidates.MedicalVisit,
            Candidates.Rating, 
            Candidates.Description, 
            Candidates.Is_delete,
            Candidates.A, 
            Candidates.B, 
            Candidates.C

            FROM candidates 
            INNER JOIN Contracts on Candidates.Id = Contracts.Key_Candidates
            
            WHERE Contracts.SignatureDate IS NOT NULL";

        $response = $this->get_request($request);

        $response = array_map(function($c) {
            return Candidate::fromArray($c);
        }, $response);

        return $response;
    }

    /**
     * Public method returning the list of employees for AutoComplet items
     * 
     * @return array The list of sources
     */
    public function getAutoCompletion(): array {
        $fetch = $this->getEmployee();

        $response = array_map(function($c) {
            return array(
                "id"   => $c->getId(),
                "text" => $c->getCompleteName()
            );
        }, $fetch);

        return $response;
    }

    // * INSCRIPT * //
    /**
     * Public method registering a new candidate in the database
     * 
     * @param Candidate $candidate The candidate to registering
     * @return int The new candidate's primary key
     */
    public function inscript(Candidate &$candidate): int {
        $request = "INSERT INTO Candidates (Name, Firstname, Gender";

        $values_request = " VALUES (:name, :firstname, :gender";

        if(!empty($candidate->getEmail())) {
            $request .= ", Email";
            $values_request .= ", :email";
        }

        if(!empty($candidate->getPhone())) {
            $request .= ", Phone";
            $values_request .= ", :phone";
        }

        if(!empty($candidate->getAddress()) && !empty($candidate->getCity()) && !empty($candidate->getPostcode())) {
            $request .= ", Address, City, Postcode";
            $values_request .= ", :address, :city, :postcode";
        }

        if(!empty($candidate->getDescription())) {
            $request .= ", Description";
            $values_request .= ", :description";
        }

        if(!empty($candidate->getRating())) {
            $request .= ", Rating";
            $values_request .= ", :rating";
        }

        if(!empty($candidate->getAvailability())) {
            $request .= ", Availability";
            $values_request .= ", :availability";
        }

        if(!empty($candidate->getVisit())) {
            $request .= ", MedicalVisit";
            $values_request .= ", :visit";
        }

        $request .= ")" . $values_request . ")";
        unset($values_request);
    
        return $this->post_request($request, $candidate->toSQL());
    }

    // * UPDATE * //
    /**
     * Public method updating a candidate
     *
     * @param Candidate $candidate The candidate to update
     * @return void
     */
    public function update(Candidate $candidate): void {
        $request = "UPDATE Candidates SET
            Name = :name,
            Firstname = :firstname,
            Gender = :gender, 
            Email = NULLIF(:email, ''),
            Phone = NULLIF(:phone, ''),
            Address = NULLIF(:address, ''),
            City = NULLIF(:city, ''),
            Postcode = NULLIF(:postcode, ''),
            Description = NULLIF(:description, ''),
            Rating = NULLIF(:rating, ''),
            A = :a,
            B = :b,
            C = :c,
            Availability = NULLIF(:availability, ''),
            MedicalVisit = NULLIF(:visit, ''),
            Is_delete = :deleted

            WHERE Id = :id";

        $params = $candidate->toArray();

        $this->post_request($request, $params);
    }
}