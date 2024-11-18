<?php

include '../define.php';
include '../'.CLASSE.DS.'Moment.php';

define('TIMESTAMP', 1065348000);
define('TIMESTAMP_2', 12345678911);
define('DATE', '2003-10-05');
define('HOUR', '12:00:00');

function testConstructorTrue1() {
    $res = true;
    try {
        $m = new Moment(TIMESTAMP);
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorTrue1';
}
function testConstructorTrue2() {
    $res = true;
    try {
        $m = new Moment('1065348000');
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorTrue2';
}
function testConstructorFalse1() {
    $res = false;
    try {
        $m = new Moment('gregry');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse1';    
}
function testConstructorFalse2() {
    $res = false;
    try {
        $m = new Moment('2024-05-12');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFalse2';    
}
function testConstructorNull() {
    $res = false;
    try {
        $m = new Moment(NULL);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNull';    
}

function testGetDate() {
    $m = new Moment(TIMESTAMP);
    if($m->getDate() === DATE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName';

}
function testGetHour() {
    $m = new Moment(TIMESTAMP);
    if($m->getHour() === HOUR)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetHour';
}
function testGetTimestamp() {
    $m = new Moment(TIMESTAMP);
    if($m->getTimestamp() === TIMESTAMP)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetTimestamp';
}
function testCurrentMoment() {
    $t = time();
    $m = new Moment($t);
    $time = $m->getTimestamp();

    if($time === $t)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testCurrentMoment'; 
}

function testIsDateTrue() {
    if(Moment::isDate(DATE))
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testIsDateTrue'; 
}
function testIsDateFalse1() {
    if(Moment::isDate(TIMESTAMP))
        echo '<p><b>Erreur :</b> testIsDateFalse1';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse2() {
    if(Moment::isDate('2024-08'))
        echo '<p><b>Erreur :</b> testIsDateFalse2';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse3() {
    if(Moment::isDate('2024-08'))
        echo '<p><b>Erreur :</b> testIsDateFalse3';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse4() {
    if(Moment::isDate('20-24-08'))
        echo '<p><b>Erreur :</b> testIsDateFalse4';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse5() {
    if(Moment::isDate('2024-24-08'))
        echo '<p><b>Erreur :</b> testIsDateFalse5';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse6() {
    if(Moment::isDate('2024-02-30'))
        echo '<p><b>Erreur :</b> testIsDateFalse6';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse7() {
    if(Moment::isDate('2024-2-3'))
        echo '<p><b>Erreur :</b> testIsDateFalse7';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse8() {
    if(Moment::isDate('bonjour à tous'))
        echo '<p><b>Erreur :</b> testIsDateFalse8';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsDateFalse9() {
    if(Moment::isDate(12345678))
        echo '<p><b>Erreur :</b> testIsDateFalse9';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourTrue1() {
    if(Moment::isHour(HOUR))
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testIsHourTrue1';
}
function testIsHourTrue2() {
    if(Moment::isHour('12:30'))
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testIsHourTrue2';
}
function testIsHourFalse1() {
    if(Moment::isHour(TIMESTAMP))
        echo '<p><b>Erreur :</b> testIsHourFalse1';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourFalse2() {
    if(Moment::isHour('Bonjour à tous'))
        echo '<p><b>Erreur :</b> testIsHourFalse2';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourFalse3() {
    if(Moment::isHour('26:12:12'))
        echo '<p><b>Erreur :</b> testIsHourFalse3';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourFalse4() {
    if(Moment::isHour('06:72:12'))
        echo '<p><b>Erreur :</b> testIsHourFalse4';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourFalse5() {
    if(Moment::isHour('06:2:2'))
        echo '<p><b>Erreur :</b> testIsHourFalse5';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsHourFalse6() {
    if(Moment::isHour(123456))
        echo '<p><b>Erreur :</b> testIsHourFalse6';
    else 
        echo '<p>Test validé</p>'; 
}
function testIsTimestampTrue1() {
    if(Moment::isTimestamp(TIMESTAMP))
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testIsTimestampTrue1';
}
function testIsTimestampTrue2() {
    if(Moment::isTimestamp('123456789'))
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testIsTimestampTrue2';
}
function testIsTimestampFalse1() {
    if(Moment::isTimestamp(-1))
        echo '<p><b>Erreur :</b> testIsTimestampFalse1';
    else
        echo '<p>Test validé</p>';
}
function testIsTimestampFalse2() {
    if(Moment::isTimestamp('-1'))
        echo '<p><b>Erreur :</b> testIsTimestampFalse2';
    else
        echo '<p>Test validé</p>';
}
function testIsTimestampFalse3() {
    if(Moment::isTimestamp('bonjour'))
        echo '<p><b>Erreur :</b> testIsTimestampFalse3';
    else
        echo '<p>Test validé</p>';
}
function testIsTimestampFalse4() {
    if(Moment::isTimestamp('2024-20215'))
        echo '<p><b>Erreur :</b> testIsTimestampFalse4';
    else
        echo '<p>Test validé</p>';
}

function testIsTallerThanTrue() {
    $m = new Moment(TIMESTAMP_2);
    if($m->isTallerThan(TIMESTAMP))
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testIsTallerThanTrue';
}
function testIsTallerThanFalse() {
    $m = new Moment(TIMESTAMP);
    if($m->isTallerThan(TIMESTAMP_2))
        echo '<p><b>Erreur :</b> testIsTallerThanFalse';
    else
        echo '<p>Test validé</p>';
}
function testIsEqualToTrue() {
    $m = new Moment(TIMESTAMP);
    if($m->isEqualTo(TIMESTAMP))
        echo '<p>Test validé</p>';
    else
    echo '<p><b>Erreur :</b> testIsEqualToTrue';
}
function testIsEqualToFalse() {
    $m = new Moment(TIMESTAMP);
    if($m->isEqualTo(TIMESTAMP_2))
        echo '<p><b>Erreur :</b> testIsEqualToFalse';
    else
        echo '<p>Test validé</p>';
}
function testIsTallerOrEqualToTrue() {
    $m = new Moment(TIMESTAMP);
    if($m->isTallerOrEqualTo(TIMESTAMP))
        echo '<p>Test validé</p>';
    else
    echo '<p><b>Erreur :</b> testIsTallerOrEqualToTrue';
}
function testIsTallerOrEqualToFalse() {
    $m = new Moment(TIMESTAMP);
    if($m->isTallerOrEqualTo(TIMESTAMP_2))
        echo '<p><b>Erreur :</b> testIsTallerOrEqualToFalse';
    else
        echo '<p>Test validé</p>';
}

function testFromDateTrue1() {
    $res = true;
    try {
        $m = Moment::fromDate(DATE, HOUR);
    } catch(Exception) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';  
    else
        echo '<p><b>Erreur :</b> testFromDateTrue1';
}
function testFromDateTrue2() {
    $res = true;
    try {
        $m = Moment::fromDate(DATE);
    } catch(Exception) {
        $res = false;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateTrue2';
}
function testFromDateFalse1() {
    $res = false;
    try {
        $m = Moment::fromDate('Bonjour');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse1';
}
function testFromDateFalse2() {
    $res = false;
    try {
        $m = Moment::fromDate('1');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse2';
}
function testFromDateFalse3() {
    $res = false;
    try {
        $m = Moment::fromDate(-123);
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse3';
}
function testFromDateFalse4() {
    $res = false;
    try {
        $m = Moment::fromDate('24-20-26');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse4';
}
function testFromDateFalse5() {
    $res = false;
    try {
        $m = Moment::fromDate('2024-2-2');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse5';
}
function testFromDateFalse6() {
    $res = false;
    try {
        $m = Moment::fromDate('2024-12');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse6';
}
function testFromDateFalse7() {
    $res = false;
    try {
        $m = Moment::fromDate(DATE, 12);
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse7';
}
function testFromDateFalse8() {
    $res = false;
    try {
        $m = Moment::fromDate(DATE, '1:2:3');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse8';
}
function testFromDateFalse9() {
    $res = false;
    try {
        $m = Moment::fromDate(DATE, '12:23:34:45');
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateFalse9';
}
function testFromDateNull1() {
    $res = false;
    try {
        $m = Moment::fromDate(NULL, HOUR);
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateNull1';
}
function testFromDateNull2() {
    $res = false;
    try {
        $m = Moment::fromDate(NULL);
    } catch(Exception) {
        $res = true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else
        echo '<p><b>Erreur :</b> testFromDateNull2';
}

function test() {
    echo "<h1>Test de la classe Moment.php</h1>";
    echo "<h2>Test de constructeurs</h2>";
    echo "<h3>Test classique</h3>";
    testConstructorTrue1();
    testConstructorTrue2();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testConstructorFalse1();
    testConstructorFalse2();
    testConstructorNull();

    echo "<h2>Test de fromDate</h2>";
    echo "<h3>Test classique</h3>";
    testFromDateTrue1();
    testFromDateTrue2();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testFromDateFalse1();
    testFromDateFalse2();
    testFromDateFalse3();
    testFromDateFalse4();
    testFromDateFalse5();
    testFromDateFalse6();
    testFromDateFalse7();
    testFromDateFalse8();
    testFromDateFalse9();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testFromDateNull1();
    testFromDateNull2();

    echo "<h2>Test des getters</h2>";
    testGetDate();
    testGetHour();
    testGetTimestamp();
    testCurrentMoment();

    echo "<h2>Méthodes statiques</h2>";
    echo "<h3>Test classique</h3>";
    testIsDateTrue();
    testIsHourTrue1();
    testIsHourTrue2();
    testIsTimestampTrue1();
    testIsTimestampTrue2();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testIsDateFalse1();
    testIsDateFalse2();
    testIsDateFalse3();
    testIsDateFalse4();
    testIsDateFalse5();
    testIsDateFalse6();
    testIsDateFalse7();
    testIsDateFalse8();
    testIsDateFalse9();
    testIsHourFalse1();
    testIsHourFalse2();
    testIsHourFalse3();
    testIsHourFalse4();
    testIsHourFalse5();
    testIsHourFalse6();
    testIsTimestampFalse1();
    testIsTimestampFalse2();
    testIsTimestampFalse3();
    testIsTimestampFalse4();

    echo "<h2>Méthodes de comparaison</h2>";
    echo "<h3>Test classique</h3>";
    testIsTallerThanTrue();
    testIsEqualToTrue();
    testIsTallerOrEqualToTrue();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testIsTallerThanFalse();
    testIsEqualToFalse();
    testIsTallerOrEqualToFalse();
}

test();