<?php

use PHPUnit\Framework\TestCase;
use App\Models\HaveTheRightTo;
use App\Exceptions\HaveTheRightToExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the HaveTheRightTo model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class HaveTheRightToModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing HaveTheRightTo::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getEmployee(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getEmployee()));
    }

    //// WITHOUT ////
    /**
     * Public function testing HaveTheRightTo::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutCandidate(): void {
        $have = new HaveTheRightTo(
            null,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertNull($have->getCandidate(), testErrorManager::cerr_null($have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getEmployee(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getEmployee()));
    }

    /**
     * Public function testing HaveTheRightTo::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutEmployee(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            null
        );

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertNull($have->getEmployee(), testErrorManager::cerr_null($have->getEmployee()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing HaveTheRightTo::__constructor with invalid candidate
     *
     * @return void
     */
    public function testConstructorWithInvalidCandidate(): void {
        $candidate = getenv("WRONG_KEY_1");
        $this->expectException(HaveTheRightToExceptions::class);
        $this->expectExceptionMessage("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");

        new HaveTheRightTo(
            $candidate,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing HaveTheRightTo::__constructor with invalid employee
     *
     * @return void
     */
    public function testConstructorWithInvalidEmployee(): void {
        $employee = getenv("WRONG_KEY_1");
        $this->expectException(HaveTheRightToExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'employé invalide : {$employee}. Clé attendue strictement positive.");

        new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            $employee
        );
    }

    // * GET * //
    /**
     * Public function testing HaveTheRightTo::getCandidate
     */
    public function testGetCandidate(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
    }

    /**
     * Public function testing HaveTheRightTo::getHelp
     */
    public function testGetHelp(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $have->getHelp()));
    }

    /**
     * Public function testing HaveTheRightTo::getEmployee
     */
    public function testGetEmployee(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_3"), $have->getEmployee(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $have->getEmployee()));
    }

    // * CONVERT * //
    /**
     * Public function testing HaveTheRightTo::fromArray
     *
     * @return void
     */
    public function testFromArray() : void {
        $data = [
            "Key_Candidates" => getenv("VALID_KEY_1"),
            "Key_Helps"      => getenv("VALID_KEY_1"),
            "Key_Employee"   => getenv("VALID_KEY_1")
        ];

        $have = HaveTheRightTo::fromArray($data);

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getEmployee(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getEmployee()));
    }

    /**
     * Public function testing HaveTheRightTo::fromArray
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(HaveTheRightToExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du droit à l'aide. Tableau de données absent.");

        HaveTheRightTo::fromArray([]);
    }

    /**
     * Public function testing HaveTheRightTo::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "candidate" => getenv("VALID_KEY_1"),
            "help"      => getenv("VALID_KEY_1"),
            "employee"  => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $have->toArray());
    }
}