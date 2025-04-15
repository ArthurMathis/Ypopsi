<?php

use PHPUnit\Framework\TestCase;
use App\Core\Tools\PasswordsManip;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the PasswordsManip class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class PasswordsManipTest extends TestCase {
    /**
     * Public function testing PasswordsManipTest::isValidPassword
     */
    public function testIsValidPassword() {
        // True
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_1")), testErrorManager::cerr(getenv("USER_PASSWORD_1"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_2")), testErrorManager::cerr(getenv("USER_PASSWORD_2"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_3")), testErrorManager::cerr(getenv("USER_PASSWORD_3"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_4")), testErrorManager::cerr(getenv("USER_PASSWORD_4"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_5")), testErrorManager::cerr(getenv("USER_PASSWORD_5"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_6")), testErrorManager::cerr(getenv("USER_PASSWORD_6"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_7")), testErrorManager::cerr(getenv("USER_PASSWORD_7"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_8")), testErrorManager::cerr(getenv("USER_PASSWORD_8"), true));
        $this->assertTrue(PasswordsManip::isValidPassword(getenv("USER_PASSWORD_9")), testErrorManager::cerr(getenv("USER_PASSWORD_9"), true));

        // False
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_1")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_1"), true));
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_2")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_2"), true));
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_3")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_3"), true));
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_4")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_4"), true));
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_5")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_5"), true));
        $this->assertFalse(PasswordsManip::isValidPassword(getenv("USER_WRONG_PASSWORD_6")), testErrorManager::cerr(getenv("USER_WRONG_PASSWORD_6"), true));
    }

    /**
     * Public function testing PasswordsManipTest::random_password
     */
    public function testRandomPassword() {
        $password = PasswordsManip::random_password();

        $this->assertTrue(PasswordsManip::isValidPassword($password), "Failed asserting that the generated password '{$password}' is valid.");
        $this->assertEquals(12, strlen($password), "Failed asserting that the generated password has a length of 12.");
        $this->assertMatchesRegularExpression('/[A-Z]/', $password, "Failed asserting that the generated password contains an uppercase letter.");
        $this->assertMatchesRegularExpression('/[a-z]/', $password, "Failed asserting that the generated password contains a lowercase letter.");
        $this->assertMatchesRegularExpression('/\d/', $password, "Failed asserting that the generated password contains a number.");
        $this->assertMatchesRegularExpression('/[(){}[\]&#_@+!*?:;,.<>-]/', $password, "Failed asserting that the generated password contains a special character.");
    }
}
