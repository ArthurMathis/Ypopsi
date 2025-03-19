<?php

namespace App\Models;

use App\Exceptions\CandidateExceptions;

/**
 * Class representing a candidate
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Candidate {
    /**
     * Constructor class
     * 
     * @param ?int $id The primary key of the candidate
     * @param string $name The name of the candidate
     * @param string $firstname The firstname of the candidate
     * @param bool $gender The gender of the candidate
     * @param ?string $email The email address of the candidate
     * @param ?string $phone The phone number of the candidate
     * @param ?string $address The address of the candidate
     * @param ?string $city The city of the candidate
     * @param ?string $postcode The postcode of the candidate
     * @param ?string $availability The availability of the candidate
     * @param ?string $visit The expiry date of the medical check-up of the candidate
     * @param ?int $rating The rate of the candidate
     * @param ?string $description The description of the candidate
     * @param bool $deleted Boolean indicating if the candidate has been deleted
     * @param bool $a Boolean indicating if the first criterion in the list is validated
     * @param bool $b Boolean indicating if the second criterion in the list is validated
     * @param bool $c Boolean indicating if the third criterion in the list is validated
     * @throws CandidateExceptions If any piece of information is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $name, 
        protected string $firstname, 
        protected bool $gender, 
        protected ?string $email, 
        protected ?string $phone, 
        protected ?string $address, 
        protected ?string $city, 
        protected ?string $postcode,
        protected ?string $availability,
        protected ?string $visit, 
        protected ?int $rating, 
        protected ?string $description, 
        protected bool $deleted,
        protected bool $a,
        protected bool $b,
        protected bool $c
    )
    {
        // The primary key
        if(!empty($id) && $id <= 0) {
            throw new CandidateExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        // todo : vérification du nom
        // todo : vérification du prénom
        // todo : vérification de l'email
        // todo : vérification de l'email
        // todo : vérification du numéro de téléphone 
        // todo : vérification de l'adresse
        // todo : vérification de la ville
        // todo : vérification du code postal
    }

    /**
     * Public static method building and returing a new candidate
     * 
     * @param string $name The candidate's name
     * @param string $firstname The candidate's firstname
     * @param bool $gender The candidate's gender
     * @param ?string $availability The candidate's availability
     * @param ?string $email The candidate's email
     * @param ?string $phone The candidate's phone
     * @param ?string $address The candidate's address
     * @param ?string $city The candidate's city
     * @param ?string $postcode The candidate's postcode
     * @param ?int $rating The candidate's rating
     * @param ?string $description The candidate's description
     * @param ?string $visit The candidate's visit
     * @return Candidate The candidate
     */
    public static function create(
        string $name, 
        string $firstname, 
        bool $gender, 
        ?string $email = null, 
        ?string $phone = null, 
        ?string $address = null, 
        ?string $city = null, 
        ?string $postcode = null, 
        ?int $rating = null, 
        ?string $description = null, 
        ?string $availability = null, 
        ?string $visit = null
    ): Candidate {
        return new Candidate(
            null, 
            $name, 
            $firstname, 
            $gender, 
            $email, 
            $phone, 
            $address, 
            $city, 
            $postcode, 
            $availability, 
            $visit, 
            $rating, 
            $description, 
            false, 
            false, 
            false, 
            false
        );
    }

    // * GET * //
    /**
     * Public function returning the primary key of the candidate
     * 
     * @return ?int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public function returning the name of the candidate
     * 
     * @return string
     */
    public function getName(): string { return $this->name; }
    /**
     * Public function returning the firstname of the candidate
     * 
     * @return string
     */
    public function getFirstname(): string { return $this->firstname; }
    /**
     * Public method erturning the complete candidate's name 
     *
     * @return string
     */
    public function getCompleteName(): string {
        $response = $this->getGender() ? "M" : "Mme";
        $response .= ". " . strtoupper($this->getname()) . " " . $this->getFirstname();
        return $response;
    }
    /**
     * Public function returning the gender of the candidate
     * 
     * @return bool
     */
    public function getGender(): bool { return $this->gender; }
    /**
     * Public function returning the email of the candidate
     * 
     * @return ?string
     */
    public function getEmail(): ?string { return $this->email; }
    /**
     * Public function returning the phone number of the candidate
     * 
     * @return ?string
     */
    public function getPhone(): ?string { return $this->phone; }
    /**
     * Public function returning the address of the candidate
     * 
     * @return ?string 
     */
    public function getAddress(): ?string { return $this->address; }
    /**
     * Public function returning the city of the candidate
     * 
     * @return ?string
     */
    public function getCity(): ?string { return $this->city; }
    /**
     * Public function returning thepostcode of the candidate
     * 
     * @return ?string
     */
    public function getPostcode(): ?string { return $this->postcode; }
    /**
     * Public function returning the availability of the candidate
     * 
     * @return string
     */
    public function getAvailability(): ?string { return $this->availability; }
    /**
     * Public function returning the expiry date of the medical check-up of the candidate
     * 
     * @return string 
     */
    public function getVisit(): ?string { return $this->visit; }
    /**
     * Public function returning the rate of the candidate
     * 
     * @return ?int
     */
    public function getRating(): ?int { return $this->rating; }
    /**
     * Public function returning the description of the candidate
     * 
     * @return ?string
     */
    public function getDescription(): ?string { return $this->description; }
    /**
     * Public function returning the 
     * 
     * @return 
     */
    public function getDeleted(): bool { return $this->deleted; }
    /**
     * Public function returning the
     * 
     * @return 
     */
    public function getA(): bool { return $this->a; }
    /**
     * Public function returning the
     * 
     * @return 
     */
    public function getB(): bool { return $this->b; }
    /**
     * Public function returning the
     * 
     * @return 
     */
    public function getC(): bool { return $this->c; }

    // * SET * //
    /**
     * Public function setting the candidate's primary key
     *
     * @param int $id The candidate's primary key
     * @throws CandidateExceptions If the primary key is invalid
     * @return void
     */
    public function setId(int $id): void {
        if($id <= 0) {
            throw new CandidateExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        $this->id = $id;
    }
    /**
     * Public method setting candidate's name
     *
     * @param string $name The new name of the candidate
     * @return void
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
    /**
     * Public method setting candidate's firstname
     *
     * @param string $firstname The new firstname of the candidate
     * @return void
     */
    public function setFirstname(string $firstname): void {
        $this->firstname = $firstname;
    }
    /**
     * Public method setting candidate's gender
     *
     * @param bool $name The new gender of the candidate
     * @return void
     */
    public function setGender(bool $gender): void {
        $this->gender = $gender;
    }
    /**
     * Public method setting candidate's email
     *
     * @param string $email The new email of the candidate
     * @return void
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    /**
     * Public method setting candidate's phone
     *
     * @param string $phone The new phone of the candidate
     * @return void
     */
    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }
    /**
     * Public method setting candidate's address
     *
     * @param string $address The new address of the candidate
     * @return void
     */
    public function setAddress(string $address): void {
        $this->address = $address;
    }
    /**
     * Public method setting candidate's city
     *
     * @param string $city The new city of the candidate
     * @return void
     */
    public function setCity(string $city): void {
        $this->city = $city;
    }
    /**
     * Public method setting candidate's postcode
     *
     * @param string $postcode The new postcode of the candidate
     * @return void
     */
    public function setPostcode(string $postcode): void {
        $this->postcode = $postcode;
    }

    public function setRating(int $rate): void {
        if($rate <= 0) {
            throw new CandidateExceptions("La notation doit être strictement positive. La valeur : {$rate} est invalide.");
        }

        if(5 < $rate) {
            throw new CandidateExceptions("La notation doit être inférieure ou égale à 5. La valeur : {$rate} est invalide.");
        }

        $this->rating = $rate;
    }
    public function setDescrption(?string $description): void {
        $this->description = $description;
    }
    public function setA(bool $present): void {
        $this->a = $present;
    }
    public function setB(bool $present): void {
        $this->b = $present;
    }
    public function setC(bool $present): void {
        $this->c = $present;
    }

    // * CONVERT * //
    /**
     * Public static method returning an Candidate building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws CandidateExceptions If any piece of information is invalid
     * @return Candidate The candidate
     */
    public static function fromArray(array $data): ?Candidate {
        if(empty($data)) {
            throw new CandidateExceptions("Erreur lors de la génération du candidat. Tableau de données absent.");
        }

        return new Candidate(
            $data["Id"],
            $data["Name"],
            $data["Firstname"],
            $data["Gender"],
            $data["Email"],
            $data["Phone"],
            $data["Address"],
            $data["City"],
            $data["PostCode"],
            $data["Availability"],
            $data["MedicalVisit"],
            $data["Rating"],
            $data["Description"],
            $data["Is_delete"],
            $data["A"],
            $data["B"],
            $data["C"]
        );
    }

    /**
     * Public function returning the candidate into an array
     * 
     * @return array The array that contains the pieces of information
     */
    public function toArray(): array {
        return array(
            "id"           => $this->getId(),
            "name"         => $this->getName(),
            "firstname"    => $this->getFirstname(),
            "gender"       => $this->getGender(),
            "email"        => $this->getEmail(),
            "phone"        => $this->getPhone(),
            "address"      => $this->getAddress(),
            "city"         => $this->getCity(),
            "postcode"     => $this->getPostcode(),
            "availability" => $this->getAvailability(),
            "visit"        => $this->getVisit(),
            "rating"       => $this->getRating(),
            "description"  => $this->getDescription(),
            "deleted"      => $this->getDeleted(),
            "a"            => $this->getA(),
            "b"            => $this->getB(),
            "c"            => $this->getC()
        );
    }

    /**
     * Public function returning the candidate into an array for SQL registering
     * 
     * @return array The candidate
     */
    public function toSQL(bool $completed = false): array {
        $response = array(
            "name"      => $this->getName(),
            "firstname" => $this->getFirstname(),
            "gender"    => $this->getGender()
        );

        if(!empty($this->getEmail())) {
            $response["email"] = $this->getEmail();
        }
        if(!empty($this->getPhone())) {
            $response["phone"] = $this->getPhone();
        }

        if(!empty($this->getAddress()) && !empty($this->getCity()) && !empty($this->getPostcode())) {
            $response["address"]  = $this->getAddress();
            $response["city"]     = $this->getCity();
            $response["postcode"] = $this->getPostcode();
        }

        if($this->getDescription()) {
            $response["description"] = $this->getDescription();
        }
        if($this->getRating()) {
            $response["rating"] = (int) $this->getRating();
        }

        if($this->getAvailability()) {
            $reponse["availability"] = $this->getAvailability();
        }
        if($this->getVisit()) {
            $response["visit"] = $this->getVisit();
        }

        if($completed) { // Ajout des paramètres manquants pour éviter les erreurs
            $response['email']        = $response['email'] ?? '';
            $response['phone']        = $response['phone'] ?? '';
            $response['address']      = $response['address'] ?? '';
            $response['city']         = $response['city'] ?? '';
            $response['postcode']     = $response['postcode'] ?? '';
            $response['description']  = $response['description'] ?? '';
            $response['rating']       = $response['rating'] ?? '';
            $response['availability'] = $response['availability'] ?? '';
            $response['visit']        = $response['visit'] ?? '';
        }

        return $response;
    }
}