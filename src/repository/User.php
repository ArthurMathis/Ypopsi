<?php 

namespace App\Repository;

use App\Exceptions\UserExceptions;

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
     * Class' constructor
     * 
     * @param String $identifier
     * @param String $name
     * @param String $firstname
     * @param String $email
     * @param String $password
     * @param Int $establishment
     * @param Int $role
     * @throws UserExceptions If the user's data is invalid
     */
    public function __construct(string $identifier, string $name, string $firstname, string $email, string $password, int $establishment, int $role) {
        $this->setIdentifier($identifier);
        $this->setName($name);
        $this->setFirstname($firstname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setEstablishment($establishment);
        $this->setRole($role);
    }


    // * GET * //
    /**
     * Public method returning the user's key
     * 
     * @return Int|Null
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
     * Public methog returning if the user's password has been changed
     * 
     * @return Bool
     */
    public function getFirstLog(): bool { return $this->firstLog; }


    // * SET * //
    /**
     * Public method setting the user's key
     * 
     * @param Int $key His key
     * @throws UserExceptions If the  key is invalid
     * @return Void
     */
    public function setKey(int $key) {
        if($key <= 0) {
            throw new UserExceptions("La clé primaire doit être positive. La valeur : {$key} est invalide.");
        }

        $this->key = $key;
    }
    /**
     * Private method setting the user's identifier
     * 
     * @param String $identifier His identifier
     * @throws UserExceptions If the identifier is invalid
     * @return Void
     */
    private function setIdentifier(string $identifier){
        if(empty($identifier)) {
            throw new UserExceptions("L'identifiant d'un utilisateur ne peut être vide.");
        } elseif(is_numeric($identifier)) {
            throw new UserExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères. La valeur : {$identifier} est invalide.");
        }
        
        $this->identifier = $identifier;
    }
    /**
     * Private method setting the user's name
     * 
     * @param String $name His name
     * @throws UserExceptions If the name is invalid
     * @return Void
     */
    private function setName(string $name) {
        if(empty($name)) {
            throw new UserExceptions("Le nom d'un utilisateur ne peut être vide.");
        } elseif(is_numeric($name)) {
            throw new UserExceptions("Le nom d'un utilisateur doit être une chaine de caractères. La valeur : {$name} est invalide.");
        }
        
        $this->name = $name;
    }
    /**
     * Private method setting the user's firstname
     * 
     * @param String $firstname His firstname
     * @throws UserExceptions If the firstname is invalid
     * @return Void
     */
    private function setFirstname(string $firstname) {
        if(empty($firstname))
            throw new UserExceptions("Le prénom d'un utilisateur ne peut être vide.");
        elseif(is_numeric($firstname))
            throw new UserExceptions("Le prénom d'un utilisateur doit être une chaine de caractères. La valeur : {$firstname} est invalide.");
        else 
            $this->firstname = $firstname;
    }
    /**
     * Private method setting the user's email address
     * 
     * @param String $email His email
     * @throws UserExceptions If the email is invalid
     * @return Void
     */
    private function setEmail($email){
        if(empty($email)) {
            throw new UserExceptions("L'email d'un utilisateur ne peut être vide !");
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UserExceptions("L'email doit contenir un nom, un @ et une adresse (ex: nom.prenom@diaconat-mulhouse.fr). La valeur : {$email} est invalide");
        }

        $this->email = $email;
    }
    /**
     * Private method setting the user's password
     * 
     * @param String $password His password
     * @throws UserExceptions If the password is invalid
     * @return Void
     */
    private function setPassword(string $password){
        if(empty($password)) {
            throw new UserExceptions("Le mot de passe d'un utilisateur ne peut être vide !");
        }
        
        $this->password = $password;
    }
    /**
     * Private method setting the user's establishment
     * 
     * @param Int $establishment The establishment where the user works
     * @throws UserExceptions If the establishment is invalid
     * @return Void
     */
    private function setEstablishment(int $establishment) {
        if($establishment <= 0) {
            throw new UserExceptions("La clé d'établissement doit être positive. La valeur : {$establishment} est invalide.");
        }
        
        $this->establishment = $establishment;
    }
    /**
     * Private method setting the user's role
     * 
     * @param Int $role His role
     * @throws UserExceptions If the role is invalid
     * @return Void
     */
    private function setRole(int $role) {
        if($role <= 0) {
            throw new UserExceptions("La clé de rôle doit être positive. La valeur : {$role} est invalide.");
        }
        
        $this->role = $role;
    }
    /**
     *  Public method turning on true the user's attribute firstLog
     * @return Void
     */
    public function setFirstLog() { $this->firstLog = true; }

    /**
     * Public static method creating and retuning a new user from the data array
     * 
     * @param Array $data The data array
     * @throws UserExceptions If the data is invalid
     * @return User
     */
    static public function fromArray(array $data): ?User {
        if(empty($data)) {
            throw new UserExceptions("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");
        }
        
        if(!isset($data['identifier']) || !isset($data['name']) || !isset($data['firstname']) || !isset($data['email']) || !isset($data['password']) ||!isset($data['establishment']) || !isset($data['role'])) {
            throw new UserExceptions('Donnnées éronnées. Champs manquants.');
        }

        $u = new User(
            $data['identifier'], 
            $data['name'], 
            $data['firstname'], 
            $data['email'], 
            $data['password'], 
            $data['establishment'], 
            $data['role']
        );

        if(isset($data['key'])) {
            $u->setKey($data['key']);
        }
        return $u;
    }

    /**
     * Public method returning the user's data in a array
     * 
     * @return Array
     */
    public function exportToArray(): array {
        return [
            'identifier' => $this->getIdentifier(),
            'email'      => $this->getEmail(),
            'password'   => $this->getPassword(),
            'role'       => $this->getRole(),
            'key'        => $this->getKey()
        ];
    }
    /**
     * Public method returning the user's data in a array (created for SQL queries)
     * 
     * @throws UserExceptions If the user's data is no complete
     * @return Array|Null
     */
    public function exportToSQL(): ?array {
        if($this->getName() == null || $this->getFirstname() == null) 
            throw new UserExceptions("Le nom et le prenom de l'utilisateur sont requis pour une exportation SQL.");
        
        else return [
            'identifier'         => $this->getIdentifier(),
            'name'               => $this->getName(),
            'firstname'          => $this->getFirstname(),
            'email'              => $this->getEmail(),
            'password'           => password_hash($this->getPassword(), PASSWORD_DEFAULT),
            'key_establishments' => $this->getEstablishment(),
            'key_roles'          => $this->getRole()
        ];
    } 
}