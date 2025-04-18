<?php

use PHPUnit\Framework\TestCase;
use App\Models\TypeOfActions;
use App\Exceptions\TypeOfActionsExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the TypeOfActions model class
* 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TypeOfActionsModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing TypesOfActions::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $type = new TypeOfActions(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertInstanceOf(TypeOfActions::class, $type);
        $this->assertEquals(getenv("VALID_KEY_1"), $type->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $type->getId()));
        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled()));
    }

    //// WITHOUT ////
    /**
     * Public function testing TypesOfActions::__constructor without Id
     * 
     * @return void
     */
    public function testCOnstructorWithoutId(): void {
        $type = new TypeOfActions(
            null,
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertInstanceOf(TypeOfActions::class, $type);
        $this->assertNull($type->getId(), testErrorManager::cerr_null($type->getId()));
        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing TypesOfActions::__constructor with invalid ID
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(TypeOfActionsExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new TypeOfActions(
            getenv("WRONG_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );
    }

    // * GET * //
    /**
     * Public function testing TypeOfActions::getId
     * 
     * @return void
     */
    public function testGetId(): void {
        $type = new TypeOfActions(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $type->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $type->getId()));
    }

    /**
     * Public function testing TypeOfActions::getTitled
     * 
     * @return void
     */
    public function testGetTitled(): void {
        $type = new TypeOfActions(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled()));
    }

    // * CONVERT * //
    /**
     * Public function testing TypesOfActions::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"     => getenv("VALID_KEY_1"),
            "Titled" => getenv("TYPES_OF_ACTIONS_TITLED")
        ];

        $type = TypeOfActions::fromArray($data);

        $this->assertInstanceOf(TypeOfActions::class, $type);
        $this->assertEquals(getenv("VALID_KEY_1"), $type->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $type->getId()));
        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $type->getTitled()));
    }

    /**
     * Public function testing TypesOfActions::fromArray with empty data
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(TypeOfActionsExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du type d'actions. Tableau de données absent.");

        TypeOfActions::fromArray([]);
    }

    /**
     * Public function testing TypesOfActions::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $type = new TypeOfActions(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $expectedArray = [
            "id"     => getenv("VALID_KEY_1"),
            "titled" => getenv("TYPES_OF_ACTIONS_TITLED")
        ];

        $this->assertEquals($expectedArray, $type->toArray());
    }
}