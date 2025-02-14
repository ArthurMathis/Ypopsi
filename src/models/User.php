<?php 

namespace App\Models;

use App\Exceptions\UserExceptions;

/**
 * Class representing one user
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class User {
    /**
     * Constructor class
     * 
     * @param int $id The user's primary key
     * @param string $identifier The user's identifier
     * @param string $name The user's name
     * @param string $firstname The user's firstname
     * @param string $email The user's email
     * @param string $password The user's password
     * @param bool $password_temp If the user's password has never be changed
     * @param int $role The primary key of the user's role
     * @param int $establishment the primary key of the user's establishment
     * @throws UserExceptions If any attribut is invalid
     */
    public function __construct(
        protected ?int $id, 
        protected string $identifier, 
        protected string $name, 
        protected string $firstname, 
        protected string $email, 
        protected string $password, 
        protected ?bool $password_temp, 
        protected int $role, 
        protected int $establishment
    ) {
        // id
        if(!empty($id) & $id <= 0) {
            throw new UserExceptions("La clé primaire doit être positive. La valeur : {$id} est invalide.");
        }

        // identifier // todo : regex
        if(empty($identifier)) {
            throw new UserExceptions("L'identifiant d'un utilisateur ne peut être vide.");
        } elseif(is_numeric($identifier)) {
            throw new UserExceptions("L'identifiant d'un utilisateur doit être une chaine de caractères. La valeur : {$identifier} est invalide.");
        }

        // name  // todo : regex
        if(empty($name)) {
            throw new UserExceptions("Le nom d'un utilisateur ne peut être vide.");
        } elseif(is_numeric($name)) {
            throw new UserExceptions("Le nom d'un utilisateur doit être une chaine de caractères. La valeur : {$name} est invalide.");
        }

        // firstname // todo : regex
        if(empty($firstname)) {
            throw new UserExceptions("Le prénom d'un utilisateur ne peut être vide.");
        } elseif(is_numeric($firstname)) {
            throw new UserExceptions("Le prénom d'un utilisateur doit être une chaine de caractères. La valeur : {$firstname} est invalide.");
        }

        // email // todo : regex
        if(empty($email)) {
            throw new UserExceptions("L'email d'un utilisateur ne peut être vide !");
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UserExceptions("L'email doit contenir un nom, un @ et une adresse (ex: nom.prenom@diaconat-mulhouse.fr). La valeur : {$email} est invalide");
        }

        // role
        if($role <= 0) {
            throw new UserExceptions("La clé du rôle doit être positive. La valeur : {$role} est invalide.");
        }

        // establishment
        if($establishment <= 0) {
            throw new UserExceptions("La clé due l'établissement doit être positive. La valeur : {$establishment} est invalide.");
        }
    }


    // * GET * //
    /**
     * Public method returning the user's key
     * 
     * @return int
     */
    public function getId(): ?int { return $this->id; }
    /**
     * Public methog returning the user's identifier
     * 
     * @return string
     */
    public function getIdentifier(): string { return $this->identifier; }
    /**
     * Public methog returning the user's name
     * 
     * @return string
     */
    public function getName(): string { return $this->name; }
    /**
     * Public methog returning the user's firstname
     * 
     * @return string
     */
    public function getFirstname(): string { return $this->firstname; }
    /**
     * Public methog returning the user's email
     * 
     * @return string
     */
    public function getEmail(): string { return $this->email; }
    /**
     * Public methog returning the user's password
     * 
     * @return string
     */
    public function getPassword(): string { return $this->password; }
    /**
     * Public methog returning if the user's password has been changed
     * 
     * @return bool
     */
    public function getPasswordTemp(): ?bool { return $this->password_temp; }
    /**
     * Public methog returning the user's role
     * 
     * @return int
     */
    public function getRole(): int { return $this->role; }
    /**
     * Public methog returning the user's establishment
     * 
     * @return int
     */
    public function getEstablishment(): int { return $this->establishment; }

    
    // * CONVERT * //
    /**
     * Public static method creating and retuning a new user from the data array
     * 
     * @param array $data The data array
     * @throws UserExceptions If any piece of information is invalid
     * @return User The user
     */
    static public function fromArray(array $data): ?User {
        if(empty($data)) {
            throw new UserExceptions("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");
        }

        return new User(
            $data['Id'],
            $data['Identifier'], 
            $data['Name'], 
            $data['Firstname'], 
            $data['Email'], 
            $data['Password'], 
            $data['PasswordTemp'], 
            $data['Key_Roles'],
            $data['Key_Establishments']
        );
    }

    /**
     * Public method returning the user's data in a array
     * 
     * @return array
     */
    public function toArray(): array {
        return array(
            'id'             => $this->getId(),
            'identifier'     => $this->getIdentifier(),
            'name'           => $this->getName(),
            'firstname'      => $this->getFirstname(),
            'email'          => $this->getEmail(),
            'password'       => $this->getPassword(),
            'password_temp'  => $this->getPasswordTemp(),
            'role'           => $this->getRole(),
            'establishement' => $this->getEstablishment()
        );
    }
}