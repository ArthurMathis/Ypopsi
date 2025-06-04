<?php

use PHPUnit\Framework\TestCase;
use App\Core\Tools\PasswordManager;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the PasswordManager class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class PasswordManagerTest extends TestCase {
    /**
     * Public function testing PasswordManagerTest::isValidPassword
     */
    public function testIsValidPassword() {
        // True
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_1")), testErrorManager::cerr(getenv("VALID_PASSWORD_1"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_2")), testErrorManager::cerr(getenv("VALID_PASSWORD_2"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_3")), testErrorManager::cerr(getenv("VALID_PASSWORD_3"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_4")), testErrorManager::cerr(getenv("VALID_PASSWORD_4"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_5")), testErrorManager::cerr(getenv("VALID_PASSWORD_5"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_6")), testErrorManager::cerr(getenv("VALID_PASSWORD_6"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_7")), testErrorManager::cerr(getenv("VALID_PASSWORD_7"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_8")), testErrorManager::cerr(getenv("VALID_PASSWORD_8"), true));
        $this->assertTrue(PasswordManager::isValidPassword(getenv("VALID_PASSWORD_9")), testErrorManager::cerr(getenv("VALID_PASSWORD_9"), true));

        // // False
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_1")), testErrorManager::cerr(getenv("WRONG_PASSWORD_1"), true));
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_2")), testErrorManager::cerr(getenv("WRONG_PASSWORD_2"), true));
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_3")), testErrorManager::cerr(getenv("WRONG_PASSWORD_3"), true));
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_4")), testErrorManager::cerr(getenv("WRONG_PASSWORD_4"), true));
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_5")), testErrorManager::cerr(getenv("WRONG_PASSWORD_5"), true));
        $this->assertFalse(PasswordManager::isValidPassword(getenv("WRONG_PASSWORD_6")), testErrorManager::cerr(getenv("WRONG_PASSWORD_6"), true));
    }

    /**
     * Public function testing PasswordManagerTest::random_password
     */
    public function testRandomPassword() {
        $password = PasswordManager::random_password();

        $this->assertTrue(PasswordManager::isValidPassword($password), "Le mot de passe : '{$password}'ne respecte pas les normes de sécurité.");
        $this->assertEquals(12, strlen($password), "Le mot de passe : {$password} ne mesure pas 12 caractères.");
        $this->assertMatchesRegularExpression('/[A-Z]/', $password, "Le mot de passe : {$password} ne contient pas au moins une majuscule.");
        $this->assertMatchesRegularExpression('/[a-z]/', $password, "Le mot de passe : {$password} ne contient pas au moins une minuscule.");
        $this->assertMatchesRegularExpression('/\d/', $password, "Le mot de passe : {$password} ne contient pas au moins un chiffre.");
        $this->assertMatchesRegularExpression('/[(){}[\]&#_@+!*?:;,.<>-]/', $password, "Le mot de passe : {$password} ne contient pas au moins un caractère spécial.");
    }
}
