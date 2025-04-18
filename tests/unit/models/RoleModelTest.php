<?php 

use PHPUnit\Framework\TestCase;
use App\Models\Role;
use App\Exceptions\RoleExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Role model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class RoleModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Role::__constructor
     */
    public function testConstructor(): void {
        $role = new Role(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals(getenv("VALID_KEY_1"), $role->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $role->getId()));
        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Role::__constructor with invalid ID
     */
    public function testConstructorWithInvalidId(): void {
        $this->expectException(RoleExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : 0. Clé attendue strictement positive.");

        new Role(
            getenv("WRONG_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );
    }

    // * GET * //
    /**
     * Public function testing Role::getId
     */
    public function testGetId(): void {
        $role = new Role(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $role->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $role->getId()));
    }

    /**
     * Public function testing Role::getTitled
     */
    public function testGetTitled(): void {
        $role = new Role(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled()));
    }

    // * CONVERT * //
    /**
     * Public function testing Role::fromArray
     */
    public function testFromArray(): void {
        $data = [
            "Id"     => getenv("VALID_KEY_1"),
            "Titled" => getenv("TYPES_OF_ACTIONS_TITLED")
        ];

        $role = Role::fromArray($data);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals(getenv("VALID_KEY_1"), $role->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $role->getId()));
        $this->assertEquals(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled(), testErrorManager::cerr_eq(getenv("TYPES_OF_ACTIONS_TITLED"), $role->getTitled()));
    }

    /**
     * Public function testing Role::fromArray with empty data
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(RoleExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération du rôle. Tableau de données absent.");

        Role::fromArray([]);
    }

    /**
     * Public function testing Role::toArray
     */
    public function testToArray(): void {
        $role = new Role(
            getenv("VALID_KEY_1"),
            getenv("TYPES_OF_ACTIONS_TITLED")
        );

        $expectedArray = [
            "id"     => getenv("VALID_KEY_1"),
            "titled" => getenv("TYPES_OF_ACTIONS_TITLED")
        ];

        $this->assertEquals($expectedArray, $role->toArray());
    }
}