<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Exceptions\UserExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the User model class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class UserModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing User::__constructor
     */
    public function testConstructor(): void {
        $user = new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getId()));
        $this->assertEquals(getenv("USER_1_IDENTIFIER"), $user->getIdentifier(), testErrorManager::cerr_eq(getenv("USER_1_IDENTIFIER"), $user->getIdentifier()));
        $this->assertEquals(getenv("PEOPLE_1_NAME"), $user->getName(), testErrorManager::cerr_eq(getenv("PEOPLE_1_NAME"), $user->getName()));
        $this->assertEquals(getenv("PEOPLE_1_FIRSTNAME"), $user->getFirstname(), testErrorManager::cerr_eq(getenv("PEOPLE_1_FIRSTNAME"), $user->getFirstname()));
        $this->assertEquals(getenv("PEOPLE_1_EMAIL"), $user->getEmail(), testErrorManager::cerr_eq(getenv("PEOPLE_1_EMAIL"), $user->getEmail()));
        $this->assertEquals(getenv("USER_PASSWORD_1"), $user->getPassword(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getPassword()));
        $this->assertTrue($user->getPasswordTemp(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getPasswordTemp()));
        $this->assertEquals(getenv("USER_DATE"), $user->getCreated(), testErrorManager::cerr_eq(getenv("USER_DATE"), $user->getCreated()));
        $this->assertFalse($user->getDesactivated(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getDesactivated()));
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
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(null, $user->getId(), testErrorManager::cerr_eq("vide", $user->getId() ?? "vide"));
        $this->assertEquals(getenv("USER_1_IDENTIFIER"), $user->getIdentifier(), testErrorManager::cerr_eq(getenv("USER_1_IDENTIFIER"), $user->getIdentifier()));
        $this->assertEquals(getenv("PEOPLE_1_NAME"), $user->getName(), testErrorManager::cerr_eq(getenv("PEOPLE_1_NAME"), $user->getName()));
        $this->assertEquals(getenv("PEOPLE_1_FIRSTNAME"), $user->getFirstname(), testErrorManager::cerr_eq(getenv("PEOPLE_1_FIRSTNAME"), $user->getFirstname()));
        $this->assertEquals(getenv("PEOPLE_1_EMAIL"), $user->getEmail(), testErrorManager::cerr_eq(getenv("PEOPLE_1_EMAIL"), $user->getEmail()));
        $this->assertEquals(getenv("USER_PASSWORD_1"), $user->getPassword(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getPassword()));
        $this->assertTrue($user->getPasswordTemp(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getPasswordTemp()));
        $this->assertEquals(getenv("USER_DATE"), $user->getCreated(), testErrorManager::cerr_eq(getenv("USER_DATE"), $user->getCreated()));
        $this->assertFalse($user->getDesactivated(), testErrorManager::cerr_eq(getenv("USER_PASSWORD_1"), $user->getDesactivated()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getRole(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getRole()));
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $user->getEstablishment()));
    }

    //// INVALID ID ////
    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidId(): void {
        $key = getenv("INVALID_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé primaire : {$key} est invalide.");

        new User(
            $key,
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier2(): void {
        $identifier = getenv("USER_WRONG_IDENTIFIER_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier3(): void {
        $identifier = getenv("USER_WRONG_IDENTIFIER_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidIdentifier4(): void {
        $identifier = getenv("USER_WRONG_IDENTIFIER_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'identifiant : {$identifier} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            $identifier,
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
        $name = getenv("PEOPLE_WRONG_NAME_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            $name,
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName2(): void {
        $name = getenv("PEOPLE_WRONG_NAME_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            $name,
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName3(): void {
        $name = getenv("PEOPLE_WRONG_NAME_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            $name,
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName4(): void {
        $name = getenv("PEOPLE_WRONG_NAME_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            $name,
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidName5(): void {
        $name = getenv("PEOPLE_WRONG_NAME_5");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            $name,
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
        $firstname = getenv("PEOPLE_WRONG_NAME_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            $firstname,
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname2(): void {
        $firstname = getenv("PEOPLE_WRONG_NAME_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            $firstname,
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname3(): void {
        $firstname = getenv("PEOPLE_WRONG_NAME_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            $firstname,
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname4(): void {
        $firstname = getenv("PEOPLE_WRONG_NAME_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            $firstname,
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidFirstname5(): void {
        $firstname = getenv("PEOPLE_WRONG_NAME_5");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            $firstname,
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
        $email = getenv("PEOPLE_WRONG_EMAIL_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail2(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail3(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_3");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail4(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail5(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_4");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail6(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_6");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail7(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_7");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail8(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_8");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail9(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_9");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail10(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_10");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEmail11(): void {
        $email = getenv("PEOPLE_WRONG_EMAIL_11");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            $email,
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
        $role = getenv("INVALID_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé du rôle : {$role} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            $role,
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidRole2(): void {
        $role = getenv("INVALID_KEY_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé du rôle : {$role} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
        $establishment = getenv("INVALID_KEY_1");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé de l'établissement : {$establishment} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            $establishment
        );
    }

    /**
     * Public function testing User::__constructor
     */
    public function testConstructorWithInvalidEstablishment2(): void {
        $establishment = getenv("INVALID_KEY_2");
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("La clé de l'établissement : {$establishment} est invalide.");

        new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
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
            "Identifier"         => getenv("USER_1_IDENTIFIER"),
            "Name"               => getenv("PEOPLE_1_NAME"),
            "Firstname"          => getenv("PEOPLE_1_FIRSTNAME"),
            "Email"              => getenv("PEOPLE_1_EMAIL"),
            "Password"           => getenv("USER_PASSWORD_1"),
            "PasswordTemp"       => true,
            "Created"            => getenv("USER_DATE"),
            "Desactivated"       => false,
            "Key_Roles"          => getenv("VALID_KEY_1"),
            "Key_Establishments" => getenv("VALID_KEY_1")
        ];

        $user = User::fromArray($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getId());
        $this->assertEquals(getenv("USER_1_IDENTIFIER"), $user->getIdentifier());
        $this->assertEquals(getenv("PEOPLE_1_NAME"), $user->getName());
        $this->assertEquals(getenv("PEOPLE_1_FIRSTNAME"), $user->getFirstname());
        $this->assertEquals(getenv("PEOPLE_1_EMAIL"), $user->getEmail());
        $this->assertEquals(getenv("USER_PASSWORD_1"), $user->getPassword());
        $this->assertTrue($user->getPasswordTemp());
        $this->assertEquals(getenv("USER_DATE"), $user->getCreated());
        $this->assertFalse($user->getDesactivated());
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getRole());
        $this->assertEquals(getenv("VALID_KEY_1"), $user->getEstablishment());
    }

    /**
     * Test the fromArray method with empty data
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(UserExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");

        User::fromArray([]);
    }

    /**
     * Test the toArray method
     */
    public function testToArray(): void {
        $user = new User(
            getenv("VALID_KEY_1"),
            getenv("USER_1_IDENTIFIER"),
            getenv("PEOPLE_1_NAME"),
            getenv("PEOPLE_1_FIRSTNAME"),
            getenv("PEOPLE_1_EMAIL"),
            getenv("USER_PASSWORD_1"),
            true,
            getenv("USER_DATE"),
            false,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "identifier"    => getenv("USER_1_IDENTIFIER"),
            "name"          => getenv("PEOPLE_1_NAME"),
            "firstname"     => getenv("PEOPLE_1_FIRSTNAME"),
            "email"         => getenv("PEOPLE_1_EMAIL"),
            "password"      => getenv("USER_PASSWORD_1"),
            "password_temp" => true,
            "created"       => getenv("USER_DATE"),
            "desactivated"  => false,
            "role"          => getenv("VALID_KEY_1"),
            "establishment" => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $user->toArray());
    }
}
