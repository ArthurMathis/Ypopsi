<?php

namespace App\Models;

use App\Models\PeopleInterface;
use App\Core\Tools\DataFormat\DataFormatManager;
use App\Core\Tools\DataFormat\TimeManager;
use App\Exceptions\CandidateExceptions;
use Exception;

/**
 * Class representing a candidate
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Candidate implements PeopleInterface {
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
        protected ?string $name, 
        protected ?string $firstname, 
        protected ?bool $gender, 
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
        if(!is_null($id) && !DataFormatManager::isValidKey($id)) {
            throw new CandidateExceptions("La clé primaire : {$id} est invalide.");
        }

        // The name 
        if(!is_null($name) && !DataFormatManager::isValidName($name)) {
            throw new CandidateExceptions("Le nom : {$name} est invalide.");
        }

        // The firstname 
        if(!is_null($firstname) && !DataFormatManager::isValidName($firstname)) {
            throw new CandidateExceptions("Le prénom : {$firstname} est invalide.");
        }

        if(is_null($name) && is_null($firstname)) {
            throw new CandidateExceptions("Impossible de générer un candidat sans nom et sans prénom.");
        }

        // The email
        if(!is_null($email) && !DataFormatManager::isValidEmail($email)) {
            throw new CandidateExceptions("L'email : {$email} est invalide.");
        }

        // The phone
        if(!is_null($phone)) {
            $this->phone = DataFormatManager::phoneNumberFormat($phone);                                                      // Formating the phone number
        }

        // The city
        if(!is_null($city) && !DataFormatManager::isValidName($city)) {
            throw new CandidateExceptions("La ville : {$city} est invalide.");
        }

        // The postcode
        if(!is_null($postcode) && !DataFormatManager::isValidPostCode($postcode)) {
            throw new CandidateExceptions("Le code postal : {$postcode} est invalide.");
        }

        // The rating
        if(!is_null($rating) && !self::isValidRating($rating)) {
            throw new CandidateExceptions("La notation : {$rating} est invalide.");
        }

        // The availability 
        if(!is_null($availability) && !TimeManager::isYmdDate($availability)) {
            throw new CandidateExceptions("La date de disponibilité : {$availability} est invalide.");
        }

        // The visit
        if(!is_null($visit) && !TimeManager::isYmdDate($visit)) {
            throw new CandidateExceptions("La date de visite médicale : {$visit} est invalide.");
        }
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
    public function getName(): ?string { return $this->name; }
    /**
     * Public function returning the firstname of the candidate
     * 
     * @return string
     */
    public function getFirstname(): ?string { return $this->firstname; }
    /**
     * Public method erturning the complete candidate's name 
     *
     * @return string
     */
    public function getCompleteName(): string {
        $name = !is_null($this->getName()) ? $this->getName() : "??";
        $firstname = !is_null($this->getFirstname()) ? $this->getFirstname() : "??";
        $response = $this->getGender() ? "M" : "Mme";
        $response .= ". " . strtoupper($name) . " " . $firstname;
        return $response;
    }
    /**
     * Public function returning the gender of the candidate
     * 
     * @return bool
     */
    public function getGender(): ?bool { return $this->gender; }
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
        if(!DataFormatManager::isValidKey($id)) {
            throw new CandidateExceptions("Clé primaire invalide : {$id}. Clé attendue strictement positive.");
        }

        $this->id = $id;
    }
    /**
     * Public method setting candidate's name
     *
     * @param string $name The new name of the candidate
     * @throws CandidateExceptions If the name is invalid
     * @return void
     */
    public function setName(string $name): void {
        if(!DataFormatManager::isValidName($name)) {
            throw new CandidateExceptions("Le nom : {$name} est invalide.");
        }

        $this->name = $name;
    }
    /**
     * Public method setting candidate's firstname
     *
     * @param string $firstname The new firstname of the candidate
     * @throws CandidateExceptions If the firstname is invalid
     * @return void
     */
    public function setFirstname(string $firstname): void {
        if(!DataFormatManager::isValidName($firstname)) {
            throw new CandidateExceptions("Le prénom : {$firstname} est invalide.");
        }

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
     * @throws CandidateExceptions If the email is invalid
     * @return void
     */
    public function setEmail(?string $email = null): void {
        if(!is_null($email) && !DataFormatManager::isValidEmail($email)) {
            throw new CandidateExceptions("L'email : {$email} est invalide.");
        }

        $this->email = $email;
    }
    /**
     * Public method setting candidate's phone
     *
     * @param string $phone The new phone of the candidate
     * @throws CandidateExceptions If the phone is invalid
     * @return void
     */
    public function setPhone(?string $phone = null): void {
        if(!is_null($phone)) {
            $phone = DataFormatManager::phoneNumberFormat($phone);
        }

        $this->phone = $phone;
    }
    /**
     * Public method setting candidate's address
     *
     * @param ?string $address The new address of the candidate
     * @return void
     */
    public function setAddress(?string $address = null): void {
        $this->address = $address;
    }
    /**
     * Public method setting candidate's city
     *
     * @param ?string $city The new city of the candidate
     * @throws CandidateExceptions If the city is invalid
     * @return void
     */
    public function setCity(?string $city = null): void {
        if(!is_null($city) && !DataFormatManager::isValidName($city)) {
            throw new CandidateExceptions("La ville : {$city} est invalide.");
        }

        $this->city = $city;
    }
    /**
     * Public method setting candidate's postcode
     *
     * @param ?string $postcode The new postcode of the candidate
     * @throws CandidateExceptions If the postcode is invalid
     * @return void
     */
    public function setPostcode(?string $postcode = null): void {
        if(!is_null($postcode) && !DataFormatManager::isValidPostCode($postcode)) {
            throw new CandidateExceptions("Le code postal : {$postcode} est invalide.");
        }

        $this->postcode = $postcode;
    }

    /**
     * Public function setteing the candidate's rate
     *
     * @param int $rate The candidate's rate
     * @throws CandidateExceptions If the rate is invalid
     * @return void
     */
    public function setRating(int $rate): void {
        if(!self::isValidRating($rate)) {
            throw new CandidateExceptions("La notation  : {$rate} est invalide.");
        }

        $this->rating = $rate;
    }
    /**
     * Public function setting the candidate's description
     *
     * @param ?string $description The candidate's description
     * @return void
     */
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    /**
     * Public function setting the the candidate A value
     *
     * @param boolean $present 
     * @return void
     */
    public function setA(bool $present): void { $this->a = $present; }
    /**
     * Public function setting the the candidate B value
     *
     * @param boolean $present 
     * @return void
     */
    public function setB(bool $present): void { $this->b = $present; }
    /**
     * Public function setting the the candidate C value
     *
     * @param boolean $present 
     * @return void
     */
    public function setC(bool $present): void { $this->c = $present; }

    // * CONVERT * //
    /**
     * Public static method returning an Candidate building from an array
     * 
     * @param array $data The array that contains the data 
     * @throws CandidateExceptions If any piece of information is invalid
     * @return Candidate The candidate
     */
    public static function fromArray(array $data): ?Candidate {
        if(is_null($data)) {
            throw new CandidateExceptions("Erreur lors de la génération du candidat. Tableau de données absent.");
        }

        return new Candidate(
            id          : $data["Id"],
            name        : $data["Name"],
            firstname   : $data["Firstname"],
            gender      : $data["Gender"],
            email       : $data["Email"],
            phone       : $data["Phone"],
            address     : $data["Address"],
            city        : $data["City"],
            postcode    : $data["PostCode"],
            availability: $data["Availability"],
            visit       : $data["MedicalVisit"],
            rating      : $data["Rating"],
            description : $data["Description"],
            deleted     : $data["Is_delete"],
            a           : $data["A"],
            b           : $data["B"],
            c           : $data["C"]
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
            "deleted"      => $this->getDeleted() ? 1 : 0,
            "a"            => $this->getA() ? 1 : 0,
            "b"            => $this->getB() ? 1 : 0,
            "c"            => $this->getC() ? 1 : 0
        );
    }

    /**
     * Public function returning the candidate into an array for SQL registering
     * 
     * @return array The candidate
     */
    public function toSQL(bool $completed = false): array {
        $response = [
            "name"      => $this->getName(),
            "firstname" => $this->getFirstname(),
            "gender"    => $this->getGender()
        ];

        if(!is_null($this->getEmail())) {
            $response["email"] = $this->getEmail();
        }
        if(!is_null($this->getPhone())) {
            $response["phone"] = $this->getPhone();
        }

        if(!is_null($this->getAddress())) {
            $response["address"]  = $this->getAddress();
        }

        if(!is_null($this->getCity())) {
            $response["city"]     = $this->getCity();
        }

        if(!is_null($this->getPostcode())) {
            $response["postcode"] = $this->getPostcode();
        }

        if($this->getDescription()) {
            $response["description"] = $this->getDescription();
        }
        if($this->getRating()) {
            $response["rating"] = (int) $this->getRating();
        }

        if($this->getAvailability()) {
            $response["availability"] = $this->getAvailability();
        }
        if($this->getVisit()) {
            $response["visit"] = $this->getVisit();
        }

        if($completed) {                                                     // Ajout des paramètres manquants pour éviter les erreurs
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

    /**
     * Public static method checking if the rate is valid
     *
     * @param int $rating
     * @return boolean
     */
    public static function isValidRating(int $rating): bool {
        return 0 < $rating && $rating <= 5;
    }
}