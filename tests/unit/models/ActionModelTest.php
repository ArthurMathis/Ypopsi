<?php

use PHPUnit\Framework\TestCase;
use App\Models\Action;
use App\Exceptions\ActionExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Action model class
 */
class ActionModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Action::__constructor
     */
    public function testConstructor(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::__constructor with invalid user key
     */
    public function testConstructorWithInvalidUserKey(): void {
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : 0. Clé attendue strictement positive.");

        new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_DATE"),
            getenv("INVALID_KEY_1"),
            getenv("VALID_KEY_3")
        );
    }

    /**
     * Public function testing Action::__constructor with invalid type key
     */
    public function testConstructorWithInvalidTypeKey(): void {
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Clé primaire du type d'action invalide : 0. Clé attendue strictement positive.");

        new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("INVALID_KEY_1")
        );
    }

    /**
     * Public function testing Action::__constructor without ID
     */
    public function testConstructorWithoutId(): void {
        $action = new Action(
            null,
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(null, $action->getId(), testErrorManager::cerr_eq(null, $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::__constructor without description
     */
    public function testConstructorWithoutDescription(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            null,
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(null, $action->getDescription(), testErrorManager::cerr_eq(null, $action->getDescription()));
        $this->assertEquals(getenv("VALID_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::__constructor without date
     */
    public function testConstructorWithoutDate(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            null,
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(null, $action->getDate(), testErrorManager::cerr_eq(null, $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    // * CREATE * //
    /**
     * Public function testing Action::create
     */
    public function testCreate(): void {
        $action = Action::create(
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("ACTION_DESCRIPTION")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertNull($action->getId(), testErrorManager::cerr_eq(null, $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertNull($action->getDate(), testErrorManager::cerr_eq(null, $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    // * CONVERT * //
    /**
     * Public function testing Action::fromArray
     */
    public function testFromArray(): void {
        $data = [
            "Id"                  => getenv("VALID_KEY_1"),
            "Description"         => getenv("ACTION_DESCRIPTION"),
            "Moment"              => getenv("VALID_DATE"),
            "Key_Users"           => getenv("VALID_KEY_2"),
            "Key_Types_of_actions"=> getenv("VALID_KEY_3")
        ];

        $action = Action::fromArray($data);

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::fromArray with empty data
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'action. Tableau de données absent.");

        Action::fromArray([]);
    }

    /**
     * Public function testing Action::toArray
     */
    public function testToArray(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "description" => getenv("ACTION_DESCRIPTION"),
            "date"        => getenv("VALID_DATE"),
            "user"        => getenv("VALID_KEY_2"),
            "type"        => getenv("VALID_KEY_3")
        ];

        $this->assertEquals($expectedArray, $action->toArray());
    }
}
