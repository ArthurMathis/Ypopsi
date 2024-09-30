<?php 

require_once('Instants.php');

/**
 * @brief Class representing one candidate's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideCandidateExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * @brief Class representing one candidate
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Candidate {
    /**
     * @brief Private attibute containing the candidate's key
     * @var [type] His key
     */
    private $key = null;
    /**
     * @brief Private attribute containing the candidate's name
     * @var [String] His name
     */
    private $name;
    /**
     * @brief Private attibute containing the candidate's firstname
     * @var [String] His firstname
     */
    private $firstname;
    /**
     * @brief Private attibute containing the candidate's email address
     * @var [String] His email address
     */
    private $email;
    /**
     * @brief Private attibute containing the candidate's phone number
     * @var [String] His phone number
     */
    private $phone;
    /**
     * @brief Private attibute containing the candidate's address
     * @var [String] His address
     */
    private $address;
    /**
     * @brief Private attibute containing the city where lives the candidate
     * @var [String] The city
     */
    private $city;
    /**
     * @brief Private attibute containing the city's post code 
     * @var [Integer] The post code
     */
    private $post_code;
    /**
     * @brief Private attibute containing the candidate's availability
     * @var [Date] His availability
     */
    private $availability = null;
    /**
     * @brief Private attibute containing the candidate last medical visit date
     * @var [Date] His last medical visit date
     */
    private $medical_visit = null;

    /**
     * @brief Class' construtor
     * @param [String] $name The candidate's name
     * @param [String] $firstname The candidate's firstname
     * @param [String] $email The candidate's email address
     * @param [String] $phone The candidate's phone number
     * @param [String] $address The candidate's address
     * @param [String] $city The city where the candidate lives
     * @param [String] $post_code The city's post code
     */
    public function __construct($name, $firstname, $email, $phone, $address, $city, $post_code) {
        $this->setName($name);
        $this->setFirstname($firstname);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setAddress($address);
        $this->setCity($city);
        $this->setPostCode($post_code);
    } 

    /**
     * @brief Public method returning the candidate's key
     * @return Integer 
     */
    public function getKey() { return $this->key; }
    /**
     * @brief Public method returning the candidate's name
     * @return String
     */
    public function getName() { return $this->name; }
    /**
     * @brief Public method returning the candidate's firstname
     * @return String
     */
    public function getFirstname() { return $this->firstname; }
    /**
     * @brief Public method returning the candidate's email address
     * @return String
     */
    public function getEmail() { return $this->email; }
    /**
     * @brief Public method returning the candidate's phone number
     * @return String
     */
    public function getPhone() { return $this->phone; }
    /**
     * @brief Public method returning the candidate's address
     * @return String
     */
    public function getAddress() { return $this->address; }
    /**
     * @brief Public method returning the city where lives the candidate
     * @return String
     */
    public function getCity() { return $this->city; }
    /**
     * @brief Public method returning the city's post code
     * @return String
     */
    public function getPostCode() { return $this->post_code; }
    /**
     * @brief Public method returning the candidate's availability
     * @return Date
     */
    public function getAvailability() { return $this->availability; }
    /**
     * @brief Public method returning the candidate last medical visit date
     * @return Date
     */
    public function getMedicalVisit() { return $this->medical_visit; }

    /**
     * @brief Public method setting the candidate's key
     * @param [Integer] $key The candidate's key
     * @return void
     */
    public function setKey($key) { 
        // On vérifie la présence d'une clé
        if($key == null)
            return;

        // On vérifie l'intégrité des données
        elseif(!is_numeric($key)) 
            throw new InvalideCandidateExceptions("La clé d'un candidat doit être un entier !");
        elseif($key < 0)
            throw new InvalideCandidateExceptions("La clé d'un candidat doit être strictement positive !");

        // On implémente    
        else  $this->key = $key;
    }
    /**
     * @brief Private method setting the candidate's name
     * @param [String] $name
     * @return void
     */
    private function setName($name) { 
        // On vérifie l'intégrité des données
        if(empty($name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas être vide !");
        elseif(!is_string($name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $name))
            throw new InvalideCandidateExceptions("Le nom d'un candidat ne peut pas contenir de carcatères spéciaux !");

        // On implémente    
        else $this->name = $name;
    }
    /**
     * @brief Private method setting the candidate's firstname
     * @param [String] $firstname
     * @return void
     */
    private function setFirstname($firstname) { 
        // On vérifie l'intégrité des données
        if(empty($firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas être vide !");
        elseif(!is_string($firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\p{L}\p{M}\s\'-]/u', $firstname))
            throw new InvalideCandidateExceptions("Le prenom d'un candidat ne peut pas contenir de carcatères spéciaux !");

        // On implémente    
        else $this->firstname = $firstname;
    }
    /**
     * @brief Private method setting the candidate's email address
     * @param [String] $email
     * @return void
     */
    private function setEmail($email) { 
        // On vérifie l'intégrité des données
        if(empty($email))
            throw new InvalideCandidateExceptions("L'email d'un candidat ne peut être vide !");
        elseif(!is_string($email))
            throw new InvalideCandidateExceptions("L'email d'un candidat doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideCandidateExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        // On implémente
        else $this->email = $email;
    }
    /**
     * @brief Private method setting the candidate's phone number
     * @param [String] $phone
     * @return void
     */
    private function setPhone($phone) { 
        // On vérifie l'intégrité des données
        if(empty($phone)) 
            throw new InvalideCandidateExceptions("Le téléphone d'un utilisateur ne peut pas être vide !");
        elseif(!is_string($phone))
            throw new InvalideCandidateExceptions("Un numero de téléphone doit être une chaine de carcatères composées de nombres et de points !");

        // On implémente    
        else $this->phone = $phone;
    }
    /**
     * @brief Private method setting the candidate's address
     * @param [String] $address
     * @return void
     */
    private function setAddress($address) { 
        // On vérifie l'intégrité des données
        if(empty($address))
            throw new InvalideCandidateExceptions("L'adresse d'un candidat ne peut pas être vide !");
        elseif(!is_string($address))
            throw new InvalideCandidateExceptions("L'adresse d'un candidat doit être une chaine de carcatères !");
        
        // On implémente
        else $this->address = $address;
    }
    /**
     * @brief Private method setting the city where lives the candidate
     * @param [String] $city
     * @return void
     */
    private function setCity($city) { 
        // On vérifie l'intégrité des données
        if(empty($city))
            throw new InvalideCandidateExceptions("La ville d'un candidat ne peut pas être vide !");
        elseif(!is_string($city))
            throw new InvalideCandidateExceptions("La ville d'un candidat doit être une chaine de carcatères !");
        elseif(preg_match('/\d/', $city))
            throw new InvalideCandidateExceptions("La ville d'un candidat ne peut pas contenir de nombres !");
        elseif(preg_match('/[^\w\s]/', $city))
            throw new InvalideCandidateExceptions("La ville d'un candidat ne peut pas contenir de carcatères spéciaux !");
        
        // On implémente
        else $this->city = $city;
    }
    /**
     * @brief Private method setting the city's post code
     * @param [String] $post_code
     * @return void
     */
    private function setPostCode($post_code) { 
        // On vérifie l'intégrité des données
        if(empty($post_code))
            throw new InvalideCandidateExceptions("Le code postale d'un cndidat ne peut être vide !");
        elseif(!preg_match ("~^[0-9]{5}$~", $post_code))
            throw new InvalideCandidateExceptions("Le code postale doit être composé de cinq nombres uniquement !");

        else $this->post_code = $post_code;
    }
    /**
     * @brief Public method setting the candidate's availability
     * @param [Date] $availability
     * @return void
     */
    public function setAvailability($availability) { 
        // On vérifie l'intégrité des données
        if(empty($availability))
            throw new InvalideCandidateExceptions("La disponibilité d'un candidat doit être remplie !");
        elseif(!Instants::isDate($availability))
            throw new InvalideCandidateExceptions("La disponibilité d'un candidat doit être une date !");
        
        // On implémente
        else $this->availability = $availability;
    }
    /**
     * @brief Public method setting the candidate last medical visit date
     * @param [Date] $visite
     * @return void
     */
    public function setMedicalVisit($visite) {
        // On vérifie l'intégrité des données
        if(empty($visite))
            throw new InvalideCandidateExceptions("La visite médicale d'un candidat doit être remplie !");
        elseif(!Instants::isDate($visite))
            throw new InvalideCandidateExceptions("La visite médicale d'un candidat doit être une date !");
        
        // On implémente
        else $this->medical_visit = $visite;
    }

    /**
     * @brief Public method returning the candidate's data in an array
     * @return Array
     */
    public function exportToSQL() {
        // Avec une visité médicale
        if($this->getMedicalVisit())
            return [
                "nom" => $this->getName(),
                "prenom" => $this->getFirstname(),
                "email" => $this->getEmail(), 
                "telephone" => $this->getPhone(),
                "adresse" => $this->getAddress(),
                "ville" => $this->getCity(),
                "code_postal" => $this->getPostCode(),
                "disponibilite" => $this->getAvailability(),
                "visite" => $this->getMedicalVisit()
            ];

        // Sans    
        else 
            return [
                "nom" => $this->getName(),
                "prenom" => $this->getFirstname(),
                "email" => $this->getEmail(), 
                "telephone" => $this->getPhone(),
                "adresse" => $this->getAddress(),
                "ville" => $this->getCity(),
                "code_postal" => $this->getPostCode(),
                "disponibilite" => $this->getAvailability()
            ];
    }
    /**
     * @brief Public method returning the candidate's data in an array
     * @return Array
     */
    public function exportToSQL_update() {
        return [
            "nom" => $this->getName(),
            "prenom" => $this->getFirstname(),
            "email" => $this->getEmail(), 
            "telephone" => $this->getPhone(),
            "adresse" => $this->getAddress(),
            "ville" => $this->getCity(),
            "code_postal" => $this->getPostCode()
        ];
    }
    /**
     * @brief Public method returning the candidate's data in an array
     * @return Array
     */
    public function exportToSQL_Key() {
        if($this->getKey() == null) {
            throw new InvalideCandidateExceptions("La clé du candidat doit être implémentée avec une exporttation SQL !");
            exit;
        }

        return [
            "id" => $this->getKey(),
            "nom" => $this->getName(),
            "prenom" => $this->getFirstname(),
            "email" => $this->getEmail(), 
            "telephone" => $this->getPhone(),
            "adresse" => $this->getAddress(),
            "ville" => $this->getCity(),
            "code_postal" => $this->getPostCode(),
            "disponibilite" => $this->getAvailability(),
            "visite" => $this->getMedicalVisit()
        ];
    }
}
