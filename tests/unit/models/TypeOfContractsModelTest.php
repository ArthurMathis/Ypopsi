<?php

use PHPUnit\Framework\TestCase;
use App\Models\TypeOfContracts;
use App\Exceptions\TypeOfContractsExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the TypeOfContracts model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TypeOfContractsModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing TypesOfActions::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertInstanceOf(TypeOfContracts::class, $contract);
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $contract->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $contract->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $contract->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $contract->getDescription()));
    }

    //// WITHOUT ////
    /**
     * Public function testing TypesOfActions::__constructor without Id
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $contract = new TypeOfContracts(
            null,
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertInstanceOf(TypeOfContracts::class, $contract);
        $this->assertNull($contract->getId(), testErrorManager::cerr_null($contract->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $contract->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $contract->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $contract->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $contract->getDescription()));
    }

    /**
     * Public function testing TypesOfActions::__constructor without Description
     *
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            null
        );

        $this->assertInstanceOf(TypeOfContracts::class, $contract);
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $contract->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $contract->getTitled()));
        $this->assertNull($contract->getDescription(), testErrorManager::cerr_null($contract->getDescription()));
    }


    //// WITH INVALID ////
    /**
     * Public function testing TypesOfActions::__constructor with invalid Id
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(TypeOfContractsExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new TypeOfContracts(
            $id,
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );
    }

    // * GET * //
    /**
     * Public function testing TypesOfActions::getId
     *
     * @return void
     */
    public function testGetId(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
    }

    /**
     * Public function testing TypesOfActions::getTitled
     *
     * @return void
     */
    public function testGetTitled(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("HELP_TITLED"), $contract->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $contract->getTitled()));
    }

    /**
     * Public function testing TypesOfActions::getDescription
     *
     * @return void
     */
    public function testGetDescription(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("HELP_DESCRIPTION"), $contract->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $contract->getDescription()));
    }

    // * CONVERT * //
    /**
     * Public function testing TypesOfActions::fromArray
     *
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("HELP_TITLED"),
            "Description" => getenv("HELP_DESCRIPTION")
        ];

        $contract = TypeOfContracts::fromArray($data);

        $this->assertInstanceOf(TypeOfContracts::class, $contract);
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $contract->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $contract->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $contract->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $contract->getDescription()));
    }

    /**
     * Public function testing TypesOfActions::fromArray with empty data
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(TypeOfContractsExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du type de contrats. Tableau de données absent.");

        TypeOfContracts::fromArray([]);
    }

    /**
     * Public function testing TypesOfActions::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $contract = new TypeOfContracts(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "title"       => getenv("HELP_TITLED"),
            "description" => getenv("HELP_DESCRIPTION")
        ];

        $this->assertEquals($expectedArray, $contract->toArray());
    }
}