<?php

use PHPUnit\Framework\TestCase;
use App\Core\Tools\DataFormatManip;

/**
 * Suite case for the DatFormatManip class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class DataFormatManipTest extends TestCase {
    /**
     * Pubmlic function testing DataFormatManip::isValidKey
     */
    public function testIsValidKey() {
        $this->assertTrue(DataFormatManip::isValidKey(1));
        $this->assertFalse(DataFormatManip::isValidKey(0));
        $this->assertFalse(DataFormatManip::isValidKey(-1));
    }

    // Test for isValidIdentifier method
    public function testIsValidIdentifier() {
        $str = 'example.identifier';
        $this->assertTrue(DataFormatManip::isValidIdentifier($str));

        $str = 'invalid_identifier';
        $this->assertFalse(DataFormatManip::isValidIdentifier($str));
    }

    // Test for isValidName method
    public function testIsValidName() {
        $str = 'John Doe';
        $this->assertTrue(DataFormatManip::isValidName($str));

        $str = 'John123';
        $this->assertFalse(DataFormatManip::isValidName($str));
    }

    // Test for isValidEmail method
    public function testIsValidEmail() {
        $str = 'test@example.com';
        $this->assertTrue(DataFormatManip::isValidEmail($str));

        $str = 'invalid-email';
        $this->assertFalse(DataFormatManip::isValidEmail($str));
    }

    // Test for isValidPhoneNumber method
    public function testIsValidPhoneNumber() {
        $str = '12.34.56.78.90';
        $this->assertTrue(DataFormatManip::isValidPhoneNumber($str));

        $str = '123.456.789';
        $this->assertFalse(DataFormatManip::isValidPhoneNumber($str));
    }

    // Test for isValidPostCode method
    public function testIsValidPostCode() {
        $str = '12345';
        $this->assertTrue(DataFormatManip::isValidPostCode($str));

        $str = '1234';
        $this->assertFalse(DataFormatManip::isValidPostCode($str));
    }

    // Test for nameFormat method
    public function testNameFormat() {
        $str = 'john doe';
        $this->assertEquals('John Doe', DataFormatManip::nameFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('Jane Doe', DataFormatManip::nameFormat($str));
    }

    // Test for majusculeFormat method
    public function testMajusculeFormat() {
        $str = 'john doe';
        $this->assertEquals('JOHN DOE', DataFormatManip::majusculeFormat($str));

        $str = 'JANE DOE';
        $this->assertEquals('JANE DOE', DataFormatManip::majusculeFormat($str));
    }

    // Test for phoneNumberFormat method
    public function testPhoneNumberFormat() {
        $number = '1234567890';
        $this->assertEquals('12.34.56.78.90', DataFormatManip::phoneNumberFormat($number));

        $number = '12345';
        $this->expectException(InvalidArgumentException::class);
        DataFormatManip::phoneNumberFormat($number);
    }
}
