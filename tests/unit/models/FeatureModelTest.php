<?php

use PHPUnit\Framework\TestCase;
use App\Models\Feature;
use App\Exceptions\FeatureExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Feature model class
 */
class FeatureModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Feature::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(getenv("VALID_KEY_1"), $feature->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $feature->getId()));
        $this->assertEquals(getenv("FEATURE_TITLED"), $feature->getTitled(), testErrorManager::cerr_eq(getenv("FEATURE_TITLED"), $feature->getTitled()));
        $this->assertEquals(getenv("FEATURE_DESCRIPTION"), $feature->getDescription(), testErrorManager::cerr_eq(getenv("FEATURE_DESCRIPTION"), $feature->getDescription()));
        $this->assertEquals(getenv("FEATURE_ENABLE"), $feature->getEnable(), testErrorManager::cerr_eq(getenv("FEATURE_ENABLE"), $feature->getEnable()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Feature::__constructor without ID
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $feature = new Feature(
            null,
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertNull($feature->getId(), testErrorManager::cerr_null($feature->getId()));
        $this->assertEquals(getenv("FEATURE_TITLED"), $feature->getTitled(), testErrorManager::cerr_eq(getenv("FEATURE_TITLED"), $feature->getTitled()));
        $this->assertEquals(getenv("FEATURE_DESCRIPTION"), $feature->getDescription(), testErrorManager::cerr_eq(getenv("FEATURE_DESCRIPTION"), $feature->getDescription()));
        $this->assertEquals(getenv("FEATURE_ENABLE"), $feature->getEnable(), testErrorManager::cerr_eq(getenv("FEATURE_ENABLE"), $feature->getEnable()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Feature::__constructor with invalid ID
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(FeatureExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Feature(
            getenv("WRONG_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );
    }

    // * GET * //
    /**
     * Public function testing Feature::getId
     */
    public function testGetId(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $feature->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $feature->getId()));
    }

    /**
     * Public function testing Feature::getTitled
     */
    public function testGetTitled(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertEquals(getenv("FEATURE_TITLED"), $feature->getTitled(), testErrorManager::cerr_eq(getenv("FEATURE_TITLED"), $feature->getTitled()));
    }

    /**
     * Public function testing Feature::getDescription
     */
    public function testGetDescription(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertEquals(getenv("FEATURE_DESCRIPTION"), $feature->getDescription(), testErrorManager::cerr_eq(getenv("FEATURE_DESCRIPTION"), $feature->getDescription()));
    }

    /**
     * Public function testing Feature::getEnable
     */
    public function testGetEnable(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $this->assertEquals(getenv("FEATURE_ENABLE"), $feature->getEnable(), testErrorManager::cerr_eq(getenv("FEATURE_ENABLE"), $feature->getEnable()));
    }

    // * CONVERT * //
    /**
     * Public function testing Feature::fromArray
     *
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("FEATURE_TITLED"),
            "Description" => getenv("FEATURE_DESCRIPTION"),
            "Enable"      => getenv("FEATURE_ENABLE")
        ];

        $feature = Feature::fromArray($data);

        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertEquals(getenv("VALID_KEY_1"), $feature->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $feature->getId()));
        $this->assertEquals(getenv("FEATURE_TITLED"), $feature->getTitled(), testErrorManager::cerr_eq(getenv("FEATURE_TITLED"), $feature->getTitled()));
        $this->assertEquals(getenv("FEATURE_DESCRIPTION"), $feature->getDescription(), testErrorManager::cerr_eq(getenv("FEATURE_DESCRIPTION"), $feature->getDescription()));
        $this->assertEquals(getenv("FEATURE_ENABLE"), $feature->getEnable(), testErrorManager::cerr_eq(getenv("FEATURE_ENABLE"), $feature->getEnable()));
    }

    /**
     * Public function testing Feature::fromArray with empty data
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(FeatureExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de la fonctionnalité. Tableau de données absent.");

        Feature::fromArray([]);
    }

    /**
     * Public function testing Feature::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $feature = new Feature(
            getenv("VALID_KEY_1"),
            getenv("FEATURE_TITLED"),
            getenv("FEATURE_DESCRIPTION"),
            getenv("FEATURE_ENABLE")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "titled"      => getenv("FEATURE_TITLED"),
            "description" => getenv("FEATURE_DESCRIPTION"),
            "enable"      => getenv("FEATURE_ENABLE")
        ];

        $this->assertEquals($expectedArray, $feature->toArray());
    }
}
