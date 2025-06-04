<?php 

use PHPUnit\Framework\TestCase;
use App\Core\Tools\DataFormat\TimeManager;
use App\Exceptions\TimeManagerExceptions;
use App\Core\Tools\testErrorManager;

class TimeManagerTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing TimeManager::__constructor with valid date
     */
    public function testConstructorWithValidDate(): void {
        $date = getenv("VALID_FULL_DATE");
        $timeManager = new TimeManager($date);

        $this->assertInstanceOf(TimeManager::class, $timeManager);
        $this->assertEquals($date, $timeManager->getDate());
    }

    /**
     * Public function testing TimeManager::__constructor with invalid date
     */
    public function testConstructorWithInvalidDate(): void {
        $invalidDates = [
            getenv("WRONG_FULL_DATE_1"),
            getenv("WRONG_FULL_DATE_2"),
            getenv("WRONG_FULL_DATE_3"),
            getenv("WRONG_FULL_DATE_4"),
            getenv("WRONG_FULL_DATE_5"),
            getenv("WRONG_FULL_DATE_6"),
            getenv("WRONG_FULL_DATE_7"),
            getenv("WRONG_FULL_DATE_8"),
            getenv("WRONG_FULL_DATE_9"),
            getenv("WRONG_FULL_DATE_10"),
            getenv("WRONG_FULL_DATE_11"),
            getenv("WRONG_FULL_DATE_12"),
            getenv("WRONG_FULL_DATE_13")
        ];

        foreach ($invalidDates as $invalidDate) {
            $this->expectException(TimeManagerExceptions::class);
            $this->expectExceptionMessage("La date : {$invalidDate} est invalide.");

            new TimeManager($invalidDate);
        }
    }

    // * GET  * //
    /**
     * Public function testing TimeManager::getDate
     */
    public function testGetDate(): void {
        $date = getenv("VALID_FULL_DATE");
        $timeManager = new TimeManager($date);

        $this->assertEquals($date, $timeManager->getDate(), testErrorManager::cerr_eq($date, $timeManager->getDate()));
    }

    /**
     * Public function testing TimeManager::getTimestamp
     */
    public function testGetTimestamp(): void {
        $date = getenv("VALID_FULL_DATE");
        $timeManager = new TimeManager($date);
        $expectedTimestamp = strtotime($date);

        $this->assertEquals($expectedTimestamp, $timeManager->getTimestamp(), testErrorManager::cerr_eq((string)$expectedTimestamp, (string)$timeManager->getTimestamp()));
    }
}