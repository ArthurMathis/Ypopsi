<?php

use PHPUnit\Framework\TestCase;
use App\Models\Action;
use App\Exceptions\ActionExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Action model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ActionModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Action::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Action::__constructor with null Id
     *
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $action = new Action(
            null, 
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertNull($action->getId(), testErrorManager::cerr_null($action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::__constructor with null Description
     * 
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            null,
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertNull($action->getDescription(), testErrorManager::cerr_null($action->getDescription()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::__constructor with null date
     * 
     * @return void
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
        $this->assertNull($action->getDate(), testErrorManager::cerr_null($action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    //// WITH INVALID ////

    /**
     * Public function testing Action::__constructor with invalid Id
     *
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Action(
            $id,
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );
    }

    /**
     * Public function testing Action::__constructor with invalid Date
     * 
     * @return void
     */
    public function testConstructorWithInvalidDate(): void {
        $date = getenv("WRONG_DATE_1");
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("La date invalide : {$date}.");

        new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            $date,
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );
    }

    /**
     * Public function testing Action::__constructor with invalid User
     * 
     * @return void
     */
    public function testConstructorWithInvalidUser(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$key}. Clé attendue strictement positive.");

        new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            $key,
            getenv("VALID_KEY_3")
        );
    }

    /**
     * Public function testing Action::__constructor with invalid type key
     * 
     * @return void
     */
    public function testConstructorWithInvalidType(): void {
        $key = getenv("WRONG_KEY_1");
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Clé primaire du type d'action invalide : {$key}. Clé attendue strictement positive.");

        new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            $key
        );
    }

    // * GET * //
    /**
     * Public function testing Action::getId
     */
    public function testGetId(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
    }

    /**
     * Public function testing Action::getDescription
     */
    public function testGetDescription(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
    }

    /**
     * Public function testing Action::getDate
     */
    public function testGetDate(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_FULL_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $action->getDate()));
    }

    /**
     * Public function testing Action::getUser
     */
    public function testGetUser(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
    }

    /**
     * Public function testing Action::getType
     */
    public function testGetType(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    // * CREATE * //
    /**
     * Public function testing Action::create
     * 
     * @return void
     */
    public function testCreate(): void {
        $action = Action::create(
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            getenv("ACTION_DESCRIPTION")
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertNull($action->getId(), testErrorManager::cerr_null($action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertNull($action->getDate(), testErrorManager::cerr_null($action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::create without Description
     * 
     * @return void
     */
    public function testCreateWithoutDescritpion(): void {
        $action = Action::create(
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3"),
            null
        );

        $this->assertInstanceOf(Action::class, $action);
        $this->assertNull($action->getId(), testErrorManager::cerr_null($action->getId()));
        $this->assertNull($action->getDescription(), testErrorManager::cerr_null($action->getDescription()));
        $this->assertNull($action->getDate(), testErrorManager::cerr_null($action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    // * CONVERT * //
    /**
     * Public function testing Action::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"                  => getenv("VALID_KEY_1"),
            "Description"         => getenv("ACTION_DESCRIPTION"),
            "Moment"              => getenv("VALID_FULL_DATE"),
            "Key_Users"           => getenv("VALID_KEY_2"),
            "Key_Types_of_actions"=> getenv("VALID_KEY_3")
        ];

        $action = Action::fromArray($data);

        $this->assertInstanceOf(Action::class, $action);
        $this->assertEquals(getenv("VALID_KEY_1"), $action->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $action->getId()));
        $this->assertEquals(getenv("ACTION_DESCRIPTION"), $action->getDescription(), testErrorManager::cerr_eq(getenv("ACTION_DESCRIPTION"), $action->getDescription()));
        $this->assertEquals(getenv("VALID_FULL_DATE"), $action->getDate(), testErrorManager::cerr_eq(getenv("VALID_FULL_DATE"), $action->getDate()));
        $this->assertEquals(getenv("VALID_KEY_2"), $action->getUser(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $action->getUser()));
        $this->assertEquals(getenv("VALID_KEY_3"), $action->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_3"), $action->getType()));
    }

    /**
     * Public function testing Action::fromArray with empty data
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(ActionExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de l'action. Tableau de données absent.");

        Action::fromArray([]);
    }

    /**
     * Public function testing Action::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $action = new Action(
            getenv("VALID_KEY_1"),
            getenv("ACTION_DESCRIPTION"),
            getenv("VALID_FULL_DATE"),
            getenv("VALID_KEY_2"),
            getenv("VALID_KEY_3")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "description" => getenv("ACTION_DESCRIPTION"),
            "date"        => getenv("VALID_FULL_DATE"),
            "user"        => getenv("VALID_KEY_2"),
            "type"        => getenv("VALID_KEY_3")
        ];

        $this->assertEquals($expectedArray, $action->toArray());
    }
}
