<?php

require_once(COMPONENTS.DS.'FormsManip.php');

/**
 * @brief Class representing one user's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * @brief Class representing one user
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class User {
    /**
     * @brief Private attribute containing the user's key
     * @var [Integer] His key
     */
    private $key = null;
    /**
     * @brief Private attribute containing the user's identifier
     * @var [String]
     */
    private $identifier;
    /**
     * @brief Private attribute containing the user's name
     * @var [String] His name
     */
    private $name;
    /**
     * @brief Private attribute containing the user's firstname
     * @var [String] His firstname
     */
    private $firstname;
    /**
     * @brief Private attribute containing the user's email address
     * @var [String] His email address
     */
    private $email;
    /**
     * @brief Private attribute containing the user's password
     * @var [String] His password
     */
    private $password; 
    /**
     * @brief Private attribute containing the establishment where works the user
     * @var [String] The establishment 
     */
    private $establishment;
    /**
     * @brief Private attribute containing the user's role
     * @var [String] His role
     */
    private $role;
    /**
     * @brief Private attribute indicating if the user's password is by default
     * @var boolean TRUE - if the password needs to be changed ; FALSE - if not
     */
    private $firstLog = false;

    /**
     * @brief Class' constructor
     * @param [String] $identifier
     * @param [String] $name
     * @param [String] $firstname
     * @param [String] $email
     * @param [String] $password
     * @param [String] $establishment
     * @param [String] $role
     */
    public function __construct($identifier, $name, $firstname, $email, $password, $establishment, $role) {
        try{
            $this->setIdentifier($identifier);
            $this->setName($name);
            $this->setFirstname($firstname);
            $this->setEmail($email);
            $this->setPassword($password);
            $this->setEstablishment($establishment);
            $this->setRole($role);

        // On récupère les éventuelles erreurs
        } catch(InvalideUtilisateurExceptions $e){
            forms_manip::error_alert([
                'title' => "Une erreur est survenue",
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * @brief Public static method creating and retuning a new user from the data array
     * @param array $data The data array
     * @return User
     */
    static public function makeUtilisateurs($data=[]) {
        // On vérifie la présence des données
        if(empty($data))
            throw new Exception("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");

        // On vérifie l'intégrité des données
        if(!isset($data['identifiant']) ||!isset($data['nom']) ||!isset($data['prenom']) || !isset($data['email']) || !isset($data['mot de passe']) ||!isset($data['etablissement']) || !isset($data['role']))
            throw new Exception('Donnnées éronnées. Champs manquants.');

        // On retourne le nouvel utilisateur
        return new User($data['identifiant'], $data['nom'], $data['prenom'], $data['email'], $data['mot de passe'], $data['etablissement'], $data['role']);
    }

    /**
     * @brief Public method returning the user's key
     * @return Integer 
     */
    public function getKey(){ return $this->key; }
    /**
     * @brief Public methog returning the user's identifier
     * @return String
     */
    public function getIdentifier(){ return $this->identifier; }
    /**
     * @brief Public methog returning the user's name
     * @return String
     */
    public function getName() { return $this->name; }
    /**
     * @brief Public methog returning the user's firstname
     * @return String
     */
    public function getFirstname() { return $this->firstname; }
    /**
     * @brief Public methog returning the user's email
     * @return String
     */
    public function getEmail(){ return $this->email; }
    /**
     * @brief Public methog returning the user's password
     * @return String
     */
    public function getPassword(){ return $this->password; }
    /**
     * @brief Public methog returning the user's establishment
     * @return String
     */
    public function getEstablishment(){ return $this->establishment; }
    /**
     * @brief Public methog returning the user's role
     * @return String
     */
    public function getRole(){ return $this->role; }
    /**
     * @brief Public methog returning if the user's password has been changed
     * @return Boolean
     */
    public function getFirstLog() { return $this->firstLog; }

    /**
     * @brief Public method setting the user's key
     * @param [Integer] $key His key
     * @return void
     */
    public function setKey($key) {
        // On vérifie que l'id est un nombre positif ou nul
        if($key == null || !is_numeric($key)) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être un entier !");
        // On vérifie que l'id est un nombre positif ou nul
        elseif($key < 0) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->key = $key;
    }
    /**
     * @brief Private method setting the user's identifier
     * @param [String] $identifier His identifier
     * @return void
     */
    private function setIdentifier($identifier){
        // On vérifie que l'indentifiant utilisateur est non-vide
        if(empty($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($identifiant))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->identifier = $identifiant;
    }
    /**
     * @brief Private method setting the user's name
     * @param [String] $name His name
     * @return void
     */
    private function setName($name) {
        // On vérifie que le nom est non-vide
        if(empty($name))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($name))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->name = $name;
    }
    /**
     * @brief Private method setting the user's firstname
     * @param [String] $firstname His firstname
     * @return void
     */
    private function setFirstname($firstname) {
        // On vérifie que le prénom est non-vide
        if(empty($firstname))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur ne peut être vide !");
        // On vérifie que le prénom est un string
        elseif(!is_string($firstname))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->firstname = $firstname;
    }
    /**
     * @brief Private method setting the user's email address
     * @param [String] $email His email
     * @return void
     */
    private function setEmail($email){
        // On vérifie que l'email est non-vide
        if(empty($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur ne peut être vide !");
        // On vérifie que l'email est un string
        elseif(!is_string($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideUtilisateurExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        // On implémente
        else $this->email = $email;
    }
    /**
     * @brief Private method setting the user's password
     * @param [String] $password His password
     * @return void
     */
    private function setPassword($password){
        // On vérifie que le mot de passe est non-vide
        if(empty($password))
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_string($password))
        // On implémente
            throw new InvalideUtilisateurExceptions("Le mot de passe d'un utilisateur doit être une chaine de caractères. Le mot de passe !");
        
        else $this->password = $password;
    }
    /**
     * @brief Private method setting the user's establishment
     * @param [String] $establishment The establishment where the user works
     * @return void
     */
    private function setEstablishment($establishment) {
        // On vérifie que l'établissement est non-vide
        if(empty($establishment))
            throw new InvalideUtilisateurExceptions("L'établissement d'un utilisateur ne peut être vide !");
        // On vérifie que l'établissement est un string
        elseif(!is_numeric($establishment))
            throw new InvalideUtilisateurExceptions("L'établissement d'un utilisateur doit être une chaine de caractères");
        
            // On implémente
        else $this->establishment = $establishment;
    }
    /**
     * @brief Private method setting the user's role
     * @param [String] $role His role
     * @return void
     */
    private function setRole($role){
        // On vérifie que le role est non-vide
        if(empty($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur ne peut être vide !");
        // On vérifie que le mot de passe est un string
        elseif(!is_numeric($role))
            throw new InvalideUtilisateurExceptions("Le rôle d'un utilisateur doit être une chaine de caractères");
        
            // On implémente
        else $this->role = $role;
    }
    /**
     * @brief Public method turning on true the user's attribute firstLog
     * @return void
     */
    public function setFirstLog() { $this->firstLog = true; }

    /**
     * @brief Public method returning the user's data in a array
     * @return Array
     */
    public function exportToArray(): array {
        return [
            'identifiant' => $this->getIdentifier(),
            'email' => $this->getEmail(),
            'motdepasse' => $this->getPassword(),
            'role' => $this->getRole(),
            'cle' => $this->getKey()
        ];
    }
    /**
     * @brief Public method returning the user's data in a array (created for SQL queries)
     * @return Array
     */
    public function exportToSQL(): ?array {
        if($this->getName() == null || $this->getFirstname() == null) 
            throw new Exception("Le nom et le prenom de l'utilisateur sont requis pour une exportation SQL.");
        
        else return [
            'identifiant' => $this->getIdentifier(),
            'nom' => $this->getName(),
            'prenom' => $this->getFirstname(),
            'email' => $this->getEmail(),
            'motdepasse' => password_hash($this->getPassword(), PASSWORD_DEFAULT),
            'cle_etablissement' => $this->getEstablishment(),
            'cle_role' => $this->getRole()
        ];
    } 
}