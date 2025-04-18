<?php 

use PHPUnit\Framework\TestCase;
use App\Models\Source;
use App\Exceptions\SourceExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Source model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr> 
 */
class SourceModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Source::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $source = new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Source::class, $source);
        $this->assertEquals(getenv("VALID_KEY_1"), $source->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $source->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $source->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $source->getTitled()));
        $this->assertEquals(getenv("VALID_KEY_2"), $source->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $source->getType()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Source::__constructor without Id
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $source = new Source(
            null,
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $this->assertInstanceOf(Source::class, $source);
        $this->assertNull($source->getId(), testErrorManager::cerr_null($source->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $source->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $source->getTitled()));
        $this->assertEquals(getenv("VALID_KEY_2"), $source->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $source->getType()));
    }

    //// WITH INVALI ////
    /**
     * Public function testing Source::__constructor with an invalid Id
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(SourceExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Source(
            $id,
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );
    }

    /**
     * Public function testing Source::__constructor with an invalid Type
     * 
     * @return void
     */
    public function testConstructorWithInvalidType(): void {
        $type = getenv("WRONG_KEY_1");
        $this->expectException(SourceExceptions::class);
        $this->expectExceptionMessage("Clé primaire du type de sources invalide : {$type}. Clé attendue strictement positive.");

        new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            $type
        );
    }

    // * GET * //
    /**
     * Public function testing Source::getId
     * 
     * @return void
     */
    public function testGetId(): void {
        $source = new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $source->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $source->getId()));
    }

    /**
     * Public function testing Source::getTitled
     * 
     * @return void
     */
    public function testGetTitled(): void {
        $source = new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("HELP_TITLED"), $source->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $source->getTitled()));
    }

    /**
     * Public function testing Source::getType
     * 
     * @return void
     */
    public function testGetType(): void {
        $source = new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $this->assertEquals(getenv("VALID_KEY_2"), $source->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $source->getType()));
    }

    // * CONVERT * //
    /**
     * Public function testing Source::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"               => getenv("VALID_KEY_1"),
            "Titled"           => getenv("HELP_TITLED"),
            "Types_of_sources" => getenv("VALID_KEY_2")
        ];

        $source = Source::fromArray($data);

        $this->assertInstanceOf(Source::class, $source);
        $this->assertEquals(getenv("VALID_KEY_1"), $source->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $source->getId()));
        $this->assertEquals(getenv("HELP_TITLED"), $source->getTitled(), testErrorManager::cerr_eq(getenv("HELP_TITLED"), $source->getTitled()));
        $this->assertEquals(getenv("VALID_KEY_2"), $source->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_2"), $source->getType()));
    }

    /**
     * Public function testing Source::fromArray without data
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(SourceExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de la source. Tableau de données absent.");

        Source::fromArray([]);
    }

    /**
     * Public function testing Source::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $source = new Source(
            getenv("VALID_KEY_1"),
            getenv("HELP_TITLED"),
            getenv("VALID_KEY_2")
        );

        $expectedArray = [
            "id"    => getenv("VALID_KEY_1"),
            "title" => getenv("HELP_TITLED"),
            "type"  => getenv("VALID_KEY_2")
        ];

        $this->assertEquals($expectedArray, $source->toArray());
    }
}