<?php

/**
 *  Class representing one user's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideUtilisateurExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 *  Class representing one user
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class User {
    /**
     *  Private attribute containing the user's key
     * @var Int His key
     */
    private $key = null;
    /**
     *  Private attribute containing the user's identifier
     * @var String
     */
    private $identifier;
    /**
     *  Private attribute containing the user's name
     * @var String His name
     */
    private $name;
    /**
     *  Private attribute containing the user's firstname
     * @var String His firstname
     */
    private $firstname;
    /**
     *  Private attribute containing the user's email address
     * @var String His email address
     */
    private $email;
    /**
     *  Private attribute containing the user's password
     * @var String His password
     */
    private $password; 
    /**
     *  Private attribute containing the establishment where works the user
     * @var Int The establishment 
     */
    private $establishment;
    /**
     *  Private attribute containing the user's role
     * @var Int His role
     */
    private $role;
    /**
     *  Private attribute indicating if the user's password is by default
     * @var Bool TRUE - if the password needs to be changed ; FALSE - if not
     */
    private $firstLog = false;

    /**
     *  Class' constructor
     * @param String $identifier
     * @param String $name
     * @param String $firstname
     * @param String $email
     * @param String $password
     * @param Int $establishment
     * @param Int $role
     * @throws InvalideUtilisateurExceptions If the user's data is invalid
     */
    public function __construct($identifier, $name, $firstname, $email, $password, $establishment, $role) {
        $this->setIdentifier($identifier);
        $this->setName($name);
        $this->setFirstname($firstname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setEstablishment($establishment);
        $this->setRole($role);
    }

    /**
     *  Public method returning the user's key
     * @return Int|NULL
     */
    public function getKey(): ?int { return $this->key; }
    /**
     * Public methog returning the user's identifier
     * 
     * @return String
     */
    public function getIdentifier(): string { return $this->identifier; }
    /**
     * Public methog returning the user's name
     * 
     * @return String
     */
    public function getName(): string { return $this->name; }
    /**
     * Public methog returning the user's firstname
     * 
     * @return String
     */
    public function getFirstname(): string { return $this->firstname; }
    /**
     * Public methog returning the user's email
     * 
     * @return String
     */
    public function getEmail(): string { return $this->email; }
    /**
     * Public methog returning the user's password
     * 
     * @return String
     */
    public function getPassword(): string { return $this->password; }
    /**
     * Public methog returning the user's establishment
     * 
     * @return Int
     */
    public function getEstablishment(): int { return $this->establishment; }
    /**
     * Public methog returning the user's role
     * 
     * @return Interger
     */
    public function getRole(): int { return $this->role; }
    /**
     *  Public methog returning if the user's password has been changed
     * @return Bool
     */
    public function getFirstLog(): bool { return $this->firstLog; }

    /**
     *  Public method setting the user's key
     * @param Int $key His key
     * @throws InvalideUtilisateurExceptions If the  key is invalid
     * @return void
     */
    public function setKey($key) {
        if($key == null || !is_numeric($key)) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être un entier !");
        elseif($key < 0) 
            throw new InvalideUtilisateurExceptions("La clé primaire doit être supéieure ou égale à 0 !");

        // On implémente
        else $this->key = $key;
    }
    /**
     *  Private method setting the user's identifier
     * @param String $identifier His identifier
     * @throws InvalideUtilisateurExceptions If the identifier is invalid
     * @return void
     */
    private function setIdentifier($identifier){
        // On vérifie que l'indentifiant utilisateur est non-vide
        if(empty($identifier))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($identifier) || is_numeric($identifier))
            throw new InvalideUtilisateurExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->identifier = $identifier;
    }
    /**
     *  Private method setting the user's name
     * @param String $name His name
     * @throws InvalideUtilisateurExceptions If the name is invalid
     * @return void
     */
    private function setName($name) {
        // On vérifie que le nom est non-vide
        if(empty($name))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur ne peut être vide !");
        // On vérifie que le nom est un string
        elseif(!is_string($name)  || is_numeric($name))
            throw new InvalideUtilisateurExceptions("Le nom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->name = $name;
    }
    /**
     *  Private method setting the user's firstname
     * @param String $firstname His firstname
     * @throws InvalideUtilisateurExceptions If the firstname is invalid
     * @return void
     */
    private function setFirstname($firstname) {
        // On vérifie que le prénom est non-vide
        if(empty($firstname))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur ne peut être vide !");
        // On vérifie que le prénom est un string
        elseif(!is_string($firstname) || is_numeric($firstname))
            throw new InvalideUtilisateurExceptions("Le prénom d'un utilisateur doit être une chaine de caractères !");
        
            // On implémente
        else $this->firstname = $firstname;
    }
    /**
     *  Private method setting the user's email address
     * @param String $email His email
     * @throws InvalideUtilisateurExceptions If the email is invalid
     * @return void
     */
    private function setEmail($email){
        // On vérifie que l'email est non-vide
        if(empty($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur ne peut être vide !");
        // On vérifie que l'email est un string
        elseif(!is_string($email) || is_numeric($email))
            throw new InvalideUtilisateurExceptions("L'email d'un utilisateur doit être une chaine de caractères !");
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new InvalideUtilisateurExceptions("L'email doit contenir un nom, un @ et une adresse ! (ex: nom.prenom@diaconat-mulhouse.fr)");
        
        // On implémente
        else $this->email = $email;
    }
    /**
     *  Private method setting the user's password
     * @param String $password His password
     * @throws InvalideUtilisateurExceptions If the password is invalid
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
     *  Private method setting the user's establishment
     * @param String $establishment The establishment where the user works
     * @throws InvalideUtilisateurExceptions If the establishment is invalid
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
     *  Private method setting the user's role
     * @param Int $role His role
     * @throws InvalideUtilisateurExceptions If the role is invalid
     * @return void
     */
    private function setRole($role) {
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
     *  Public method turning on true the user's attribute firstLog
     * @return void
     */
    public function setFirstLog() { $this->firstLog = true; }

        /**
     *  Public static method creating and retuning a new user from the data array
     * @param Array $data The data array
     * @throws InvalideUtilisateurExceptions If the data is invalid
     * @return User
     */
    static public function makeUser($data=[]): ?User {
        if(empty($data))
            throw new InvalideUtilisateurExceptions("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");
        if(!isset($data['identifier']) ||!isset($data['name']) ||!isset($data['firstname']) || !isset($data['email']) || !isset($data['password']) ||!isset($data['establishment']) || !isset($data['role']))
            throw new InvalideUtilisateurExceptions('Donnnées éronnées. Champs manquants.');

        $u = new User(
            $data['identifier'], 
            $data['name'], 
            $data['firstname'], 
            $data['email'], 
            $data['password'], 
            $data['establishment'], 
            $data['role']
        );

        if(isset($data['key']))
            $u->setKey($data['key']);
        return $u;
    }

    /**
     *  Public method returning the user's data in a array
     * @return Array
     */
    public function exportToArray(): array {
        return [
            'identifier' => $this->getIdentifier(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'role' => $this->getRole(),
            'key' => $this->getKey()
        ];
    }
    /**
     *  Public method returning the user's data in a array (created for SQL queries)
     * @throws InvalideUtilisateurExceptions If the user's data is no complete
     * @return Array|NULL
     */
    public function exportToSQL(): ?array {
        if($this->getName() == null || $this->getFirstname() == null) 
            throw new InvalideUtilisateurExceptions("Le nom et le prenom de l'utilisateur sont requis pour une exportation SQL.");
        
        else return [
            'identifier' => $this->getIdentifier(),
            'name' => $this->getName(),
            'firstname' => $this->getFirstname(),
            'email' => $this->getEmail(),
            'password' => password_hash($this->getPassword(), PASSWORD_DEFAULT),
            'key_establishments' => $this->getEstablishment(),
            'key_roles' => $this->getRole()
        ];
    } 
}