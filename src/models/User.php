<?php 

namespace App\Models;

use App\Models\PeopleInterface;
use App\Core\Tools\DataFormatManip;
use App\Core\Tools\PasswordsManip;
use App\Exceptions\UserExceptions;

/**
 * Class representing one user
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class User implements PeopleInterface {
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
        protected string $created,
        protected bool $desactivated,
        protected int $role, 
        protected int $establishment
    ) {
        // The primary key
        if(!is_null($id) && !DataFormatManip::isValidKey($id)) {
            throw new UserExceptions("La clé primaire : {$id} est invalide.");
        }

        // The identifier 
        if(!DataFormatManip::isValidIdentifier($identifier)) {
            throw new UserExceptions("L'identifiant : {$identifier} est invalide.");
        } 

        // name 
        if(!DataFormatManip::isValidName($name)) {
            throw new UserExceptions("Le nom : {$name} est invalide.");
        }

        // firstname
        if(!DataFormatManip::isValidName($firstname)) {
            throw new UserExceptions("Le prénom : {$firstname} est invalide.");
        }

        // email 
        if(!DataFormatManip::isValidEmail($email)) {
            throw new UserExceptions("L'email : {$email} est invalide.");
        }

        // role
        if(!DataFormatManip::isValidKey($role)) {
            throw new UserExceptions("La clé du rôle : {$role} est invalide.");
        }

        // establishment
        if(!DataFormatManip::isValidKey($establishment)) {
            throw new UserExceptions("La clé due l'établissement : {$establishment} est invalide.");
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
     * Public method erturning the complete candidate's name 
     *
     * @return string
     */
    public function getCompleteName(): string {
        $response = strtoupper($this->getname()) . " " . $this->getFirstname();
        return $response;
    }
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
     * Public method returning when the user's account has be opened
     *
     * @return string
     */
    public function getCreated(): string { return $this->created; }
    /**
     * Public method returning if the user's account s activated or not
     *
     * @return boolean
     */
    public function getDesactivated(): bool { return $this->desactivated; }
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

    // * SET * //
    /**
     * Public method setting the user's name
     *
     * @param string $name The user's name
     * @throws UserExceptions If the name is invalid
     * @return void
     */
    public function setName(string $name): void { 
        $name = DataFormatManip::nameFormat($name);
        if(!DataFormatManip::isValidName($name)) {
            throw new UserExceptions("Le nom de l'utilisateur est invalide : {$name}.");
        }

        $this->name = $name;
    }
    /**
     * Public method setting the user's firstname
     *
     * @param string $firstname The user's firstname
     * @throws UserExceptions If the firstname is invalid
     * @return void
     */
    public function setFirstname(string $firstname): void {
        $firstname = DataFormatManip::nameFormat($firstname);
        if(!DataFormatManip::isValidName($firstname)) {
            throw new UserExceptions("Le prénom de l'utilisateur est invalide : {$firstname}.");
        }
        $this->firstname = $firstname; 
    }
    /**
     * Public method setting the user's email
     *
     * @param string $email The user's email
     * @throws UserExceptions If the email is invalid
     * @return void
     */
    public function setEmail(string $email): void {
        if(!DataFormatManip::isValidEmail($email)) {
            throw new UserExceptions("L'adresse email de l'utilisateur est invalide : {$email}.");
        }
        
        $this->email = $email; 
    }
    /**
     * Public method setting the user's password
     *
     * @param string $password The user's password
     * @throws UserExceptions If the password is invalid
     * @return void
     */
    public function setPassword(string $password): void {
        if(!PasswordsManip::isValidPassword($password)) {
            throw new UserExceptions("Le mot de passe de l'utilisateur est invalide : {$password}.");
        }

        $this->password = $password; 
    }
    /**
     * Public method setting the user's password
     *
     * @param int $password The user's password
     * @throws UserExceptions If the password is invalid
     * @return void
     */
    public function setRole(int $role): void {
        if(!DataFormatManip::isValidKey($role)) {
            throw new UserExceptions("Le role de l'utilisateur est invalide : {$role}.");
        }

        $this->role = $role; 
    }
    /**
     * Public method setting the user's establishment
     *
     * @param int $establishment The user's establishment
     * @throws UserExceptions If the establishment is invalid
     * @return void
     */
    public function setEstablishment(int $establishment): void { 
        if(!DataFormatManip::isValidKey($establishment)) {
            throw new UserExceptions("L'établissement de l'utilisateur est invalide : {$establishment}.");
        }
        
        $this->establishment = $establishment; 
    }

    public function setPasswordTemp(bool $state): void { $this->password_temp = $state; }
    
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
            $data['Created'], 
            $data['Desactivated'],
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
            'created'        => $this->getCreated(),
            'desactivated'   => $this->getDesactivated(),
            'role'           => $this->getRole(),
            'establishement' => $this->getEstablishment()
        );
    }
}