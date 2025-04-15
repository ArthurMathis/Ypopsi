<?php

use PHPUnit\Framework\TestCase;
use App\Models\HaveTheRightTo;
use App\Exceptions\HaveTheRightToExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the HaveTheRightTo model class
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class HaveTheRightToModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing HaveTheRightTo::__constructor
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

    /**
     * Public function testing HaveTheRightTo::__constructor
     */
    public function testConstructorWithourCandidate(): void {
        $have = new HaveTheRightTo(
            null,
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertEquals(null, $have->getCandidate(), testErrorManager::cerr_eq(null, $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getEmployee(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getEmployee()));
    }

    /**
     * Public function testing HaveTheRightTo::__constructor
     */
    public function testConstructorWithout(): void {
        $have = new HaveTheRightTo(
            getenv("VALID_KEY_1"),
            getenv("VALID_KEY_1"),
            null
        );

        $this->assertInstanceOf(HaveTheRightTo::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getHelp(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getHelp()));
        $this->assertEquals(null, $have->getEmployee(), testErrorManager::cerr_eq(null, $have->getEmployee()));
    }

    // * CONVERT * //
    /**
     * Public function testing HaveTheRightTo::fromArray
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
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(HaveTheRightToExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du droit à l'aide. Tableau de données absent.");

        HaveTheRightTo::fromArray([]);
    }

    /**
     * Public function testing HaveTheRightTo::toArray
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