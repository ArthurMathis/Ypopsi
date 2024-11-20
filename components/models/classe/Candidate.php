<?php 

require_once('Moment.php');

define('REGEX', '/^(\d{2}\.){4}\d{2}$/');

/**
 *  Class representing one candidate's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideCandidateExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 *  Class representing one candidate
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Candidate {
    /**
     * Private attibute containing the candidate's key
     * 
     * @var Int His key
     */
    private $key = null;
    /**
     * Private attribute containing the candidate's name
     * 
     * @var String His name
     */
    private $name;
    /**
     * Private attibute containing the candidate's firstname
     * 
     * @var String His firstname
     */
    private $firstname;
    /**
     * Pricate attribute containing the candidate's gender
     *
     * @var Bool
     */
    private $gender;
    /**
     * Private attibute containing the candidate's email address
     * 
     * @var String His email address
     */
    private $email;
    /**
     * Private attibute containing the candidate's phone number
     * 
     * @var String His phone number
     */
    private $phone;
    /**
     * Private attibute containing the candidate's address
     * 
     * @var String His address
     */
    private $address;
    /**
     * Private attibute containing the city where lives the candidate
     * 
     * @var String The city
     */
    private $city;
    /**
     * Private attibute containing the city's post code 
     * 
     * @var String The post code
     */
    private $post_code;
    /**
     * Private attibute containing the candidate's availability
     * 
     * @var String His availability
     */
    private $availability = null;
    /**
     * Private attibute containing the candidate last medical visit date
     * 
     * @var String His last medical visit date
     */
    private $medical_visit = null;

    /**
     * Class' construtor
     * 
     * @param String $name The candidate's name
     * @param String $firstname The candidate's firstname
     * @param String $email The candidate's email address
     * @param String $phone The candidate's phone number
     * @param String $address The candidate's address
     * @param String $city The city where the candidate lives
     * @param String $post_code The city's post code
     */
    public function __construct($name, $firstname, $gender, $email, $phone, $address, $city, $post_code) {
        $this->setName($name);
        $this->setFirstname($firstname);
        $this->setGender($gender);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setAddress($address);
        $this->setCity($city);
        $this->setPostCode($post_code);
    } 

    /**
     * Public method returning the candidate's key
     * 
     * @return Integer 
     */
    public function getKey(): ?Int { return $this->key; }
    /**
     * Public method returning the candidate's name
     * 
     * @return String
     */
    public function getName(): String { return $this->name; }
    /**
     * Public method returning the candidate's firstname
     * 
     * @return String
     */
    public function getFirstname(): String { return $this->firstname; }
    /**
     * Public method returning the candidate's gender
     *
     * @return Bool
     */
    public function getGender(): Bool { return $this->gender; }
    /**
     * Public method returning the candidate's email address
     * 
     * @return String
     */
    public function getEmail(): ?String { return $this->email; }
    /**
     * Public method returning the candidate's phone number
     * 
     * @return String
     */
    public function getPhone(): ?String { return $this->phone; }
    /**
     * Public method returning the candidate's address
     * 
     * @return String
     */
    public function getAddress(): ?String { return $this->address; }
    /**
     * Public method returning the city where lives the candidate
     * 
     * @return String
     */
    public function getCity(): ?String { return $this->city; }
    /**
     * Public method returning the city's post code
     * 
     * @return String
     */
    public function getPostCode(): ?String { return $this->post_code; }
    /**
     * Public method returning the candidate's availability
     * 
     * @return String
     */
    public function getAvailability(): ?String { return $this->availability; }
    /**
     * Public method returning the candidate last medical visit date
     * 
     * @return String
     */
    public function getMedicalVisit(): ?String { return $this->medical_visit; }

    /**
     * Public method setting the candidate's key
     * 
     * @param Int $key The candidate's key
     * @thorws InvalideCandidateExceptions If the key's is not integred
     * @return Void
     */
    public function setKey($key) { 
        if($key == null)
            throw new InvalideCandidateExceptions("La clé d'un candidat ne peut être nulle.");
        elseif(!is_numeric($key)) 
            throw new InvalideCandidateExceptions("La clé d'un candidat doit être un entier !");
        elseif($key < 0)
            throw new InvalideCandidateExceptions("La clé d'un candidat doit être strictement positive !");

        else  $this->key = $key;
    }
    /**
     * Private method setting the candidate's name
     * 
     * @param String $name The canddidate's name
     * @return Void
     */
    private function setName($name) { 
        if(empty($name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas être vide !");
        elseif(!is_string($name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas contenir de carcatères spéciaux !");


        else $this->name = $name;
    }
    /**
     * Private method setting the candidate's firstname
     * 
     * @param String $firstname The canddidate's firstname
     * @return Void
     */
    private function setFirstname($firstname) { 
        if(empty($firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas être vide !");
        elseif(!is_string($firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas contenir de carcatères spéciaux !");

        else $this->firstname = $firstname;
    }
    /**
     * Private method setting the candidate's gender
     *
     * @param Bool $gender The candidate's gender
     * @return Void
     */
    private function setGender($gender) { $this->gender = $gender; }
    /**
     * Private method setting the candidate's email address
     *  
     * @param String $email The canddidate's email
     * @return Void
     */
    private function setEmail($email) { 
        if(empty($email))
            return;

        if(!is_string($email))
            throw new InvalideCandidateExceptions("L'email d'un candidat doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideCandidateExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        $this->email = $email;
    }
    /**
     * Private method setting the candidate's phone number
     * 
     * @param String $phone The canddidate's phone
     * @return Void
     */
    private function setPhone($phone) { 
        if(empty($phone)) 
            return;
        
        if(!is_string($phone)) 
            throw new InvalideCandidateExceptions("Un numéro de téléphone doit être une chaîne de caractères !");
        elseif(!preg_match(REGEX, $phone))
            throw new InvalideCandidateExceptions("Le numéro de téléphone doit être au format XX.XX.XX.XX.XX, avec des chiffres !");
    
        $this->phone = $phone;
    }
    
    /**
     * Private method setting the candidate's address
     * 
     * @param String $address The canddidate's phone number
     * @return Void
     */
    private function setAddress($address) { 
        if(empty($address))
            return;

        if(!is_string($address) || is_numeric($address))
            throw new InvalideCandidateExceptions("L'adresse d'un candidat doit être une chaine de carcatères !");
        
        $this->address = $address;
    }
    /**
     * Private method setting the city where lives the candidate
     * 
     * @param String $city The canddidate's city
     * @return Void
     */
    private function setCity($city) { 
        if(empty($city))
            return;

        if(!is_string($city))
            throw new InvalideCandidateExceptions("La ville d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $city))
            throw new InvalideCandidateExceptions("La ville d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\w\s]/', $city))
            throw new InvalideCandidateExceptions("La ville d'un candidat ne peut pas contenir de carcatères spéciaux !");
        
        $this->city = $city;
    }
    /**
     * Private method setting the city's post code
     *  
     * @param String $post_code The canddidate's post code
     * @return Void
     */
    private function setPostCode($post_code) { 
        if(empty($post_code))
            return;
        
        if(!preg_match ("~^[0-9]{5}$~", $post_code))
            throw new InvalideCandidateExceptions("Le code postale doit être composé de cinq nombres uniquement !");

        $this->post_code = $post_code;
    }
    /**
     * Public method setting the candidate's availability
     * 
     * @param String $availability The canddidate's availability 
     * @return Void
     */
    public function setAvailability($availability) { 
        if(empty($availability))
            return;

        if(!Moment::isDate($availability))
            throw new InvalideCandidateExceptions("La disponibilité d'un candidat doit être une date !");
        
        $this->availability = $availability;
    }
    /**
     * Public method setting the candidate last medical visit date
     * 
     * @param String $visite
     * @return Void
     */
    public function setMedicalVisit($visite) {
        if(empty($visite))
            return;

        if(!Moment::isDate($visite))
            throw new InvalideCandidateExceptions("La visite médicale d'un candidat doit être une date !");

        else $this->medical_visit = $visite;
    }

    /**
     * Public method returning the candidate's data in an array
     * 
     * @throws InvalideCandidateExceptions If the candidte's availability is not completed
     * @return Array
     */
    public function exportToSQL(): array {
        if(!$this->getAvailability())
            throw new InvalideCandidateExceptions("Pour exporter un candidat, sa disponibilité doit être renseignée !");

        $array = [
            "name" => $this->getName(),
            "firstname" => $this->getFirstname(),
            "gender" => $this->getGender(),
            "email" => $this->getEmail(), 
            "phone" => $this->getPhone(),
            "address" => $this->getAddress(),
            "city" => $this->getCity(),
            "post_code" => $this->getPostCode(),
            "availability" => $this->getAvailability()
        ];

        if($this->getMedicalVisit())
            $array["medical_visit"] = $this->getMedicalVisit();
        
        return $array;
    }
    /**
     *  Public method returning the candidate's data in an array
     * @return Array
     */
    public function exportToSQL_update(): array {
        return [
            "name" => $this->getName(),
            "firstname" => $this->getFirstname(),
            "email" => $this->getEmail(), 
            "phone" => $this->getPhone(),
            "address" => $this->getAddress(),
            "city" => $this->getCity(),
            "post_code" => $this->getPostCode()
        ];
    }
    /**
     *  Public method returning the candidate's data in an array
     * @return Array
     */
    public function exportToSQL_Key(): array {
        if($this->getKey() == null) 
            throw new InvalideCandidateExceptions("La clé du candidat doit être implémentée avant une exporttation SQL !");

        return [
            "id" => $this->getKey(),
            "name" => $this->getName(),
            "firstname" => $this->getFirstname(),
            "email" => $this->getEmail(), 
            "phone" => $this->getPhone(),
            "address" => $this->getAddress(),
            "city" => $this->getCity(),
            "post_code" => $this->getPostCode(),
            "availability" => $this->getAvailability(),
            "medical_visit" => $this->getMedicalVisit()
        ];
    }
}
