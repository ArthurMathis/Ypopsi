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
     * Test the constructor with valid data
     */
    public function testConstructorWithValidData() {
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

    /**
     * Test the constructor with invalid id
     */
    public function testConstructorWithInvalidId() {
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
// 
    // /**
    //  * Test the constructor with invalid identifier
    //  */
    // public function testConstructorWithInvalidIdentifier() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("L'identifiant : invalid_identifier est invalide.");
// 
    //     new User(
    //         1,
    //         'invalid_identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
    // }
// 
    // /**
    //  * Test the constructor with invalid name
    //  */
    // public function testConstructorWithInvalidName() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le nom : InvalidName est invalide.");
// 
    //     new User(
    //         1,
    //         'identifier',
    //         'InvalidName',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
    // }
// 
    // /**
    //  * Test the constructor with invalid firstname
    //  */
    // public function testConstructorWithInvalidFirstname() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le prénom : InvalidFirstname est invalide.");
// 
    //     new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'InvalidFirstname',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
    // }
// 
    // /**
    //  * Test the constructor with invalid email
    //  */
    // public function testConstructorWithInvalidEmail() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("L'email : invalid_email est invalide.");
// 
    //     new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'invalid_email',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
    // }
// 
    // /**
    //  * Test the constructor with invalid role
    //  */
    // public function testConstructorWithInvalidRole() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("La clé du rôle : 0 est invalide.");
// 
    //     new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         0,
    //         1
    //     );
    // }
// 
    // /**
    //  * Test the constructor with invalid establishment
    //  */
    // public function testConstructorWithInvalidEstablishment() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("La clé de l'établissement : 0 est invalide.");
// 
    //     new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         0
    //     );
    // }
// 
    // /**
    //  * Test the setName method with valid name
    //  */
    // public function testSetNameWithValidName() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setName('NewName');
    //     $this->assertEquals('Newname', $user->getName());
    // }
// 
    // /**
    //  * Test the setName method with invalid name
    //  */
    // public function testSetNameWithInvalidName() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le nom de l'utilisateur est invalide : InvalidName.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setName('InvalidName');
    // }
// 
    // /**
    //  * Test the setFirstname method with valid firstname
    //  */
    // public function testSetFirstnameWithValidFirstname() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setFirstname('NewFirstname');
    //     $this->assertEquals('Newfirstname', $user->getFirstname());
    // }
// 
    // /**
    //  * Test the setFirstname method with invalid firstname
    //  */
    // public function testSetFirstnameWithInvalidFirstname() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le prénom de l'utilisateur est invalide : InvalidFirstname.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setFirstname('InvalidFirstname');
    // }
// 
    // /**
    //  * Test the setEmail method with valid email
    //  */
    // public function testSetEmailWithValidEmail() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setEmail('new.email@example.com');
    //     $this->assertEquals('new.email@example.com', $user->getEmail());
    // }
// 
    // /**
    //  * Test the setEmail method with invalid email
    //  */
    // public function testSetEmailWithInvalidEmail() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("L'adresse email de l'utilisateur est invalide : invalid_email.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setEmail('invalid_email');
    // }
// 
    // /**
    //  * Test the setPassword method with valid password
    //  */
    // public function testSetPasswordWithValidPassword() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setPassword('newPassword123');
    //     $this->assertEquals('newPassword123', $user->getPassword());
    // }
// 
    // /**
    //  * Test the setPassword method with invalid password
    //  */
    // public function testSetPasswordWithInvalidPassword() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le mot de passe de l'utilisateur est invalide : invalid_password.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setPassword('invalid_password');
    // }
// 
    // /**
    //  * Test the setRole method with valid role
    //  */
    // public function testSetRoleWithValidRole() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setRole(2);
    //     $this->assertEquals(2, $user->getRole());
    // }
// 
    // /**
    //  * Test the setRole method with invalid role
    //  */
    // public function testSetRoleWithInvalidRole() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Le role de l'utilisateur est invalide : 0.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setRole(0);
    // }
// 
    // /**
    //  * Test the setEstablishment method with valid establishment
    //  */
    // public function testSetEstablishmentWithValidEstablishment() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setEstablishment(2);
    //     $this->assertEquals(2, $user->getEstablishment());
    // }
// 
    // /**
    //  * Test the setEstablishment method with invalid establishment
    //  */
    // public function testSetEstablishmentWithInvalidEstablishment() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("L'établissement de l'utilisateur est invalide : 0.");
// 
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $user->setEstablishment(0);
    // }
// 
    // /**
    //  * Test the fromArray method with valid data
    //  */
    // public function testFromArrayWithValidData() {
    //     $data = [
    //         'Id' => 1,
    //         'Identifier' => 'identifier',
    //         'Name' => 'Dupond',
    //         'Firstname' => 'Jean',
    //         'Email' => 'jean.dupond@example.com',
    //         'Password' => 'password123',
    //         'PasswordTemp' => true,
    //         'Created' => '2023-01-01',
    //         'Desactivated' => false,
    //         'Key_Roles' => 1,
    //         'Key_Establishments' => 1
    //     ];
// 
    //     $user = User::fromArray($data);
// 
    //     $this->assertInstanceOf(User::class, $user);
    //     $this->assertEquals(1, $user->getId());
    //     $this->assertEquals('identifier', $user->getIdentifier());
    //     $this->assertEquals('Dupond', $user->getName());
    //     $this->assertEquals('Jean', $user->getFirstname());
    //     $this->assertEquals('jean.dupond@example.com', $user->getEmail());
    //     $this->assertEquals('password123', $user->getPassword());
    //     $this->assertTrue($user->getPasswordTemp());
    //     $this->assertEquals('2023-01-01', $user->getCreated());
    //     $this->assertFalse($user->getDesactivated());
    //     $this->assertEquals(1, $user->getRole());
    //     $this->assertEquals(1, $user->getEstablishment());
    // }
// 
    // /**
    //  * Test the fromArray method with empty data
    //  */
    // public function testFromArrayWithEmptyData() {
    //     $this->expectException(UserExceptions::class);
    //     $this->expectExceptionMessage("Erreur lors de la génération de l'utilisateur. Tableau de données absent.");
// 
    //     User::fromArray([]);
    // }
// 
    // /**
    //  * Test the toArray method
    //  */
    // public function testToArray() {
    //     $user = new User(
    //         1,
    //         'identifier',
    //         'Dupond',
    //         'Jean',
    //         'jean.dupond@example.com',
    //         'password123',
    //         true,
    //         '2023-01-01',
    //         false,
    //         1,
    //         1
    //     );
// 
    //     $expectedArray = [
    //         'id' => 1,
    //         'identifier' => 'identifier',
    //         'name' => 'Dupond',
    //         'firstname' => 'Jean',
    //         'email' => 'jean.dupond@example.com',
    //         'password' => 'password123',
    //         'password_temp' => true,
    //         'created' => '2023-01-01',
    //         'desactivated' => false,
    //         'role' => 1,
    //         'establishment' => 1
    //     ];
// 
    //     $this->assertEquals($expectedArray, $user->toArray());
    // }
}
