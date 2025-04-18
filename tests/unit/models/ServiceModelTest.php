<?php 

use PHPUnit\Framework\TestCase;
use App\Models\Service;
use App\Exceptions\ServiceExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Service model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr> 
 */
class ServiceModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Service::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $service = new Service(
            getenv("VALID_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );

        $this->assertInstanceOf(Service::class, $service);
        $this->assertEquals(getenv("VALID_KEY_1"), $service->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $service->getId()));
        $this->assertEquals(getenv("SERVICE_TITLED"), $service->getTitled(), testErrorManager::cerr_eq(getenv("SERVICE_TITLED"), $service->getTitled()));
        $this->assertEquals(getenv("SERVICE_DESCRIPTION"), $service->getDescription(), testErrorManager::cerr_eq(getenv("SERVICE_DESCRIPTION"), $service->getDescription()));
    }

    /**
     * Public function testing Service::__constructor with null parameters
     * 
     * @return void
     */
    public function testConstructorWithNullParameters(): void {
        $service = new Service(
            null,
            getenv("SERVICE_TITLED"),
            null
        );

        $this->assertInstanceOf(Service::class, $service);
        $this->assertNull($service->getId(), testErrorManager::cerr_null($service->getId()));
        $this->assertEquals(getenv("SERVICE_TITLED"), $service->getTitled(), testErrorManager::cerr_eq(getenv("SERVICE_TITLED"), $service->getTitled()));
        $this->assertNull($service->getDescription(), testErrorManager::cerr_null($service->getDescription()));
    }

    /**
     * Public function testing Service::__constructor with invalid ID
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(ServiceExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Service(
            getenv("WRONG_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );
    }

    // * GET * //
    /**
     * Public function testing Service::getId
     */
    public function testGetId(): void {
        $service = new Service(
            getenv("VALID_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $service->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $service->getId()));
    }

    /**
     * Public function testing Service::getTitled
     */
    public function testGetTitled(): void {
        $service = new Service(
            getenv("VALID_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );

        $this->assertEquals(getenv("SERVICE_TITLED"), $service->getTitled(), testErrorManager::cerr_eq(getenv("SERVICE_TITLED"), $service->getTitled()));
    }

    /**
     * Public function testing Service::getDescription
     */
    public function testGetDescription(): void {
        $service = new Service(
            getenv("VALID_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );

        $this->assertEquals(getenv("SERVICE_DESCRIPTION"), $service->getDescription(), testErrorManager::cerr_eq(getenv("SERVICE_DESCRIPTION"), $service->getDescription()));
    }

    // * CONVERT * //
    /**
     * Public function testing Service::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("SERVICE_TITLED"),
            "Description" => getenv("SERVICE_DESCRIPTION")
        ];

        $service = Service::fromArray($data);

        $this->assertInstanceOf(Service::class, $service);
        $this->assertEquals(getenv("VALID_KEY_1"), $service->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $service->getId()));
        $this->assertEquals(getenv("SERVICE_TITLED"), $service->getTitled(), testErrorManager::cerr_eq(getenv("SERVICE_TITLED"), $service->getTitled()));
        $this->assertEquals(getenv("SERVICE_DESCRIPTION"), $service->getDescription(), testErrorManager::cerr_eq(getenv("SERVICE_DESCRIPTION"), $service->getDescription()));
    }

    /**
     * Public function testing Service::fromArray with empty data
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(ServiceExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du service. Tableau de données absent.");

        Service::fromArray([]);
    }

    /**
     * Public function testing Service::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $service = new Service(
            getenv("VALID_KEY_1"),
            getenv("SERVICE_TITLED"),
            getenv("SERVICE_DESCRIPTION")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "title"       => getenv("SERVICE_TITLED"),
            "description" => getenv("SERVICE_DESCRIPTION")
        ];

        $this->assertEquals($expectedArray, $service->toArray());
    }
}