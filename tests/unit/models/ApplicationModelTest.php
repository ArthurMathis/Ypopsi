<?php

use PHPUnit\Framework\TestCase;
use App\Models\Application;
use App\Exceptions\ApplicationExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Application model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ApplicationModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Application::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Application::__constructor without id
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $application = new Application(
            id               : null,
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertNull($application->getId(), testErrorManager::cerr_null($application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    /**
     * Public function testing Application::__constructor without date
     * 
     * @return void
     */
    public function testConstructorWithoutDate(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : null,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertNull($application->getDate(), testErrorManager::cerr_null($application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    /**
     * Public function testing Application::__constructor without type
     * 
     * @return void
     */
    public function testConstructorWithoutType(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : null,
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertNull($application->getType(), testErrorManager::cerr_null($application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    /**
     * Public function testing Application::__constructor without need
     * 
     * @return void
     */
    public function testConstructorWithoutNeed(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : null,
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertNull($application->getNeed(), testErrorManager::cerr_null($application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    /**
     * Public function testing Application::__constructor without service
     * 
     * @return void
     */
    public function testConstructorWithouService(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : null,
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertNull($application->getService(), testErrorManager::cerr_null($application->getService()));
    }

    /**
     * Public function testing Application::__constructor without establishment
     * 
     * @return void
     */
    public function testConstructorWithoutEstablishment(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: null
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertNull($application->getEstablishment(), testErrorManager::cerr_null($application->getEstablishment()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Application::__constructor with invalid id
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Application(
            id               : $id,
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid date
     * 
     * @return void
     */
    public function testConstructorWithInvalidDate(): void {
        $date = getenv("WRONG_FULL_DATE_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Date invalide : {$date}.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : $date,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid candidate
     * 
     * @return void
     */
    public function testConstructorWithInvalidCandidate(): void {
        $candidate = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du candidat invalide : {$candidate}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : $candidate,
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid job
     * 
     * @return void
     */
    public function testConstructorWithInvalidJob(): void {
        $job = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du poste invalide : {$job}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : $job,
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid type
     * 
     * @return void
     */
    public function testConstructorWithInvalidType(): void {
        $type = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du type de contrat invalide : {$type}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : $type,
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid source
     * 
     * @return void
     */
    public function testConstructorWithInvalidSource(): void {
        $source = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire de la source invalide : {$source}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : $source,
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid need
     * 
     * @return void
     */
    public function testConstructorWithInvalidNeed(): void {
        $needKey = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du besoin invalide : {$needKey}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : $needKey,
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid key
     * 
     * @return void
     */
    public function testConstructorWithInvalidService(): void {
        $service = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire du service invalide : {$service}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : $service,
            establishment_key: getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Application::__constructor with invalid establishment
     * 
     * @return void
     */
    public function testConstructorWithInvalidEstablishment(): void {
        $establishment = getenv("WRONG_KEY_1");
        $this->expectException(ApplicationExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'établissement invalide : {$establishment}. Clé attendue strictement positive.");

        new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: $establishment
        );
    }

    // * GET * //
    /**
     * Public function testing Application::getId
     * 
     * @return void
     */
    public function testGetId(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
    }

    /**
     * Public function testing Application::getAccepted
     * 
     * @return void
     */
    public function testGetAccepted(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : true,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertTrue($application->getAccepted(), testErrorManager::cerr_eq(true, $application->getAccepted()));
    }

    /**
     * Public function testing Application::getRefused
     * 
     * @return void
     */
    public function testGetRefused(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : true,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertTrue($application->getRefused(), testErrorManager::cerr_eq(true, $application->getRefused()));
    }

    /**
     * Public function testing Application::getDate
     * 
     * @return void
     */
    public function testGetDate(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
    }

    /**
     * Public function testing Application::getCandidate
     * 
     * @return void
     */
    public function testGetCandidate(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getCandidate()));
    }

    /**
     * Public function testing Application::getJob
     * 
     * @return void
     */
    public function testGetJob(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
    }

    /**
     * Public function testing Application::getType
     * 
     * @return void
     */
    public function testGetType(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
    }

    /**
     * Public function testing Application::getSource
     * 
     * @return void
     */
    public function testGetSource(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
    }

    /**
     * Public function testing Application::getNeed
     * 
     * @return void
     */
    public function testGetNeed(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
    }

    /**
     * Public function testing Application::getEstablishment
     * 
     * @return void
     */
    public function testGetEstablishment(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    /**
     * Public function testing Application::getService
     * 
     * @return void
     */
    public function testGetService(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
    }

    // * CREATE * //
    /**
     * Public function testing Application::create
     * 
     * @return void
     */
    public function testCreate(): void {
        $application = Application::create(
            candidate    : getenv("VALID_KEY_1"),
            job          : getenv("VALID_KEY_1"),
            source       : getenv("VALID_KEY_1"),
            type         : getenv("VALID_KEY_1"),
            establishment: getenv("VALID_KEY_1"),
            service      : getenv("VALID_KEY_1"),
            need         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Application::class, $application);
        $this->assertNull($application->getId(), testErrorManager::cerr_null($application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertNull($application->getDate(), testErrorManager::cerr_null($application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }

    // * CONVERT * //
    /**
     * Public function testing Application::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $application = new Application(
            id               : getenv("VALID_KEY_1"),
            is_accepted      : false,
            is_refused       : false,
            date             : getenv("VALID_FULL_DATE"),
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            source_key       : getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1"),
            need_key         : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "accepted"      => false,
            "refused"       => false,
            "date"          => getenv("VALID_FULL_DATE"),
            "candidate"     => getenv("VALID_KEY_1"),
            "job"           => getenv("VALID_KEY_1"),
            "type"          => getenv("VALID_KEY_1"),
            "source"        => getenv("VALID_KEY_1"),
            "need"          => getenv("VALID_KEY_1"),
            "establishment" => getenv("VALID_KEY_1"),
            "service"       => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $application->toArray());
    }

    /**
     * Public function testing Application::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"                     => getenv("VALID_KEY_1"),
            "IsAccepted"             => false,
            "IsRefused"              => false,
            "Moment"                 => getenv("VALID_FULL_DATE"),
            "Key_Candidates"         => getenv("VALID_KEY_1"),
            "Key_Jobs"               => getenv("VALID_KEY_1"),
            "Key_Types_of_contracts" => getenv("VALID_KEY_1"),
            "Key_Sources"            => getenv("VALID_KEY_1"),
            "Key_Needs"              => getenv("VALID_KEY_1"),
            "Key_Establishments"     => getenv("VALID_KEY_1"),
            "Key_Services"           => getenv("VALID_KEY_1")
        ];

        $application = Application::fromArray($data);

        $this->assertInstanceOf(Application::class, $application);
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getId()));
        $this->assertEquals(false, $application->getAccepted(), testErrorManager::cerr_eq(false, $application->getAccepted()));
        $this->assertEquals(false, $application->getRefused(), testErrorManager::cerr_eq(false, $application->getRefused()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $application->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $application->getDate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getSource(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getSource()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getType()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getNeed(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getNeed()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $application->getEstablishment(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $application->getEstablishment()));
    }
}