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
     * 
     * @return void
     */
    public function testConstructor(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Establishment::__constructor without ID
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $establishment = new Establishment(
            null,
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertNull($establishment->getId(), testErrorManager::cerr_null($establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor without Description
     * 
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            null,
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $establishment->getPostcode()));
        $this->assertNull($establishment->getDescription(), testErrorManager::cerr_null($establishment->getDescription()));
        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    /**
     * Public function testing Establishment::__constructor without Pole
     * 
     * @return void
     */
    public function testConstructorWithoutPole(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            null
        );

        $this->assertInstanceOf(Establishment::class, $establishment);
        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $establishment->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $establishment->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $establishment->getPostcode()));
        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
        $this->assertNull($establishment->getPole(), testErrorManager::cerr_null($establishment->getPole()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Establishment::__constructor with invalid ID
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Establishment(
            getenv("WRONG_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );
    }

    /**
     * Public function testing Establishment::__constructor with invalid postcode
     * 
     * @return void
     */
    public function testConstructorWithInvalidPostcode(): void {
        $postcode = getenv("WRONG_POSTCODE_1");
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Le code postal : {$postcode} est invalide.");

        new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            $postcode,
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );
    }

    /**
     * Public function testing Establishment::__constructor with invalid pole key
     * 
     * @return void
     */
    public function testConstructorWithInvalidPole(): void {
        $pole = getenv("WRONG_KEY_1");
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Clé de pôle invalide : {$pole}. Clé attendue strictement positive.");

        new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            $pole
        );
    }

    // * GET * //
    /**
     * Public function testing Establishment::getId
     */
    public function testGetId(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $establishment->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $establishment->getId()));
    }

    /**
     * Public function testing Establishment::getTitled
     */
    public function testGetTitled(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_TITLED"), $establishment->getTitled()));
    }

    /**
     * Public function testing Establishment::getAddress
     */
    public function testGetAddress(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_ADDRESS"), $establishment->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $establishment->getAddress()));
    }

    /**
     * Public function testing Establishment::getCity
     */
    public function testGetCity(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_CITY"), $establishment->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $establishment->getCity()));
    }

    /**
     * Public function testing Establishment::getPostcode
     */
    public function testGetPostcode(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_POSTCODE"), $establishment->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $establishment->getPostcode()));
    }

    /**
     * Public function testing Establishment::getDescription
     */
    public function testGetDescription(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription(), testErrorManager::cerr_eq(getenv("ESTABLISHMENT_DESCRIPTION"), $establishment->getDescription()));
    }

    /**
     * Public function testing Establishment::getPole
     */
    public function testGetPole(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $establishment->getPole(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $establishment->getPole()));
    }

    // * CONVERT * //
    /**
     * Public function testing Establishment::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("ESTABLISHMENT_TITLED"),
            "Address"     => getenv("VALID_ADDRESS"),
            "City"        => getenv("VALID_CITY"),
            "PostCode"    => getenv("VALID_POSTCODE"),
            "Description" => getenv("ESTABLISHMENT_DESCRIPTION"),
            "Key_Poles"   => getenv("VALID_KEY_2")
        ];

        $establishment = Establishment::fromArray($data);

        $this->assertInstanceOf(Establishment::class, $establishment);
    }

    /**
     * Public function testing Establishment::fromArray with an empty array
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(EstablishmentExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'action. Tableau de données absent.");

        Establishment::fromArray([]);
    }

    /**
     * Public function testing Establishment::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $establishment = new Establishment(
            getenv("VALID_KEY_1"),
            getenv("ESTABLISHMENT_TITLED"),
            getenv("VALID_ADDRESS"),
            getenv("VALID_CITY"),
            getenv("VALID_POSTCODE"),
            getenv("ESTABLISHMENT_DESCRIPTION"),
            getenv("VALID_KEY_2")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "address"     => getenv("VALID_ADDRESS"),
            "address"     => getenv("VALID_CITY"),
            "address"     => getenv("VALID_POSTCODE"),
            "description" => getenv("ESTABLISHMENT_DESCRIPTION"),
            "pole"        => getenv("VALID_KEY_2")
        ];

        $this->assertEquals($expectedArray, $establishment->toArray());
    }
}
