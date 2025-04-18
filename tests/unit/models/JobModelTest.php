<?php

use PHPUnit\Framework\TestCase;
use App\Models\Job;
use App\Exceptions\JobExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Job model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class JobModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Job::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $job = new Job(
            getenv("VALID_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals(getenv("VALID_KEY_1"), $job->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $job->getId()));
        $this->assertEquals(getenv("JOB_TITLED"), $job->getTitled(), testErrorManager::cerr_eq(getenv("JOB_TITLED"), $job->getTitled()));
        $this->assertEquals(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin(), testErrorManager::cerr_eq(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin()));
    }

    /**
     * Public function testing Job::__constructor without ID
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $job = new Job(
            null,
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $this->assertInstanceOf(Job::class, $job);
        $this->assertNull($job->getId(), testErrorManager::cerr_null($job->getId()));
        $this->assertEquals(getenv("JOB_TITLED"), $job->getTitled(), testErrorManager::cerr_eq(getenv("JOB_TITLED"), $job->getTitled()));
        $this->assertEquals(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin(), testErrorManager::cerr_eq(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin()));
    }

    /**
     * Public function testing Job::__constructor with invalid ID
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(JobExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Job(
            getenv("WRONG_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );
    }

    // * GET * //
    /**
     * Public function testing Job::getId
     */
    public function testGetId(): void {
        $job = new Job(
            getenv("VALID_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $job->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $job->getId()));
    }

    /**
     * Public function testing Job::getTitled
     */
    public function testGetTitled(): void {
        $job = new Job(
            getenv("VALID_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $this->assertEquals(getenv("JOB_TITLED"), $job->getTitled(), testErrorManager::cerr_eq(getenv("JOB_TITLED"), $job->getTitled()));
    }

    /**
     * Public function testing Job::getTitledFeminin
     */
    public function testGetTitledFeminin(): void {
        $job = new Job(
            getenv("VALID_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $this->assertEquals(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin(), testErrorManager::cerr_eq(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin()));
    }

    // * CONVERT * //
    /**
     * Public function testing Job::fromArray
     *
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"            => getenv("VALID_KEY_1"),
            "Titled"        => getenv("JOB_TITLED"),
            "TitledFeminin" => getenv("JOB_TITLED_FEMININ")
        ];

        $job = Job::fromArray($data);

        $this->assertInstanceOf(Job::class, $job);
        $this->assertEquals(getenv("VALID_KEY_1"), $job->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $job->getId()));
        $this->assertEquals(getenv("JOB_TITLED"), $job->getTitled(), testErrorManager::cerr_eq(getenv("JOB_TITLED"), $job->getTitled()));
        $this->assertEquals(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin(), testErrorManager::cerr_eq(getenv("JOB_TITLED_FEMININ"), $job->getTitledFeminin()));
    }

    /**
     * Public function testing Job::fromArray with empty data
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(JobExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de poste. Tableau de données absent.");

        Job::fromArray([]);
    }

    /**
     * Public function testing Job::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $job = new Job(
            getenv("VALID_KEY_1"),
            getenv("JOB_TITLED"),
            getenv("JOB_TITLED_FEMININ")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "title"         => getenv("JOB_TITLED"),
            "title_feminin" => getenv("JOB_TITLED_FEMININ")
        ];

        $this->assertEquals($expectedArray, $job->toArray());
    }
}

