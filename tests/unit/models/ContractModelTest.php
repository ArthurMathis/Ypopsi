<?php

use PHPUnit\Framework\TestCase;
use App\Models\Contract;
use App\Exceptions\ContractExceptions;
use App\Core\Tools\testErrorManager;

/**
 * Suite case for the Contract model class
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class ContractModelTest extends TestCase {
    // * CONSTRUCTOR * //
    /**
     * Public function testing Contract::__constructor
     * 
     * @return void
     */
    public function testConstructor(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getStartDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getStartDate()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getEndDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getEndDate()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getProposition(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getProposition()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getSignature(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getSignature()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getResignation(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getResignation()));
        $this->assertFalse($contract->getRefused(), testErrorManager::cerr_eq(false, $contract->getRefused()));
        $this->assertEquals(getenv("VALID_SALARY"), $contract->getSalary(), testErrorManager::cerr_eq(getenv("VALID_SALARY"), $contract->getSalary()));
        $this->assertEquals(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate(), testErrorManager::cerr_eq(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate()));
        $this->assertTrue($contract->getNightWork(), testErrorManager::cerr_eq(true, $contract->getNightWork()));
        $this->assertFalse($contract->getWkWork(), testErrorManager::cerr_eq(false, $contract->getWkWork()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getEstbalishement(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getEstbalishement()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getType()));
    }

    //// WITHOUT ////
    /**
     * Public function testing Contract::__constructor without id
     * 
     * @return void
     */
    public function testConstructorWithoutId(): void {
        $contract = new Contract(
            id               : null,
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getId(), testErrorManager::cerr_null($contract->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getStartDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getStartDate()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getEndDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getEndDate()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getProposition(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getProposition()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getSignature(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getSignature()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getResignation(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getResignation()));
        $this->assertFalse($contract->getRefused(), testErrorManager::cerr_eq(false, $contract->getRefused()));
        $this->assertEquals(getenv("VALID_SALARY"), $contract->getSalary(), testErrorManager::cerr_eq(getenv("VALID_SALARY"), $contract->getSalary()));
        $this->assertEquals(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate(), testErrorManager::cerr_eq(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate()));
        $this->assertTrue($contract->getNightWork(), testErrorManager::cerr_eq(true, $contract->getNightWork()));
        $this->assertFalse($contract->getWkWork(), testErrorManager::cerr_eq(false, $contract->getWkWork()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getCandidate()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getJob()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getService()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getEstbalishement(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getEstbalishement()));
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getType()));
    }

    /**
     * Public function testing Contract::__constructor without end date
     * 
     * @return void
     */
    public function testConstructorWithoutEndDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : null,
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getEndDate(), testErrorManager::cerr_null($contract->getEndDate()));
    }
    
    /**
     * Public function testing Contract::__constructor without proposition date
     * 
     * @return void
     */
    public function testConstructorWithoutPropositionDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : null,
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getProposition(), testErrorManager::cerr_null($contract->getProposition()));
    }

    /**
     * Public function testing Contract::__constructor without signature date
     * 
     * @return void
     */
    public function testConstructorWithoutSignatureDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : null,
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getSignature(), testErrorManager::cerr_null($contract->getSignature()));
    }

    /**
     * Public function testing Contract::__constructor without resignation date
     * 
     * @return void
     */
    public function testConstructorWithoutResignationDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : null,
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getResignation(), testErrorManager::cerr_null($contract->getResignation()));
    }

    /**
     * Public function testing Contract::__constructor without salary
     * 
     * @return void
     */
    public function testConstructorWithoutSalary(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : null,
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getSalary(), testErrorManager::cerr_null($contract->getSalary()));
    }

    /**
     * Public function testing Contract::__constructor without hourly rate
     * 
     * @return void
     */
    public function testConstructorWithoutHourlyRate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : null,
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getHourlyRate(), testErrorManager::cerr_null($contract->getHourlyRate()));
    }

    //// WITH INVALID ////
    /**
     * Public function testing Contract::__constructor with invalid id
     * 
     * @return void
     */
    public function testConstructorWithInvalidId(): void {
        $id = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire invalide : {$id}. Clé attendue strictement positive.");

        new Contract(
            id               : $id,
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid start date
     * 
     * @return void
     */
    public function testConstructorWithInvalidStartDate(): void {
        $startDate = getenv("WRONG_DATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Date de début invalide : {$startDate}.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : $startDate,
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid end date
     * 
     * @return void
     */
    public function testConstructorWithInvalidEndDate(): void {
        $endDate = getenv("WRONG_DATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Date de fin invalide : {$endDate}.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : $endDate,
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid proposition date
     * 
     * @return void
     */
    public function testConstructorWithInvalidPropositionDate(): void {
        $propositionDate = getenv("WRONG_DATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Date de proposition invalide : {$propositionDate}.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : $propositionDate,
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid signature date
     * 
     * @return void
     */
    public function testConstructorWithInvalidSignatureDate(): void {
        $signatureDate = getenv("WRONG_DATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Date de signature invalide : {$signatureDate}.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : $signatureDate,
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid resignation date
     * 
     * @return void
     */
    public function testConstructorWithInvalidResignationDate(): void {
        $resignationDate = getenv("WRONG_DATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Date de démission invalide : {$resignationDate}.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : $resignationDate,
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid salary
     * 
     * @return void
     */
    public function testConstructorWithInvalidSalary(): void {
        $salary = getenv("INVALID_SALARY");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Salaire invalide : {$salary}. Salaire attendu strictement positif.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : $salary,
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid hourly rate
     * 
     * @return void
     */
    public function testConstructorWithInvalidHourlyRate(): void {
        $hourlyRate = getenv("INVALID_HOURLY_RATE");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Taux horaire invalide : {$hourlyRate}. Taux horaire attendu entre 0 et 48.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : $hourlyRate,
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid candidate
     * 
     * @return void
     */
    public function testConstructorWithInvalidCandidate(): void {
        $candidateKey = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$candidateKey}. Clé attendue strictement positive.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : $candidateKey,
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid job
     * 
     * @return void
     */
    public function testConstructorWithInvalidJob(): void {
        $jobKey = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$jobKey}. Clé attendue strictement positive.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : $jobKey,
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid service
     * 
     * @return void
     */
    public function testConstructorWithInvalidService(): void {
        $serviceKey = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$serviceKey}. Clé attendue strictement positive.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : $serviceKey,
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid establishment
     * 
     * @return void
     */
    public function testConstructorWithInvalidEstablishment(): void {
        $establishmentKey = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$establishmentKey}. Clé attendue strictement positive.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: $establishmentKey,
            type_key         : getenv("VALID_KEY_1")
        );
    }

    /**
     * Public function testing Contract::__constructor with invalid type
     * 
     * @return void
     */
    public function testConstructorWithInvalidType(): void {
        $typeKey = getenv("WRONG_KEY_1");
        $this->expectException(ContractExceptions::class);
        $this->expectExceptionMessage("Clé primaire de l'utilisateur invalide : {$typeKey}. Clé attendue strictement positive.");

        new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : $typeKey
        );
    }

    // * GET * //
    /**
     * Public function testing Contract::getId
     * 
     * @return void
     */
    public function testGetId(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
    }

    /**
     * Public function testing Contract::getStartDate
     * 
     * @return void
     */
    public function testGetStartDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $contract->getStartDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getStartDate()));
    }

    /**
     * Public function testing Contract::getEndDate
     * 
     * @return void
     */
    public function testGetEndDate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $contract->getEndDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getEndDate()));
    }

    /**
     * Public function testing Contract::getProposition
     * 
     * @return void
     */
    public function testGetProposition(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $contract->getProposition(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getProposition()));
    }

    /**
     * Public function testing Contract::getSignature
     * 
     * @return void
     */
    public function testGetSignature(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $contract->getSignature(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getSignature()));
    }

    /**
     * Public function testing Contract::getResignation
     * 
     * @return void
     */
    public function testGetResignation(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_DATE"), $contract->getResignation(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getResignation()));
    }

    /**
     * Public function testing Contract::getRefused
     * 
     * @return void
     */
    public function testGetRefused(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : true,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertTrue($contract->getRefused(), testErrorManager::cerr_eq(true, $contract->getRefused()));
    }

    /**
     * Public function testing Contract::getSalary
     * 
     * @return void
     */
    public function testGetSalary(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_SALARY"), $contract->getSalary(), testErrorManager::cerr_eq(getenv("VALID_SALARY"), $contract->getSalary()));
    }

    /**
     * Public function testing Contract::getHourlyRate
     * 
     * @return void
     */
    public function testGetHourlyRate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate(), testErrorManager::cerr_eq(getenv("VALID_HOURLY_RATE"), $contract->getHourlyRate()));
    }

    /**
     * Public function testing Contract::getNightWork
     * 
     * @return void
     */
    public function testGetNightWork(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertTrue($contract->getNightWork(), testErrorManager::cerr_eq(true, $contract->getNightWork()));
    }

    /**
     * Public function testing Contract::getWkWork
     * 
     * @return void
     */
    public function testGetWkWork(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : true,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertTrue($contract->getWkWork(), testErrorManager::cerr_eq(true, $contract->getWkWork()));
    }

    /**
     * Public function testing Contract::getCandidate
     * 
     * @return void
     */
    public function testGetCandidate(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getCandidate(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getCandidate()));
    }

    /**
     * Public function testing Contract::getJob
     * 
     * @return void
     */
    public function testGetJob(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getJob(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getJob()));
    }

    /**
     * Public function testing Contract::getService
     * 
     * @return void
     */
    public function testGetService(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getService(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getService()));
    }

    /**
     * Public function testing Contract::getEstablishment
     * 
     * @return void
     */
    public function testGetEstablishment(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getEstbalishement(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getEstbalishement()));
    }

    /**
     * Public function testing Contract::getType
     * 
     * @return void
     */
    public function testGetType(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getType(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getType()));
    }

    // * CREATE * //
    /**
     * Public function testing Contract::create
     * 
     * @return void
     */
    public function testCreate(): void {
        $contract = Contract::create(
            candidate     : getenv("VALID_KEY_1"),
            job           : getenv("VALID_KEY_1"),
            service       : getenv("VALID_KEY_1"),
            estbalishement: getenv("VALID_KEY_1"),
            type          : getenv("VALID_KEY_1"),
            start_date    : getenv("VALID_DATE"),
            end_date      : null,
            salary        : getenv("VALID_SALARY"),
            hourly_rate   : getenv("VALID_HOURLY_RATE"),
            night_work    : true,
            wk_work       : false,
            signature     : null
        );

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertNull($contract->getId(), testErrorManager::cerr_null($contract->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getStartDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getStartDate()));
    }

    // * CONVERT * //
    /**
     * Public function testing Contract::toArray
     * 
     * @return void
     */
    public function testToArray(): void {
        $contract = new Contract(
            id               : getenv("VALID_KEY_1"),
            start_date       : getenv("VALID_DATE"),
            end_date         : getenv("VALID_DATE"),
            proposition_date : getenv("VALID_DATE"),
            signature_date   : getenv("VALID_DATE"),
            resignation_date : getenv("VALID_DATE"),
            refused          : false,
            salary           : getenv("VALID_SALARY"),
            hourly_rate      : getenv("VALID_HOURLY_RATE"),
            night_work       : true,
            wk_work          : false,
            candidate_key    : getenv("VALID_KEY_1"),
            job_key          : getenv("VALID_KEY_1"),
            service_key      : getenv("VALID_KEY_1"),
            establishment_key: getenv("VALID_KEY_1"),
            type_key         : getenv("VALID_KEY_1")
        );

        $expectedArray = [
            "id"            => getenv("VALID_KEY_1"),
            "start_date"    => getenv("VALID_DATE"),
            "end_date"      => getenv("VALID_DATE"),
            "proposition"   => getenv("VALID_DATE"),
            "signature"     => getenv("VALID_DATE"),
            "resignation"   => getenv("VALID_DATE"),
            "refused"       => false,
            "salary"        => getenv("VALID_SALARY"),
            "hourly_rate"   => getenv("VALID_HOURLY_RATE"),
            "night_work"    => true,
            "wk_work"       => false,
            "candidate"     => getenv("VALID_KEY_1"),
            "job"           => getenv("VALID_KEY_1"),
            "service"       => getenv("VALID_KEY_1"),
            "establishment" => getenv("VALID_KEY_1"),
            "type"          => getenv("VALID_KEY_1")
        ];

        $this->assertEquals($expectedArray, $contract->toArray());
    }

    /**
     * Public function testing Contract::fromArray
     * 
     * @return void
     */
    public function testFromArray(): void {
        $data = [
            "Id"                     => getenv("VALID_KEY_1"),
            "StartDate"              => getenv("VALID_DATE"),
            "EndDate"                => getenv("VALID_DATE"),
            "PropositionDate"        => getenv("VALID_DATE"),
            "SignatureDate"          => getenv("VALID_DATE"),
            "ResignationDate"        => getenv("VALID_DATE"),
            "IsRefused"              => false,
            "Salary"                 => getenv("VALID_SALARY"),
            "HourlyRate"             => getenv("VALID_HOURLY_RATE"),
            "NightWork"              => true,
            "WeekEndWork"            => false,
            "Key_Candidates"         => getenv("VALID_KEY_1"),
            "Key_Jobs"               => getenv("VALID_KEY_1"),
            "Key_Services"           => getenv("VALID_KEY_1"),
            "Key_Establishments"     => getenv("VALID_KEY_1"),
            "Key_Types_of_contracts" => getenv("VALID_KEY_1")
        ];

        $contract = Contract::fromArray($data);

        $this->assertInstanceOf(Contract::class, $contract);
        $this->assertEquals(getenv("VALID_KEY_1"), $contract->getId(), testErrorManager::cerr_eq(getenv("VALID_KEY_1"), $contract->getId()));
        $this->assertEquals(getenv("VALID_DATE"), $contract->getStartDate(), testErrorManager::cerr_eq(getenv("VALID_DATE"), $contract->getStartDate()));
    }
}