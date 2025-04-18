<?php

use PHPUnit\Framework\TestCase;
use App\Models\Meeting;
use App\Exceptions\MeetingExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Meeting model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class MeetingModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Meeting::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertEquals(getenv("MEETING_DESCRIPTION"), $meeting->getDescription(), testErrorManager::cerr_eq(getenv("MEETING_DESCRIPTION"), $meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Meeting::__constructor without ID
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $meeting = new Meeting(
            null,
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertNull($meeting->getId(), testErrorManager::cerr_null($meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertEquals(getenv("MEETING_DESCRIPTION"), $meeting->getDescription(), testErrorManager::cerr_eq(getenv("MEETING_DESCRIPTION"), $meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    /**
     * Public function testing Meeting::__constructor without description
     *
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            null,
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertNull($meeting->getDescription(), testErrorManager::cerr_null($meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Meeting::__constructor with invalid ID
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Meeting(
            getenv("WRONG_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Meeting::__constructor with invalid date
     *
     * @return void
     */
    public function testConstructorWithInvalidDate(): void {
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Date invalide : .");

        new Meeting(
            getenv("VALID_KEY_1"),
            "",
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Meeting::__constructor with invalid user key
     *
     * @return void
     */
    public function testConstructorWithInvalidUser(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$key}. Clé attendue strictement positive.");

        new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            $key,
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Meeting::__constructor with invalid candidate key
     *
     * @return void
     */
    public function testConstructorWithInvalidCandidate(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Clé primaire du candidat invalide : {$key}. Clé attendue strictement positive.");

        new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            $key,
            getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Meeting::__constructor with invalid establishment key
     *
     * @return void
     */
    public function testConstructorWithInvalidEstablishment(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'établissement invalide : {$key}. Clé attendue strictement positive.");

        new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            $key
        );
    }

    // * GET * //
    /**
     * Public function testing Meeting::getId
     */
    public function testGetId(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getId()));
    }

    /**
     * Public function testing Meeting::getDate
     */
    public function testGetDate(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
    }

    /**
     * Public function testing Meeting::getDescription
     */
    public function testGetDescription(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("MEETING_DESCRIPTION"), $meeting->getDescription(), testErrorManager::cerr_eq(getenv("MEETING_DESCRIPTION"), $meeting->getDescription()));
    }

    /**
     * Public function testing Meeting::getUser
     */
    public function testGetUser(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
    }

    /**
     * Public function testing Meeting::getCandidate
     */
    public function testGetCandidate(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
    }

    /**
     * Public function testing Meeting::getEstablishment
     */
    public function testGetEstablishment(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    // * CREATE * //
    /**
     * Public function testing Meeting::create
     *
     * @return void
     */
    public function testCreate(): void {
        $meeting = Meeting::create(
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1"),
            getenv("MEETING_DESCRIPTION")
        );

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertNull($meeting->getId(), testErrorManager::cerr_null($meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertEquals(getenv("MEETING_DESCRIPTION"), $meeting->getDescription(), testErrorManager::cerr_eq(getenv("MEETING_DESCRIPTION"), $meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    /**
     * Public function testing Meeting::create without Description
     *
     * @return void
     */
    public function testCreateWithoutDescriptin(): void {
        $meeting = Meeting::create(
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1"),
            null
        );

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertNull($meeting->getId(), testErrorManager::cerr_null($meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertNull($meeting->getDescription(), testErrorManager::cerr_null($meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    // * CONVERT * //
    /**
     * Public function testing Meeting::fromArray
     *
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"                => getenv("VALID_KEY_1"),
            "Date"              => getenv("VALID_DATE"),
            "Description"       => getenv("MEETING_DESCRIPTION"),
            "Key_Users"         => getenv("VALID_KEY_2"),
            "Key_Candidates"    => getenv("VALID_KEY_3"),
            "Key_Establishments"=> getenv("VALID_KEY_1")
        ];

        $meeting = Meeting::fromArray($data);

        $this->assertInstanceOf(Meeting::class, $meeting);
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $meeting->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $meeting->getDate()));
        $this->assertEquals(getenv("MEETING_DESCRIPTION"), $meeting->getDescription(), testErrorManager::cerr_eq(getenv("MEETING_DESCRIPTION"), $meeting->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $meeting->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $meeting->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $meeting->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $meeting->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $meeting->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $meeting->getEstablishment()));
    }

    /**
     * Public function testing Meeting::fromArray with empty data
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(MeetingExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du rendez-vous. Tableau de données absent.");

        Meeting::fromArray([]);
    }

    /**
     * Public function testing Meeting::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $meeting = new Meeting(
            getenv("VALID_KEY_1"),
            getenv("VALID_DATE"),
            getenv("MEETING_DESCRIPTION"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "date"          => getenv("VALID_DATE"),
            "description"   => getenv("MEETING_DESCRIPTION"),
            "user"          => getenv("VALID_KEY_2"),
            "candidate"     => getenv("VALID_KEY_3"),
            "establishment" => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $meeting->toArray());
    }
}

