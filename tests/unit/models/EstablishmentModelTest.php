<?php

use PHPUnit\Framework\TestCase;
use App\Models\Establishment;
use App\Exceptions\EstablishmentExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Establishment model class
 */
class EstablishmentModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Establishment::__constructor
     */
    public function testConstructor(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("ESTABLISHMENT_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor without ID
     */
    public function testConstructorWithoutId(): void {
        $establishment = new Establishment(
            null,
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(null, $establishment->getId(), testErrorManager::cerr_eq(null, $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("ESTABLISHMENT_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor without pole
     */
    public function testConstructorWithoutPole(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            null
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("ESTABLISHMENT_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(null, $establishment->getPole(), testErrorManager::cerr_eq(null, $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor without description
     */
    public function testConstructorWithoutDescription(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            null,
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("ESTABLISHMENT_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(null, $establishment->getDescription(), testErrorManager::cerr_eq(null, $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor with invalid ID
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Establishment(
            getenv("INVALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );
    }

    /**
     * Public function testing Establishment::__constructor with invalid pole key
     */
    public function testConstructorWithInvalidPole(): void {
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Clé de pôle invalide : 0. Clé attendue strictement positive.");

        new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("INVALID_KEY_1")
        );
    }

    // * CONVERT * //
    /**
     * Public function testing Establishment::fromArray
     */
    public function testFromArray(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("ESTABLISHMENT_TITLED"),
            "Address"     => getenv("ESTABLISHMENT_ADDRESS"),
            "City"        => getenv("ESTABLISHMENT_CITY"),
            "PostCode"    => getenv("ESTABLISHMENT_POSTCODE"),
            "Description" => getenv("ESTABLISHMENT_DESCRIPTION"),
            "Key_Poles"   => getenv("VALID_KEY_2")
        ];

        $establishment = Establishment::fromArray($data);

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("ESTABLISHMENT_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::fromArray with empty data
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'action. Tableau de données absent.");

        Establishment::fromArray([]);
    }

    /**
     * Public function testing Establishment::toArray
     */
    public function testToArray(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("ESTABLISHMENT_ADDRESS"),
            getenv("ESTABLISHMENT_CITY"),
            getenv("ESTABLISHMENT_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "address"     => getenv("ESTABLISHMENT_ADDRESS"),
            "address"     => getenv("ESTABLISHMENT_CITY"),
            "address"     => getenv("ESTABLISHMENT_POSTCODE"),
            "description" => getenv("ESTABLISHMENT_DESCRIPTION"),
            "pole"        => getenv("VALID_KEY_2")
        ];

        $this->assertEquals($expectedArray, $establishment->toArray());
    }
}
