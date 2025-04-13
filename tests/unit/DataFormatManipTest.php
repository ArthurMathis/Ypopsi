<?php

use PHPUnit\Framework\TestCase;
use App\Core\Tools\DataFormatManip;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the DatFormatManip class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class DataFormatManipTest extends TestCase {
    // * IS VALID * //
    /**
     * Public function testing DataFormatManip::isValidKey
     */
    public function testIsValidKey() {
        // True
        $this->assertTrue(DataFormatManip::isValidKey(getenv("VALID_KEY_1")), testErrorManager::cerr(getenv("VALID_KEY_1"), true));
        $this->assertTrue(DataFormatManip::isValidKey(getenv("VALID_KEY_2")), testErrorManager::cerr(getenv("VALID_KEY_2"), true));
        $this->assertTrue(DataFormatManip::isValidKey(getenv("VALID_KEY_3")), testErrorManager::cerr(getenv("VALID_KEY_3"), true));

        // False
        $this->assertFalse(DataFormatManip::isValidKey(getenv("INVALID_KEY_1")), testErrorManager::cerr(getenv("INVALID_KEY_1"), false));
        $this->assertFalse(DataFormatManip::isValidKey(getenv("INVALID_KEY_2")), testErrorManager::cerr(getenv("INVALID_KEY_2"), false));
    }

    /**
     * Public function testing DataFormatManip::isValidIdentifier
     */
    public function testIsValidIdentifier() {
        // True
        $this->assertTrue(DataFormatManip::isValidIdentifier(getenv("USER_1_IDENTIFIER")), testErrorManager::cerr(getenv("USER_1_IDENTIFIER"), true));

        // False
        $this->assertFalse(DataFormatManip::isValidIdentifier(getenv("USER_WRONG_IDENTIFIER_1")), testErrorManager::cerr(getenv("USER_WRONG_IDENTIFIER_1"), false));
        $this->assertFalse(DataFormatManip::isValidIdentifier(getenv("USER_WRONG_IDENTIFIER_2")), testErrorManager::cerr(getenv("USER_WRONG_IDENTIFIER_1"), false));
        $this->assertFalse(DataFormatManip::isValidIdentifier(getenv("USER_WRONG_IDENTIFIER_3")), testErrorManager::cerr(getenv("USER_WRONG_IDENTIFIER_1"), false));
        $this->assertFalse(DataFormatManip::isValidIdentifier(getenv("USER_WRONG_IDENTIFIER_4")), testErrorManager::cerr(getenv("USER_WRONG_IDENTIFIER_1"), false));
    }

    /**
     * Public function testing DataFormatManip::isValidName
     */
    public function testIsValidName() {
        // True
        $this->assertTrue(DataFormatManip::isValidName(getenv("PEOPLE_1_FIRSTNAME")), testErrorManager::cerr(getenv("PEOPLE_1_FIRSTNAME"), true));
        $this->assertTrue(DataFormatManip::isValidName(getenv("PEOPLE_2_FIRSTNAME")), testErrorManager::cerr(getenv("PEOPLE_2_FIRSTNAME"), true));
        $this->assertTrue(DataFormatManip::isValidName(getenv("PEOPLE_1_NAME")), testErrorManager::cerr(getenv("PEOPLE_1_NAME"), true));

        // False
        $this->assertFalse(DataFormatManip::isValidName(getenv("PEOPLE_WRONG_NAME_1")), testErrorManager::cerr(getenv("PEOPLE_WRONG_NAME_1"), false));
        $this->assertFalse(DataFormatManip::isValidName(getenv("PEOPLE_WRONG_NAME_2")), testErrorManager::cerr(getenv("PEOPLE_WRONG_NAME_2"), false));
        $this->assertFalse(DataFormatManip::isValidName(getenv("PEOPLE_WRONG_NAME_3")), testErrorManager::cerr(getenv("PEOPLE_WRONG_NAME_3"), false));
        $this->assertFalse(DataFormatManip::isValidName(getenv("PEOPLE_WRONG_NAME_4")), testErrorManager::cerr(getenv("PEOPLE_WRONG_NAME_4"), false));
        $this->assertFalse(DataFormatManip::isValidName(getenv("PEOPLE_WRONG_NAME_5")), testErrorManager::cerr(getenv("PEOPLE_WRONG_NAME_5"), false));
    }

    /**
     * Public function testing DataFormatManip::isValidEmail
     */
    public function testIsValidEmail() {
        // True
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_1_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_1_EMAIL"), true));
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_2_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_2_EMAIL"), true));
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_3_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_3_EMAIL"), true));
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_4_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_4_EMAIL"), true));
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_5_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_5_EMAIL"), true));
        $this->assertTrue(DataFormatManip::isValidEmail(getenv("PEOPLE_6_EMAIL")), testErrorManager::cerr(getenv("PEOPLE_6_EMAIL"), true));

        // False
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_1")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_1"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_2")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_2"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_3")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_3"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_4")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_4"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_5")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_5"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_6")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_6"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_7")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_7"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_8")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_8"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_9")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_9"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_10")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_10"), false));
        $this->assertFalse(DataFormatManip::isValidEmail(getenv("PEOPLE_WRONG_EMAIL_11")), testErrorManager::cerr(getenv("PEOPLE_WRONG_EMAIL_11"), false));
    }

    /**
     * Public function testing DataFormatManip::isValidPhoneNumber
     */
    public function testIsValidPhoneNumber() {
        // True
        $this->assertTrue(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_1_PHONE")), testErrorManager::cerr(getenv("CANDIDATE_1_PHONE"), true));

        // False
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_1")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_1"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_2")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_2"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_3")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_3"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_4")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_4"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_5")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_5"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_6")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_6"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_7")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_7"), false));
        $this->assertFalse(DataFormatManip::isValidPhoneNumber(getenv("CANDIDATE_WRONG_PHONE_8")), testErrorManager::cerr(getenv("CANDIDATE_WRONG_PHONE_8"), false));
    }

    /**
     * Public function testing DataFormatManip::isValidPostCode
     */
    public function testIsValidPostCode() {
        // True
        $this->assertTrue(DataFormatManip::isValidPostCode(getenv("CANDIADTE_1_POSTCODE"), testErrorManager::cerr(getenv("CANDIADTE_1_POSTCODE"), true)));

        // False
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_1"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_1"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_2"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_2"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_3"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_3"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_4"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_4"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_5"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_5"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_6"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_6"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_7"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_7"), false)));
        $this->assertFalse(DataFormatManip::isValidPostCode(getenv("CANDIDATE_WRONG_POSTCODE_8"), testErrorManager::cerr(getenv("CANDIDATE_WRONG_POSTCODE_8"), false)));
    }

    // * FORMAT * //
    /**
     * Public function testing DataFormatManip::nameFormat
     */
    public function testNameFormat() {
        $str = 'john doe';
        $this->assertEquals('John Doe', DataFormatManip::nameFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('Jane Doe', DataFormatManip::nameFormat($str));
    }

    /**
     * Public function testing DataFormatManip::majusculeFormat
     */
    public function testMajusculeFormat() {
        $str = 'john doe';
        $this->assertEquals('JOHN DOE', DataFormatManip::majusculeFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('JANE DOE', DataFormatManip::majusculeFormat($str));
    }

    /**
     * Public function testing DataFormatManip::phoneNumberFormat
     */
    public function testPhoneNumberFormat() {
        $number = '1234567890';
        $this->assertEquals('12.34.56.78.90', DataFormatManip::phoneNumberFormat($number));

        $number = '12345';
        $this->expectException(InvalidArgumentException::class);
        DataFormatManip::phoneNumberFormat($number);
    }
}
