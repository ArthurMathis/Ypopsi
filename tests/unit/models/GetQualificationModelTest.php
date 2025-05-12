<?php

use PHPUnit\Framework\TestCase;
use App\Models\GetQualification;
use App\Exceptions\GetQualificationExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the GetQualification model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class GetQualificationModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing GetQualification::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $get = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE")
        );

        $this->assertInstanceOf(GetQualification::class, $get);
        $this->assertEquals(getenv("VALID_KEY_1"), $get->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $get->getQualification(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getQualification()));
        $this->assertEquals(getenv("VALID_DATE"), $get->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $get->getDate()));
    }

    //// WITHOUT ////
    /**
     * Public function testing GetQualification::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $get = new GetQualification(
            null,
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE")
        );

        $this->assertInstanceOf(GetQualification::class, $get);
        $this->assertNull($get->getCandidate(), testErrorManager::cerr_null($get->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $get->getQualification(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getQualification()));
        $this->assertEquals(getenv("VALID_DATE"), $get->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $get->getDate()));
    }
    /**
     * Public function testing GetQualification::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutDate(): void {
        $get = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            null
        );

        $this->assertInstanceOf(GetQualification::class, $get);
        $this->assertEquals(getenv("VALID_KEY_1"), $get->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $get->getQualification(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getQualification()));
        $this->assertNull($get->getDate(), testErrorManager::cerr_null($get->getDate()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing GetQualification::__constructor with invalid candidate ID
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $candidate = getenv("WRONG_KEY_1");
        $this->expectException(GetQualificationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");

        new GetQualification(
            $candidate,
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE")
        );
    }

    // * GET * //
    /**
     * Public function testing GetQualification::getCandidate
     */
    public function testGetCandidate(): void {
        $get = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_DATE")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $get->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $get->getCandidate()));
    }

    /**
     * Public function testing GetQualification::getQualification
     */
    public function testGetQualification(): void {
        $get = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_DATE")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $get->getQualification(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $get->getQualification()));
    }

    /**
     * Public function testing GetQualification::getDate
     */
    public function testGetDate(): void {
        $get = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_DATE")
        );

        $this->assertEquals(getenv("VALID_DATE"), $get->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $get->getDate()));
    }

    // * CONVERT * //
    /**
     * Public function testing GetQualification::fromArray
     *
     * @return void
     */
    public function testFromArray() : void {
        $data = [
            "Key_Candidates"     => getenv("VALID_KEY_1"),
            "Key_Qualifications" => getenv("VALID_KEY_1"),
            "Date"               => getenv("VALID_DATE")
        ];

        $have = GetQualification::fromArray($data);

        $this->assertInstanceOf(GetQualification::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getQualification(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getQualification()));
        $this->assertEquals(getenv("VALID_DATE"), $have->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $have->getDate()));
    }

    /**
     * Public function testing GetQualification::fromArray
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(GetQualificationExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du candidat. Tableau de données absent.");

        GetQualification::fromArray([]);
    }

    /**
     * Public function testing GetQualification::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $have = new GetQualification(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE")
        );

        $expectedArray = [
            "candidate"     => getenv("VALID_KEY_1"),
            "qualification" => getenv("VALID_KEY_1"),
            "date"          => getenv("VALID_DATE")
        ];

        $this->assertEquals($expectedArray, $have->toArray());
    }
}