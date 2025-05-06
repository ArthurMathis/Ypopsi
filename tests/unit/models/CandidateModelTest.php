<?php

use PHPUnit\Framework\TestCase;
use App\Models\Candidate;
use App\Exceptions\CandidateExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Candidate model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class CandidateModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Candidate::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Candidate::__constructor without id
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $candidate = new Candidate(
            id          : null,
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertNull($candidate->getId(), testErrorManager::cerr_null($candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without name
     * 
     * @return void
     */
    public function testConstructorWithoutName(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : null,
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertNull($candidate->getName(), testErrorManager::cerr_null($candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without firstname
     * 
     * @return void
     */
    public function testConstructorWithoutFirstname(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : null,
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertNull($candidate->getFirstname(), testErrorManager::cerr_null($candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without name and firstname
     * 
     * @return void
     */
    public function testConstructorWithoutNameAndFirstname(): void {
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("Impossible de générer un candidat sans nom et sans prénom.");

        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : null,
            firstname   : null,
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
    }

    /**
     * Public function testing Candidate::__constructor without gender
     * 
     * @return void
     */
    public function testConstructorWithoutGender(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : null,
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertNull($candidate->getGender(), testErrorManager::cerr_null($candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without email
     * 
     * @return void
     */
    public function testConstructorWithoutEmail(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : null,
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertNull($candidate->getEmail(), testErrorManager::cerr_null($candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without phone
     * 
     * @return void
     */
    public function testConstructorWithoutPhone(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : null,
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertNull($candidate->getPhone(), testErrorManager::cerr_null($candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without address
     * 
     * @return void
     */
    public function testConstructorWithoutAddress(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : null,
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertNull($candidate->getAddress(), testErrorManager::cerr_null($candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without city
     * 
     * @return void
     */
    public function testConstructorWithoutCity(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : null,
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertNull($candidate->getCity(), testErrorManager::cerr_null($candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without postcode
     * 
     * @return void
     */
    public function testConstructorWithoutPostcode(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : null,
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertNull($candidate->getPostcode(), testErrorManager::cerr_null($candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without availability
     * 
     * @return void
     */
    public function testConstructorWithoutAvailability(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: null,
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertNull($candidate->getAvailability(), testErrorManager::cerr_null($candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without visit
     * 
     * @return void
     */
    public function testConstructorWithoutVisit(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : null,
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertNull($candidate->getVisit(), testErrorManager::cerr_null($candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without rating
     * 
     * @return void
     */
    public function testConstructorWithoutRating(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : null,
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertNull($candidate->getRating(), testErrorManager::cerr_null($candidate->getRating()));
        $this->assertEquals(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription(), testErrorManager::cerr_eq(getenv("CANDIDATE_DESCRIPTION"), $candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    /**
     * Public function testing Candidate::__constructor without description
     * 
     * @return void
     */
    public function testConstructorWithoutDescription(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : null,
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
        $this->assertEquals(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname(), testErrorManager::cerr_eq(getenv("VALID_FIRSTNAME_1"), $candidate->getFirstname()));
        $this->assertEquals(getenv("MALE_GENDER"), $candidate->getGender(), testErrorManager::cerr_eq(getenv("MALE_GENDER"), $candidate->getGender()));
        $this->assertEquals(getenv("VALID_EMAIL_1"), $candidate->getEmail(), testErrorManager::cerr_eq(getenv("VALID_EMAIL_1"), $candidate->getEmail()));
        $this->assertEquals(getenv("VALID_PHONE"), $candidate->getPhone(), testErrorManager::cerr_eq(getenv("VALID_PHONE"), $candidate->getPhone()));
        $this->assertEquals(getenv("VALID_ADDRESS"), $candidate->getAddress(), testErrorManager::cerr_eq(getenv("VALID_ADDRESS"), $candidate->getAddress()));
        $this->assertEquals(getenv("VALID_CITY"), $candidate->getCity(), testErrorManager::cerr_eq(getenv("VALID_CITY"), $candidate->getCity()));
        $this->assertEquals(getenv("VALID_POSTCODE"), $candidate->getPostcode(), testErrorManager::cerr_eq(getenv("VALID_POSTCODE"), $candidate->getPostcode()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getAvailability(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getAvailability()));
        $this->assertEquals(getenv("VALID_DATE"), $candidate->getVisit(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $candidate->getVisit()));
        $this->assertEquals(getenv("VALID_RATING"), $candidate->getRating(), testErrorManager::cerr_eq(getenv("VALID_RATING"), $candidate->getRating()));
        $this->assertNull($candidate->getDescription(), testErrorManager::cerr_null($candidate->getDescription()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_DELETED"), $candidate->getDeleted()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_A"), $candidate->getA(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_A"), $candidate->getA()));
        $this->assertEquals(getenv("CANDIDATE_FALSE_B"), $candidate->getB(), testErrorManager::cerr_eq(getenv("CANDIDATE_FALSE_B"), $candidate->getB()));
        $this->assertEquals(getenv("CANDIDATE_TRUE_C"), $candidate->getC(), testErrorManager::cerr_eq(getenv("CANDIDATE_TRUE_C"), $candidate->getC()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Candidate::__constructor with invalid id
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("La clé primaire : {$id} est invalide.");

        new Candidate(
            id          : $id,
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid name
     * 
     * @return void
     */
    public function testConstructorWithInvalidName(): void {
        $name = getenv("WRONG_NAME");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("Le nom : {$name} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : $name,
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid firstname
     * 
     * @return void
     */
    public function testConstructorWithInvalidFirstname(): void {
        $firstname = getenv("WRONG_FIRSTNAME");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("Le prénom : {$firstname} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : $firstname,
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid email
     * 
     * @return void
     */
    public function testConstructorWithInvalidEmail(): void {
        $email = getenv("WRONG_EMAIL_1");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("L'email : {$email} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : $email,
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid phone
     * 
     * @return void
     */
    public function testConstructorWithInvalidPhone(): void {
        $phone = getenv("WRONG_PHONE");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("Le numéro de téléphone : {$phone} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : $phone,
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid city
     * 
     * @return void
     */
    public function testConstructorWithInvalidCity(): void {
        $city = getenv("WRONG_CITY");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("La ville : {$city} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : $city,
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid postcode
     * 
     * @return void
     */
    public function testConstructorWithInvalidPostcode(): void {
        $postcode = getenv("WRONG_POSTCODE");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("Le code postal : {$postcode} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : $postcode,
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid availability
     * 
     * @return void
     */
    public function testConstructorWithInvalidAvailability(): void {
        $availability = getenv("WRONG_DATE_1");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("La date de disponibilité : {$availability} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: $availability,
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid visit
     * 
     * @return void
     */
    public function testConstructorWithInvalidVisit(): void {
        $visit = getenv("WRONG_DATE_1");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("La date de visite médicale : {$visit} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : $visit,
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    /**
     * Public function testing Candidate::__constructor with invalid rating
     * 
     * @return void
     */
    public function testConstructorWithInvalidRating(): void {
        $rating = getenv("WRONG_RATING");
        $this->expectException(CandidateExceptions::class);
        $this->expectExceptionMessage("La notation : {$rating} est invalide.");

        new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : $rating,
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );
    }

    // * GET * //
    /**
     * Public function testing Candidate::getId
     * 
     * @return void
     */
    public function testGetId(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
    }

    // Add similar tests for other getter methods...

    // * CREATE * //
    /**
     * Public function testing Candidate::create
     * 
     * @return void
     */
    public function testCreate(): void {
        $candidate = Candidate::create(
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE")
        );

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertNull($candidate->getId(), testErrorManager::cerr_null($candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
    }

    // * CONVERT * //
    /**
     * Public function testing Candidate::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $candidate = new Candidate(
            id          : getenv("VALID_KEY_1"),
            name        : getenv("VALID_NAME"),
            firstname   : getenv("VALID_FIRSTNAME_1"),
            gender      : getenv("MALE_GENDER"),
            email       : getenv("VALID_EMAIL_1"),
            phone       : getenv("VALID_PHONE"),
            address     : getenv("VALID_ADDRESS"),
            city        : getenv("VALID_CITY"),
            postcode    : getenv("VALID_POSTCODE"),
            availability: getenv("VALID_DATE"),
            visit       : getenv("VALID_DATE"),
            rating      : getenv("VALID_RATING"),
            description : getenv("CANDIDATE_DESCRIPTION"),
            deleted     : getenv("CANDIDATE_FALSE_DELETED"),
            a           : getenv("CANDIDATE_TRUE_A"),
            b           : getenv("CANDIDATE_FALSE_B"),
            c           : getenv("CANDIDATE_TRUE_C")
        );

        $expectedArray = [
            "id"           => getenv("VALID_KEY_1"),
            "name"         => getenv("VALID_NAME"),
            "firstname"    => getenv("VALID_FIRSTNAME_1"),
            "gender"       => getenv("MALE_GENDER"),
            "email"        => getenv("VALID_EMAIL_1"),
            "phone"        => getenv("VALID_PHONE"),
            "address"      => getenv("VALID_ADDRESS"),
            "city"         => getenv("VALID_CITY"),
            "postcode"     => getenv("VALID_POSTCODE"),
            "availability" => getenv("VALID_DATE"),
            "visit"        => getenv("VALID_DATE"),
            "rating"       => getenv("VALID_RATING"),
            "description"  => getenv("CANDIDATE_DESCRIPTION"),
            "deleted"      => false,
            "a"            => true,
            "b"            => false,
            "c"            => true
        ];

        $this->assertEquals($expectedArray, $candidate->toArray());
    }

    /**
     * Public function testing Candidate::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"           => getenv("VALID_KEY_1"),
            "Name"         => getenv("VALID_NAME"),
            "Firstname"    => getenv("VALID_FIRSTNAME_1"),
            "Gender"       => getenv("MALE_GENDER"),
            "Email"        => getenv("VALID_EMAIL_1"),
            "Phone"        => getenv("VALID_PHONE"),
            "Address"      => getenv("VALID_ADDRESS"),
            "City"         => getenv("VALID_CITY"),
            "PostCode"     => getenv("VALID_POSTCODE"),
            "Availability" => getenv("VALID_DATE"),
            "MedicalVisit" => getenv("VALID_DATE"),
            "Rating"       => getenv("VALID_RATING"),
            "Description"  => getenv("CANDIDATE_DESCRIPTION"),
            "Is_delete"    => false,
            "A"            => true,
            "B"            => false,
            "C"            => true
        ];

        $candidate = Candidate::fromArray($data);

        $this->assertInstanceOf(Candidate::class, $candidate);
        $this->assertEquals(getenv("VALID_KEY_1"), $candidate->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $candidate->getId()));
        $this->assertEquals(getenv("VALID_NAME"), $candidate->getName(), testErrorManager::cerr_eq(getenv("VALID_NAME"), $candidate->getName()));
    }
}