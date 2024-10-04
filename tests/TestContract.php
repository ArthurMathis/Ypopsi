<?php

include '../define.php';
include '../'.CLASSE.DS.'Contract.php';

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

function testConstructorTrue() {
    $res = true;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorTrue</p>';
}
function testConstructorFalse1() {
    $res = false;
    try {
        $c = new Contract(-1, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse1</p>';
}
function testConstructorFalse2() {
    $res = false;
    try {
        $c = new Contract('Bonjour', JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse2</p>';
}
function testConstructorFalse3() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, -1, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse3</p>';
}
function testConstructorFalse4() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, 'Bonjour', SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse4</p>';
}
function testConstructorFalse5() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, -1, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse5</p>';
}
function testConstructorFalse6() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, 'Bonjour', ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse6</p>';
}
function testConstructorFalse7() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, -1, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse7</p>';
}
function testConstructorFalse8() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, 'Bonjour', TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse8</p>';
}
function testConstructorFalse9() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, -1, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse9</p>';
}
function testConstructorFalse10() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, 'Bonjour', START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse10</p>';
}
function testConstructorFalse11() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, 1);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse11</p>';
}
function testConstructorFalse12() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, 'Bonjour');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse12</p>';
}
function testConstructorFalse13() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '24-08-05');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse13</p>';
}
function testConstructorFalse14() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-8-5');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse14</p>';
}
function testConstructorFalse15() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-28-02');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse15</p>';
}
function testConstructorFalse16() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '2024-08-52');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse16</p>';
}
function testConstructorFalse17() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, '08-52');
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse17</p>';
}
function testConstructorNull1() {
    $res = false;
    try {
        $c = new Contract(NULL, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull1</p>';
}
function testConstructorNull2() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, NULL, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull2</p>';
}
function testConstructorNull3() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, NULL, ESTABLISHMENT, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull3</p>';
}
function testConstructorNull4() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, NULL, TYPE, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull4</p>';
}
function testConstructorNull5() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, NULL, START_DATE);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull5</p>';
}
function testConstructorNull6() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, NULL);
    } catch(Exception) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull6</p>';
}

function testGetKey() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    $c->setKey(KEY);
    if($c->getKey() === KEY)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}
function testGetCandidate() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    if($c->getCandidate() === CANDIDATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}
function testGetService() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    if($c->getService() === SERVICE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}
function testGetEstablishment() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    if($c->getEstablishment() === ESTABLISHMENT)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}
function testGetType() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    if($c->getType() === TYPE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}
function testGetStartDate() {
    $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
    if($c->getStartDate() === START_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName</p>';
}

function testSetKeyTrue() {
    $res = true;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        $c->setKey(KEY);
    } catch(Exception) {
        $res = false;
    }

    if($res && $c->getKey() === KEY)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyTrue</p>';
}
function testSetKeyFalse1() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        $c->setKey('Bonjour');
    } catch(Exception) {
        $res = true;
    }

    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyFalse1</p>';
}
function testSetKeyFalse2() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        $c->setKey(-12);
    } catch(Exception) {
        $res = true;
    }

    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyFalse2</p>';
}
function testSetKeyNull() {
    $res = false;
    try {
        $c = new Contract(CANDIDATE, JOB, SERVICE, ESTABLISHMENT, TYPE, START_DATE);
        $c->setKey(NULL);
    } catch(Exception) {
        $res = true;
    }

    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyNull</p>';
}

function testMakeContractWithoutTrue() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getCandidate() === CANDIDATE && $c->getJob() === JOB && $c->getService() === SERVICE && $c->getEstablishment() === ESTABLISHMENT && $c->getType() === TYPE && $c->getStartDate() === START_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutTrue</p>';
}
function testMakeContractWithoutFalse1() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse1</p>';
}
function testMakeContractWithoutFalse2() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse2</p>';
}
function testMakeContractWithoutFalse3() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse3</p>';
}
function testMakeContractWithoutFalse4() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse4</p>';
}
function testMakeContractWithoutFalse5() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse5</p>';
}
function testMakeContractWithoutFalse6() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse6</p>';
}
function testMakeContractWithoutFalse7() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse7</p>';
}
function testMakeContractWithoutFalse8() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse8</p>';
}
function testMakeContractWithoutFalse9() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse9</p>';
}
function testMakeContractWithoutFalse10() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse10</p>';
}
function testMakeContractWithoutFalse11() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse11</p>';
}
function testMakeContractWithoutFalse12() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse12</p>';
}
function testMakeContractWithoutFalse13() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse13</p>';
}
function testMakeContractWithoutFalse14() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse14</p>';
}
function testMakeContractWithoutFalse15() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse15</p>';
}
function testMakeContractWithoutFalse16() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse16</p>';
}
function testMakeContractWithoutFalse17() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse17</p>';
}
function testMakeContractWithoutFalse18() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutFalse18</p>';
}
function testMakeContractWithoutNull1() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull1</p>';
}
function testMakeContractWithoutNull2() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull2</p>';
}
function testMakeContractWithoutNull3() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull3</p>';
}
function testMakeContractWithoutNull4() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull4</p>';
}
function testMakeContractWithoutNull5() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull5</p>';
}
function testMakeContractWithoutNull6() {
    $res = false;
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
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithoutNull6</p>';
}

