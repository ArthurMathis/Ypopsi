<?php

use PHPUnit\Framework\TestCase;
use App\Core\Tools\DataFormatManager;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the DataFormatManager class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class DataFormatManagerTest extends TestCase {
    // * IS VALID * //
    /**
     * Public function testing DataFormatManager::isValidKey
     */
    public function testIsValidKey() {
        // True
        $this->assertTrue(DataFormatManager::isValidKey(getenv("VALID_KEY_1")), testErrorManager::cerr(getenv("VALID_KEY_1"), true));
        $this->assertTrue(DataFormatManager::isValidKey(getenv("VALID_KEY_2")), testErrorManager::cerr(getenv("VALID_KEY_2"), true));
        $this->assertTrue(DataFormatManager::isValidKey(getenv("VALID_KEY_3")), testErrorManager::cerr(getenv("VALID_KEY_3"), true));

        // False
        $this->assertFalse(DataFormatManager::isValidKey(getenv("WRONG_KEY_1")), testErrorManager::cerr(getenv("WRONG_KEY_1"), false));
        $this->assertFalse(DataFormatManager::isValidKey(getenv("WRONG_KEY_2")), testErrorManager::cerr(getenv("WRONG_KEY_2"), false));
    }

    /**
     * Public function testing DataFormatManager::isValidIdentifier
     */
    public function testIsValidIdentifier() {
        // True
        $identifier = getenv("VALID_IDENTIFIER");
        $this->assertTrue(DataFormatManager::isValidIdentifier($identifier), testErrorManager::cerr($identifier, true));

        // False
        $false_identifier_1 = getenv("WRONG_IDENTIFIER_1");
        $false_identifier_2 = getenv("WRONG_IDENTIFIER_2");
        $false_identifier_3 = getenv("WRONG_IDENTIFIER_3");
        $false_identifier_4 = getenv("WRONG_IDENTIFIER_4");
        $this->assertFalse(DataFormatManager::isValidIdentifier($false_identifier_1), testErrorManager::cerr($false_identifier_1, false));
        $this->assertFalse(DataFormatManager::isValidIdentifier($false_identifier_2), testErrorManager::cerr($false_identifier_2, false));
        $this->assertFalse(DataFormatManager::isValidIdentifier($false_identifier_3), testErrorManager::cerr($false_identifier_3, false));
        $this->assertFalse(DataFormatManager::isValidIdentifier($false_identifier_4), testErrorManager::cerr($false_identifier_4, false));
    }

    /**
     * Public function testing DataFormatManager::isValidName
     */
    public function testIsValidName() {
        // True
        $name_1 = getenv("VALID_FIRSTNAME_1");
        $name_2 = getenv("VALID_FIRSTNAME_2");
        $name_3 = getenv("VALID_NAME");
        $name_4 = getenv("VALID_NAME_2");
        $this->assertTrue(DataFormatManager::isValidName($name_1), testErrorManager::cerr($name_1, true));
        $this->assertTrue(DataFormatManager::isValidName($name_2), testErrorManager::cerr($name_2, true));
        $this->assertTrue(DataFormatManager::isValidName($name_3), testErrorManager::cerr($name_3, true));
        $this->assertTrue(DataFormatManager::isValidName($name_4), testErrorManager::cerr($name_4, true));

        // False
        $false_name_1 = getenv("WRONG_NAME_1");
        $false_name_2 = getenv("WRONG_NAME_2");
        $false_name_3 = getenv("WRONG_NAME_3");
        $false_name_4 = getenv("WRONG_NAME_4");
        $false_name_5 = getenv("WRONG_NAME_5");
        $this->assertFalse(DataFormatManager::isValidName($false_name_1), testErrorManager::cerr($false_name_1, false));
        $this->assertFalse(DataFormatManager::isValidName($false_name_2), testErrorManager::cerr($false_name_2, false));
        $this->assertFalse(DataFormatManager::isValidName($false_name_3), testErrorManager::cerr($false_name_3, false));
        $this->assertFalse(DataFormatManager::isValidName($false_name_4), testErrorManager::cerr($false_name_4, false));
        $this->assertFalse(DataFormatManager::isValidName($false_name_5), testErrorManager::cerr($false_name_5, false));
    }

    /**
     * Public function testing DataFormatManager::isValidEmail
     */
    public function testIsValidEmail() {
        // True
        $email_1 = getenv("VALID_EMAIL_1");
        $email_2 = getenv("VALID_EMAIL_2");
        $email_3 = getenv("VALID_EMAIL_3");
        $email_4 = getenv("VALID_EMAIL_4");
        $email_5 = getenv("VALID_EMAIL_5");
        $email_6 = getenv("VALID_EMAIL_6");
        $this->assertTrue(DataFormatManager::isValidEmail($email_1), testErrorManager::cerr($email_1, true));
        $this->assertTrue(DataFormatManager::isValidEmail($email_2), testErrorManager::cerr($email_2, true));
        $this->assertTrue(DataFormatManager::isValidEmail($email_3), testErrorManager::cerr($email_3, true));
        $this->assertTrue(DataFormatManager::isValidEmail($email_4), testErrorManager::cerr($email_4, true));
        $this->assertTrue(DataFormatManager::isValidEmail($email_5), testErrorManager::cerr($email_5, true));
        $this->assertTrue(DataFormatManager::isValidEmail($email_6), testErrorManager::cerr($email_6, true));

        // False
        $false_email_1 = getenv("WRONG_EMAIL_1");
        $false_email_2 = getenv("WRONG_EMAIL_2");
        $false_email_3 = getenv("WRONG_EMAIL_3");
        $false_email_4 = getenv("WRONG_EMAIL_4");
        $false_email_5 = getenv("WRONG_EMAIL_5");
        $false_email_6 = getenv("WRONG_EMAIL_6");
        $false_email_7 = getenv("WRONG_EMAIL_7");
        $false_email_8 = getenv("WRONG_EMAIL_8");
        $false_email_9 = getenv("WRONG_EMAIL_9");
        $false_email_10 = getenv("WRONG_EMAIL_10");
        $false_email_11 = getenv("WRONG_EMAIL_11");
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_1), testErrorManager::cerr($false_email_1, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_2), testErrorManager::cerr($false_email_2, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_3), testErrorManager::cerr($false_email_3, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_4), testErrorManager::cerr($false_email_4, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_5), testErrorManager::cerr($false_email_5, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_6), testErrorManager::cerr($false_email_6, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_7), testErrorManager::cerr($false_email_7, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_8), testErrorManager::cerr($false_email_8, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_9), testErrorManager::cerr($false_email_9, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_10), testErrorManager::cerr($false_email_10, false));
        $this->assertFalse(DataFormatManager::isValidEmail($false_email_11), testErrorManager::cerr($false_email_11, false));
    }

    /**
     * Public function testing DataFormatManager::isValidPhoneNumber
     */
    public function testIsValidPhoneNumber() {
        // True
        $ph_nb = getenv("VALID_PHONE");
        $this->assertTrue(DataFormatManager::isValidPhoneNumber($ph_nb), testErrorManager::cerr($ph_nb, true));

        // False
        $false_ph_nb_1 = getenv("WRONG_PHONE_1");
        $false_ph_nb_2 = getenv("WRONG_PHONE_2");
        $false_ph_nb_3 = getenv("WRONG_PHONE_3");
        $false_ph_nb_4 = getenv("WRONG_PHONE_4");
        $false_ph_nb_5 = getenv("WRONG_PHONE_5");
        $false_ph_nb_6 = getenv("WRONG_PHONE_6");
        $false_ph_nb_7 = getenv("WRONG_PHONE_7");
        $false_ph_nb_8 = getenv("WRONG_PHONE_8");
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_1), testErrorManager::cerr($false_ph_nb_1, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_2), testErrorManager::cerr($false_ph_nb_2, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_3), testErrorManager::cerr($false_ph_nb_3, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_4), testErrorManager::cerr($false_ph_nb_4, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_5), testErrorManager::cerr($false_ph_nb_5, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_6), testErrorManager::cerr($false_ph_nb_6, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_7), testErrorManager::cerr($false_ph_nb_7, false));
        $this->assertFalse(DataFormatManager::isValidPhoneNumber($false_ph_nb_8), testErrorManager::cerr($false_ph_nb_8, false));
    }

    /**
     * Public function testing DataFormatManager::isValidPostCode
     */
    public function testIsValidPostCode() {
        // True
        $postcode = getenv("VALID_POSTCODE");
        $this->assertTrue(DataFormatManager::isValidPostCode($postcode), testErrorManager::cerr($postcode, true));

        // False
        $false_postcode_1 = getenv("WRONG_POSTCODE_1");
        $false_postcode_2 = getenv("WRONG_POSTCODE_2");
        $false_postcode_3 = getenv("WRONG_POSTCODE_3");
        $false_postcode_4 = getenv("WRONG_POSTCODE_4");
        $false_postcode_5 = getenv("WRONG_POSTCODE_5");
        $false_postcode_6 = getenv("WRONG_POSTCODE_6");
        $false_postcode_7 = getenv("WRONG_POSTCODE_7");
        $false_postcode_8 = getenv("WRONG_POSTCODE_8");
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_1), testErrorManager::cerr($false_postcode_1, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_2), testErrorManager::cerr($false_postcode_2, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_3), testErrorManager::cerr($false_postcode_3, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_4), testErrorManager::cerr($false_postcode_4, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_5), testErrorManager::cerr($false_postcode_5, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_6), testErrorManager::cerr($false_postcode_6, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_7), testErrorManager::cerr($false_postcode_7, false));
        $this->assertFalse(DataFormatManager::isValidPostCode($false_postcode_8), testErrorManager::cerr($false_postcode_8, false));
    }

    // * FORMAT * //
    /**
     * Public function testing DataFormatManager::nameFormat
     */
    public function testNameFormat() {
        $str = 'john doe';
        $this->assertEquals('John Doe', DataFormatManager::nameFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('Jane Doe', DataFormatManager::nameFormat($str));
    }

    /**
     * Public function testing DataFormatManager::majusculeFormat
     */
    public function testMajusculeFormat() {
        $str = 'john doe';
        $this->assertEquals('JOHN DOE', DataFormatManager::majusculeFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('JANE DOE', DataFormatManager::majusculeFormat($str));
    }

    /**
     * Public function testing DataFormatManager::phoneNumberFormat
     */
    public function testPhoneNumberFormat() {
        $number = '1234567890';
        $this->assertEquals('12.34.56.78.90', DataFormatManager::phoneNumberFormat($number));

        $number = '12345';
        $this->expectException(InvalidArgumentException::class);
        DataFormatManager::phoneNumberFormat($number);
    }
}
