<?php 

use PHPUnit\Framework\TestCase;
use App\Models\Qualification;
use App\Exceptions\QualificationExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Qualification model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class QualificationModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Qualification::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertInstanceOf(Qualification::class, $qualification);
        $this->assertEquals(getenv("VALID_KEY_1"), $qualification->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $qualification->getId()));
        $this->assertEquals(getenv("QUALIFICATION_TITLED"), $qualification->getTitle(), testErrorManager::cerr_eq(getenv("QUALIFICATION_TITLED"), $qualification->getTitle()));
        $this->assertEquals(getenv("QUALIFICATION_MEDICAL_STAFF"), $qualification->getMedical(), testErrorManager::cerr_eq((string) getenv("QUALIFICATION_ABREVIATION"), (string) $qualification->getMedical()));
        $this->assertEquals(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation(), testErrorManager::cerr_eq(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Qualification::__constructor without Id
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $qualification = new Qualification(
            null,
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertInstanceOf(Qualification::class, $qualification);
        $this->assertNull($qualification->getId(), testErrorManager::cerr_null($qualification->getId()));
        $this->assertEquals(getenv("QUALIFICATION_TITLED"), $qualification->getTitle(), testErrorManager::cerr_eq(getenv("QUALIFICATION_TITLED"), $qualification->getTitle()));
        $this->assertEquals(getenv("QUALIFICATION_MEDICAL_STAFF"), $qualification->getMedical(), testErrorManager::cerr_eq((string) getenv("QUALIFICATION_MEDICAL_STAFF"), $qualification->getMedical()));
        $this->assertEquals(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation(), testErrorManager::cerr_eq(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation()));
    }

    /**
     * Public function testing Qualification::__constructor without Abreviation
     * 
     * @return void
     */
    public function testConstructorWithoutAbreviation(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            null
        );

        $this->assertInstanceOf(Qualification::class, $qualification);
        $this->assertEquals(getenv("VALID_KEY_1"), $qualification->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $qualification->getId()));
        $this->assertEquals(getenv("QUALIFICATION_TITLED"), $qualification->getTitle(), testErrorManager::cerr_eq(getenv("QUALIFICATION_TITLED"), $qualification->getTitle()));
        $this->assertEquals(getenv("QUALIFICATION_MEDICAL_STAFF"), $qualification->getMedical(), testErrorManager::cerr_eq((string) getenv("QUALIFICATION_MEDICAL_STAFF"), (string) $qualification->getMedical()));
        $this->assertNull($qualification->getAbreviation(), testErrorManager::cerr_null($qualification->getAbreviation()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Qualification::__constructor with an invalid Id
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(QualificationExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Qualification(
            $id,
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );
    }

    // * GET * //
    /**
     * Public function testing Qualification::getId
     */
    public function testGetId(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $qualification->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $qualification->getId()));
    }

    /**
     * Public function testing Qualification::getTitle
     */
    public function testGetTitle(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertEquals(getenv("QUALIFICATION_TITLED"), $qualification->getTitle(), testErrorManager::cerr_eq(getenv("QUALIFICATION_TITLED"), $qualification->getTitle()));
    }

    /**
     * Public function testing Qualification::getMedical
     */
    public function testGetMedical(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertEquals(getenv("QUALIFICATION_MEDICAL_STAFF"), $qualification->getMedical(), testErrorManager::cerr_eq((string)getenv("QUALIFICATION_MEDICAL_STAFF"), (string)$qualification->getMedical()));
    }

    /**
     * Public function testing Qualification::getAbreviation
     */
    public function testGetAbreviation(): void {
        $qualification = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $this->assertEquals(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation(), testErrorManager::cerr_eq(getenv("QUALIFICATION_ABREVIATION"), $qualification->getAbreviation()));
    }

    // * CONVERT * //
    /**
     * Public function testing Qualification::fromArray
     * 
     * @return void
     */
    public function testFromArray() : void {
        $data = [
            "Id"           => getenv("VALID_KEY_1"),
            "Titled"       => getenv("QUALIFICATION_TITLED"),
            "MedicalStaff" => getenv("QUALIFICATION_MEDICAL_STAFF"),
            "Abreviation"  => getenv("QUALIFICATION_ABREVIATION")
        ];

        $have = Qualification::fromArray($data);

        $this->assertInstanceOf(Qualification::class, $have);
        $this->assertEquals(getenv("VALID_KEY_1"), $have->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $have->getId()));
        $this->assertEquals(getenv("QUALIFICATION_TITLED"), $have->getTitle(), testErrorManager::cerr_eq(getenv("QUALIFICATION_TITLED"), $have->getTitle()));
        $this->assertEquals(getenv("QUALIFICATION_MEDICAL_STAFF"), $have->getMedical(), testErrorManager::cerr_eq(getenv("QUALIFICATION_MEDICAL_STAFF"), $have->getMedical()));
        $this->assertEquals(getenv("QUALIFICATION_ABREVIATION"), $have->getAbreviation(), testErrorManager::cerr_eq(getenv("QUALIFICATION_ABREVIATION"), $have->getAbreviation()));
    }

    /**
     * Public function testing Qualification::fromArray
     * 
     * @return void
     */
    public function testFromArrayWithEmptyData(): void {
        $this->expectException(QualificationExceptions::class);
        $this->expectExceptionMessage("Erreur lors de la génération de la qualification. Tableau de données absent.");

        Qualification::fromArray([]);
    }

    /**
     * Public function testing Qualification::toArray
     */
    public function testToArray(): void {
        $have = new Qualification(
            getenv("VALID_KEY_1"),
            getenv("QUALIFICATION_TITLED"),
            getenv("QUALIFICATION_MEDICAL_STAFF"),
            getenv("QUALIFICATION_ABREVIATION")
        );

        $expectedArray = [
            "id"          => getenv("VALID_KEY_1"),
            "titled"      => getenv("QUALIFICATION_TITLED"),
            "medical"    => getenv("QUALIFICATION_MEDICAL_STAFF"),
            "abreviation" => getenv("QUALIFICATION_ABREVIATION")
        ];

        $this->assertEquals($expectedArray, $have->toArray());
    }
}