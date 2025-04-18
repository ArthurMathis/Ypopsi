<?php

use PHPUnit\Framework\TestCase;
use App\Models\Help;
use App\Exceptions\HelpExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Help model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class HelpModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Help::__constructor
     *
     * @return void
     */
    public function testConstructor(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertInstanceOf(Help::class, $help);
        $this->assertEquals(getenv("VALID_KEY_1"), $help->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $help->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $help->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $help->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $help->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $help->getDescription()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Help::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $help = new Help(
            null,
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertInstanceOf(Help::class, $help);
        $this->assertNull($help->getId(), testErrorManager::cerr_null($help->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $help->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $help->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $help->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $help->getDescription()));
    }

    /**
     * Public function testing Help::__constructor
     *
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            null
        );

        $this->assertInstanceOf(Help::class, $help);
        $this->assertEquals(getenv("VALID_KEY_1"), $help->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $help->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $help->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $help->getTitled()));
        $this->assertNull($help->getDescription(), testErrorManager::cerr_null($help->getDescription()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Help::__constructor with invalid ID
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(HelpExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Help(
            $id,
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );
    }

    // * GET * //
    /**
     * Public function testing Help::getId
     */
    public function testGetId(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $help->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $help->getId()));
    }

    /**
     * Public function testing Help::getTitled
     */
    public function testGetTitled(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("HELP_TITLED"), $help->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $help->getTitled()));
    }

    /**
     * Public function testing Help::getDescription
     */
    public function testGetDescription(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $this->assertEquals(getenv("HELP_DESCRIPTION"), $help->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $help->getDescription()));
    }

    // * CONVERT * //
    /**
     * Public function testing User::fromArray
     *
     * @return void
     */
    public function testFromArrayWithValidData(): void {
        $data = [
            "Id"          => getenv("VALID_KEY_1"),
            "Titled"      => getenv("HELP_TITLED"),
            "Description" => getenv("HELP_DESCRIPTION")
        ];

        $help = Help::fromArray($data);

        $this->assertInstanceOf(Help::class, $help);
        $this->assertEquals(getenv("VALID_KEY_1"), $help->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $help->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $help->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $help->getTitled()));
        $this->assertEquals(getenv("HELP_DESCRIPTION"), $help->getDescription(), testErrorManager::cerr_eq(getenv("HELP_DESCRIPTION"), $help->getDescription()));
    }

    /**
     * Public function testing Help::fromArray
     *
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(HelpExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'aide. Tableau de données absent.");

        Help::fromArray([]);
    }

    /**
     * Public function testing Help::toArray
     *
     * @return void
     */
    public function testToArray(): void {
        $help = new Help(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("HELP_DESCRIPTION")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "titled"      => getenv("HELP_TITLED"),
            "description" => getenv("HELP_DESCRIPTION")
        ];

        $this->assertEquals($expectedArray, $help->toArray());
    }
}