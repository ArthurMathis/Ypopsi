<?php

include '../../define.php';
include 'TestsManipulations.php';
include '../../'.CLASSE.DS.'Contract.php';

define('KEY', 1);
define('CANDIDATE', 1);
define('JOB', 1);
define('SERVICE', 1);
define('ESTABLISHMENT', 1);
define('TYPE', 1);
define('START_DATE', '2024-10-05');
define('END_DATE', '2025-10-04');
define('SIGNATURE', '2024-10-06');
define('RESIGNATION_DATE', '2024-11-05');
define('HOURLY_RATE', 35);
define('SALARY', 1350);
define('NIGHT_WORK', TRUE);
define('WEEK_END_WORK', TRUE);

/**
 * Class testing the Candidate class
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TestsContracts extends TestsManipulation {
    /**
     * Public function running unit tests
     *
     * @return Void
     */
    public function run() {
        $this->writeH1("Tests de la classe Contract.php");
        $this->writeH2("Tests de constructeurs");
        $this->writeH3("Tests classiques");
        $this->testConstructorTrue();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - False");
        $this->testConstructorFalse1();
        $this->testConstructorFalse2();
        $this->testConstructorFalse3();
        $this->testConstructorFalse4();
        $this->testConstructorFalse5();
        $this->testConstructorFalse6();
        $this->testConstructorFalse7();
        $this->testConstructorFalse8();
        $this->testConstructorFalse9();
        $this->testConstructorFalse10();
        $this->testConstructorFalse11();
        $this->testConstructorFalse12();
        $this->testConstructorFalse13();
        $this->testConstructorFalse14();
        $this->testConstructorFalse15();
        $this->testConstructorFalse16();
        $this->testConstructorFalse17();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - Null");
        $this->testConstructorNull1();
        $this->testConstructorNull2();
        $this->testConstructorNull3();
        $this->testConstructorNull4();
        $this->testConstructorNull5();
        $this->testConstructorNull6();
        $this->writeSuccess();
    
        $this->writeH2("Tests de getters");
        $this->testGetKey();
        $this->testGetCandidate();
        $this->testGetService();
        $this->testGetEstablishment();
        $this->testGetType();
        $this->testGetStartDate();
        $this->writeSuccess();
    
        $this->writeH2("Tests de setters");
        $this->writeH3("Tests classique");
        $this->testSetKeyTrue();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - False");
        $this->testSetKeyFalse1();
        $this->testSetKeyFalse2();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - Null");
        $this->testSetKeyNull();
        $this->writeSuccess();
    
        $this->writeH2("Tests de makeContract");
        $this->writeH3("Tests classique");
        $this->testMakeContractWithoutTrue();
        $this->testMakeContractWithTrue1();
        $this->testMakeContractWithTrue2();
        $this->testMakeContractWithTrue3();
        $this->testMakeContractWithTrue4();
        $this->testMakeContractWithTrue5();
        $this->testMakeContractWithTrue6();
        $this->testMakeContractWithTrue7();
        $this->testMakeContractWithTrue8();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - False");
        $this->testMakeContractWithoutFalse1();
        $this->testMakeContractWithoutFalse2();
        $this->testMakeContractWithoutFalse3();
        $this->testMakeContractWithoutFalse4();
        $this->testMakeContractWithoutFalse5();
        $this->testMakeContractWithoutFalse6();
        $this->testMakeContractWithoutFalse7();
        $this->testMakeContractWithoutFalse8();
        $this->testMakeContractWithoutFalse9();
        $this->testMakeContractWithoutFalse10();
        $this->testMakeContractWithoutFalse11();
        $this->testMakeContractWithoutFalse12();
        $this->testMakeContractWithoutFalse13();
        $this->testMakeContractWithoutFalse14();
        $this->testMakeContractWithoutFalse15();
        $this->testMakeContractWithoutFalse16();
        $this->testMakeContractWithoutFalse17();
        $this->testMakeContractWithoutFalse18();
        $this->writeSuccess();

        $this->writeH3("Tests de détection des erreurs - Null");
        $this->testMakeContractWithoutNull1();
        $this->testMakeContractWithoutNull2();
        $this->testMakeContractWithoutNull3();
        $this->testMakeContractWithoutNull4();
        $this->testMakeContractWithoutNull5();
        $this->testMakeContractWithoutNull6();
        $this->writeSuccess();
    }

    // * CONSTRUCTOR * //
    /**
     * Fonction publique testant le bon fonctionnement du constructeur
     * 
     * Goal : Success
     *
     * @return Void
     */
    function testConstructorTrue() {
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $this->writeFailure('constructorTrue'); 
        }

        $this->successTest();
    }
    function testConstructorFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(-1, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Contract('Bonjour', JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, -1, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse4() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, 'Bonjour', SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse5() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, -1, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse6() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, 'Bonjour', ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse7() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, -1, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse8() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, 'Bonjour', TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse9() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, -1, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse10() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, 'Bonjour', START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse11() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, 1);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse12() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, 'Bonjour');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse13() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '24-08-05');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse14() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-8-5');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse15() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-28-02');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse16() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-08-52');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorFalse17() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '08-52');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull1() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(NULL, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull2() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, NULL, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull3() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, NULL, ESTABLISHMENT, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull4() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, NULL, TYPE, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull5() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, NULL, START_DATE);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testConstructorNull6() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, NULL);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    
    function testGetKey() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        $c->setKey(KEY);
        if($c->getKey() === KEY)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testGetCandidate() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        if($c->getCandidate() === CANDIDATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testGetService() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        if($c->getService() === SERVICE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testGetEstablishment() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        if($c->getEstablishment() === ESTABLISHMENT)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testGetType() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        if($c->getType() === TYPE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testGetStartDate() {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        if($c->getStartDate() === START_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    
    function testSetKeyTrue() {
        $res = $this->SUCCESS();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
            $c->setKey(KEY);
        } catch(Exception) {
            $res = $this->FAILURE();
        }
    
        if($res && $c->getKey() === KEY)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testSetKeyFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
            $c->setKey('Bonjour');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
    
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testSetKeyFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
            $c->setKey(-12);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
    
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testSetKeyNull() {
        $res = $this->FAILURE();
        try {
            $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
            $c->setKey(NULL);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
    
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    
    function testMakeContractWithoutTrue() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getCandidate() === CANDIDATE && $c->getJob() === JOB && $c->getService() === SERVICE && $c->getEstablishment() === ESTABLISHMENT && $c->getType() === TYPE && $c->getStartDate() === START_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse1() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => '-1',
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse2() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => -1,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse3() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => 'Bonjour',
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse4() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => '-1', 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse5() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => -1, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse6() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => 'Bonjour', 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse7() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => '-1',
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse8() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => -1,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse9() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => 'Bonjour',
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse10() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => '-1',
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse11() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => -1,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse12() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => 'Bonjour',
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse13() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => '-1', 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse14() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => -1, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse15() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => 'Bonjour', 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse16() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => 252654
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse17() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => 'Bonjour'
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutFalse18() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start date' => '24-25-25'
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull1() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => NULL,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull2() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => NULL, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull3() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => NULL,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull4() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => NULL,
                'type' => TYPE,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull5() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => NULL,
                'start_date' => START_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithoutNull6() {
        $res = $this->FAILURE();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => NULL
            ]);
    
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    
    function testMakeContractWithTrue1() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'end_date' => END_DATE
            ]);
    
        } catch(Exception $e) {
            echo '<h2>Erreur -> ' . $e->getMessage() . '</h2>';
            $res = $this->FAILURE();
        }
        
        if($res && $c->getEndDate() === END_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue2() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'end_date' => END_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getEndDate() === END_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue3() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'resignation_date' => RESIGNATION_DATE
            ]);
    
        } catch(Exception $e) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getResignationDate() === RESIGNATION_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue4() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'signature' => SIGNATURE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getSignature() === SIGNATURE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue5() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'signature' => SIGNATURE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getSignature() === SIGNATURE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue6() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'salary' => SALARY
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getSalary() === SALARY)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue7() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'end_date' => END_DATE,
                'resignation_date' => RESIGNATION_DATE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getEndDate() === END_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
    function testMakeContractWithTrue8() {
        $res = $this->SUCCESS();
        try {
            $c = Contract::makeContract([
                'candidate' => CANDIDATE,
                'job' => JOB, 
                'service' => SERVICE,
                'establishment' => ESTABLISHMENT,
                'type' => TYPE,
                'start_date' => START_DATE,
                'end_date' => END_DATE,
                'signature' => SIGNATURE
            ]);
    
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res && $c->getEndDate() === END_DATE)
            $this->successTest();
        else 
            $this->writeFailure('constructorTrue'); 
    }
}

(new TestsContracts())->run();