function testMakeContractWithTrue1() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getEndDate() === END_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue1</p>';
}
function testMakeContractWithTrue2() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getEndDate() === END_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue2</p>';
}
function testMakeContractWithTrue3() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getResignationDate() === RESIGNATION_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue3</p>';
}
function testMakeContractWithTrue4() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getSignature() === SIGNATURE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue4</p>';
}
function testMakeContractWithTrue5() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getSignature() === SIGNATURE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue5</p>';
}
function testMakeContractWithTrue6() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getSalary() === SALARY)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue6</p>';
}
function testMakeContractWithTrue7() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getEndDate() === END_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue7</p>';
}
function testMakeContractWithTrue8() {
    $res = true;
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
        $res = false;
    }
    
    if($res && $c->getEndDate() === END_DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeContractWithTrue8</p>';
}

function test() {
    echo "<h1>Test de la classe Contract.php</h1>";
    echo "<h2>Test de constructeurs</h2>";
    echo "<h3>Test classique</h3>";
    testConstructorTrue();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testConstructorFalse1();
    testConstructorFalse2();
    testConstructorFalse3();
    testConstructorFalse4();
    testConstructorFalse5();
    testConstructorFalse6();
    testConstructorFalse7();
    testConstructorFalse8();
    testConstructorFalse9();
    testConstructorFalse10();
    testConstructorFalse11();
    testConstructorFalse12();
    testConstructorFalse13();
    testConstructorFalse14();
    testConstructorFalse15();
    testConstructorFalse16();
    testConstructorFalse17();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testConstructorNull1();
    testConstructorNull2();
    testConstructorNull3();
    testConstructorNull4();
    testConstructorNull5();
    testConstructorNull6();

    echo "<h2>Test de getters</h2>";
    testGetKey();
    testGetCandidate();
    testGetService();
    testGetEstablishment();
    testGetType();
    testGetStartDate();

    echo "<h2>Test de setters</h2>";
    echo "<h3>Test classique</h3>";
    testSetKeyTrue();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testSetKeyFalse1();
    testSetKeyFalse2();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testSetKeyNull();


    echo "<h2>Test de makeContract</h2>";
    echo "<h3>Test classique</h3>";
    testMakeContractWithoutTrue();
    testMakeContractWithTrue1();
    testMakeContractWithTrue2();
    testMakeContractWithTrue3();
    testMakeContractWithTrue4();
    testMakeContractWithTrue5();
    testMakeContractWithTrue6();
    testMakeContractWithTrue7();
    testMakeContractWithTrue8();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testMakeContractWithoutFalse1();
    testMakeContractWithoutFalse2();
    testMakeContractWithoutFalse3();
    testMakeContractWithoutFalse4();
    testMakeContractWithoutFalse5();
    testMakeContractWithoutFalse6();
    testMakeContractWithoutFalse7();
    testMakeContractWithoutFalse8();
    testMakeContractWithoutFalse9();
    testMakeContractWithoutFalse10();
    testMakeContractWithoutFalse11();
    testMakeContractWithoutFalse12();
    testMakeContractWithoutFalse13();
    testMakeContractWithoutFalse14();
    testMakeContractWithoutFalse15();
    testMakeContractWithoutFalse16();
    testMakeContractWithoutFalse17();
    testMakeContractWithoutFalse18();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testMakeContractWithoutNull1();
    testMakeContractWithoutNull2();
    testMakeContractWithoutNull3();
    testMakeContractWithoutNull4();
    testMakeContractWithoutNull5();
    testMakeContractWithoutNull6();
}

test();