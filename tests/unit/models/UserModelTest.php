<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Exceptions\UserExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the User model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class UserModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing User::__constructor
     */
    public function testConstructor(): void {
        $user = new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getId()));
        $this->assertEquals(getenv("VALID_IDENTIFIER"), $user->getIdentifier(), testErrorManager::cerr_eq(getenv("VALID_IDENTIFIER"), $user->getIdentifier()));
        $this->assertEquals(getenv("VALID_NAME"), $user->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $user->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $user->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $user->getFirstname()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $user->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $user->getEmail()));
        $this->assertEquals(getenv("VALID_PASSWORD_1"), $user->getPassword(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getPassword()));
        $this->assertTrue($user->getPasswordTemp(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getPasswordTemp()));
        $this->assertEquals(getenv("VALID_DATE"), $user->getCreated(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $user->getCreated()));
        $this->assertFalse($user->getDesactivated(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getDesactivated()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getRole(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getRole()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getEstablishment()));
    }

    //// NULL PARAMETERS ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWitoutId(): void {
        $user = new User(
            null,
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertNull($user->getId(), testErrorManager::cerr_null($user->getId()));
        $this->assertEquals(getenv("VALID_IDENTIFIER"), $user->getIdentifier(), testErrorManager::cerr_eq(getenv("VALID_IDENTIFIER"), $user->getIdentifier()));
        $this->assertEquals(getenv("VALID_NAME"), $user->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $user->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $user->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $user->getFirstname()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $user->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $user->getEmail()));
        $this->assertEquals(getenv("VALID_PASSWORD_1"), $user->getPassword(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getPassword()));
        $this->assertTrue($user->getPasswordTemp(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getPasswordTemp()));
        $this->assertEquals(getenv("VALID_DATE"), $user->getCreated(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $user->getCreated()));
        $this->assertFalse($user->getDesactivated(), testErrorManager::cerr_eq(getenv("VALID_PASSWORD_1"), $user->getDesactivated()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getRole(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getRole()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getEstablishment()));
    }

    //// INVALID ID ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidId(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé primaire : {$key} est invalide.");

        new User(
            $key,
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier2(): void {
        $identifier = getenv("WRONG_IDENTIFIER_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier3(): void {
        $identifier = getenv("WRONG_IDENTIFIER_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier4(): void {
        $identifier = getenv("WRONG_IDENTIFIER_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    //// INVALID NAME ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName1(): void {
        $name = getenv("WRONG_NAME_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            $name,
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName2(): void {
        $name = getenv("WRONG_NAME_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            $name,
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName3(): void {
        $name = getenv("WRONG_NAME_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            $name,
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName4(): void {
        $name = getenv("WRONG_NAME_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            $name,
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName5(): void {
        $name = getenv("WRONG_NAME_5");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            $name,
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    //// INVALID FIRSTNAME //// 
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname1(): void {
        $firstname = getenv("WRONG_NAME_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            $firstname,
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname2(): void {
        $firstname = getenv("WRONG_NAME_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            $firstname,
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname3(): void {
        $firstname = getenv("WRONG_NAME_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            $firstname,
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname4(): void {
        $firstname = getenv("WRONG_NAME_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            $firstname,
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname5(): void {
        $firstname = getenv("WRONG_NAME_5");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            $firstname,
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    //// INVALID EMAIL //// 
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail1(): void {
        $email = getenv("WRONG_EMAIL_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail2(): void {
        $email = getenv("WRONG_EMAIL_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail3(): void {
        $email = getenv("WRONG_EMAIL_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail4(): void {
        $email = getenv("WRONG_EMAIL_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail5(): void {
        $email = getenv("WRONG_EMAIL_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail6(): void {
        $email = getenv("WRONG_EMAIL_6");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail7(): void {
        $email = getenv("WRONG_EMAIL_7");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail8(): void {
        $email = getenv("WRONG_EMAIL_8");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail9(): void {
        $email = getenv("WRONG_EMAIL_9");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail10(): void {
        $email = getenv("WRONG_EMAIL_10");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail11(): void {
        $email = getenv("WRONG_EMAIL_11");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            $email,
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    //// INVALID ROLE ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidRole1(): void {
        $role = getenv("WRONG_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé du rôle : {$role} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            $role,
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidRole2(): void {
        $role = getenv("WRONG_KEY_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé du rôle : {$role} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            $role,
            getenv("VALID_KEY_1")
        );
    }

    // INVALID ESTABLISHMENT ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEstablishment1(): void {
        $establishment = getenv("WRONG_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé de l'établissement : {$establishment} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            $establishment
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEstablishment2(): void {
        $establishment = getenv("WRONG_KEY_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé de l'établissement : {$establishment} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            $establishment
        );
    }

    // * CONVERT * //
    /**
     * Public function testing User::fromArray
     */
    public function testFromArrayWithValidData(): void {
        $data = [
            "Id"                 => getenv("VALID_KEY_1"),
            "Identifier"         => getenv("VALID_IDENTIFIER"),
            "Name"               => getenv("VALID_NAME"),
            "Firstname"          => getenv("VALID_FIRSTNAME_1"),
            "Email"              => getenv("VALID_EMAIL_1"),
            "Password"           => getenv("VALID_PASSWORD_1"),
            "PasswordTemp"       => true,
            "Created"            => getenv("VALID_DATE"),
            "Desactivated"       => false,
            "Key_Roles"          => getenv("VALID_KEY_1"),
            "Key_Establishments" => getenv("VALID_KEY_1")
        ];

        $user = User::fromArray($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getId());
        $this->assertEquals(getenv("VALID_IDENTIFIER"), $user->getIdentifier());
        $this->assertEquals(getenv("VALID_NAME"), $user->getName());
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $user->getFirstname());
        $this->assertEquals(getenv("VALID_EMAIL_1"), $user->getEmail());
        $this->assertEquals(getenv("VALID_PASSWORD_1"), $user->getPassword());
        $this->assertTrue($user->getPasswordTemp());
        $this->assertEquals(getenv("VALID_DATE"), $user->getCreated());
        $this->assertFalse($user->getDesactivated());
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getRole());
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getEstablishment());
    }

    /**
     * Public function testing User::fromArray
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");

        User::fromArray([]);
    }

    /**
     * Public function testing User::toArray
     */
    public function testToArray(): void {
        $user = new User(
            getenv("VALID_KEY_1"),
            getenv("VALID_IDENTIFIER"),
            getenv("VALID_NAME"),
            getenv("VALID_FIRSTNAME_1"),
            getenv("VALID_EMAIL_1"),
            getenv("VALID_PASSWORD_1"),
            true,
            getenv("VALID_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "identifier"    => getenv("VALID_IDENTIFIER"),
            "name"          => getenv("VALID_NAME"),
            "firstname"     => getenv("VALID_FIRSTNAME_1"),
            "email"         => getenv("VALID_EMAIL_1"),
            "password"      => getenv("VALID_PASSWORD_1"),
            "password_temp" => true,
            "created"       => getenv("VALID_DATE"),
            "desactivated"  => false,
            "role"          => getenv("VALID_KEY_1"),
            "establishment" => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $user->toArray());
    }
}
