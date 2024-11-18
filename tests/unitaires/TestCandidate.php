<?php

include '../define.php';
include '../'.CLASSE.DS.'Candidate.php';

define('KEY', 1);
define('NAME', 'Mathis');
define('FIRSTNAME', 'Arthur');
define('EMAIL', 'arthur.mathis@diaconat-mulhouse.fr');
define('PHONE', '06.38.85.55.57');
define('ADDRESS', '22 rue de la praire');
define('CITY', 'PrairieVille');
define('POSTCODE', '68100');
define('AVAILABILITY', '2024-12-25');
define('MEDICAL_VISITE', '2024-09-09');

function testConstructorTrue() {
    $res = true;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorTrue';
}
function testConstructorNameFalse1() {
    $res = false;
    try {
        $c = new Candidate('1', FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorNameFalse2() {
    $res = false;
    try {
        $c = new Candidate(1, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse2';
}
function testConstructorFirstnameFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, '1', EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFirstnameFalse1';
}
function testConstructorFirstnameFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, 1, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFirstnameFalse2';
}
function testConstructorEmailFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, NAME, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEmailFalse1';
}
function testConstructorEmailFalse3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, '1', PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEmailFalse3';
}
function testConstructorEmailFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, 1, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEmailFalse2';
}
function testConstructorPhoneFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, 123654789, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPhoneFalse1';
}
function testConstructorPhoneFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, '0.2', ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPhoneFalse2';
}
function testConstructorPhoneFalse3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, '0.22.23.21', ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPhoneFalse3';
}
function testConstructorPhoneFalse4() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, '0.22.23.21.24.26.32', ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPhoneFalse4';
}
function testConstructorPhoneFalse5() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, '022.2321.24', ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPhoneFalse5';
}
function testConstructorAddressFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, "12354", CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorAddressFalse1';
}
function testConstructorAddressFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, 1, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorAddressFalse2';
}
function testConstructorCityFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, "12354", POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorCityFalse1';
}
function testConstructorCityFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, 1, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorCityFalse2';
}
function testConstructorPostcodeFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, "bonjour");
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPostcodeFalse1';
}
function testConstructorPostcodeFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, 12);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPostcodeFalse2';
}
function testConstructorPostcodeFalse3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, 123456789111213141516171819);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPostcodeFalse3';
}
function testConstructorNameNull() {
    $res = false;
    try {
        $c = new Candidate(NULL, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorFirstnameNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, NULL, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorEmailNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, NULL, PHONE, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorPhoneNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, NULL, ADDRESS, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorAddressNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, NULL, CITY, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorCityNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, NULL, POSTCODE);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}
function testConstructorPostcodeNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, NULL);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse1';
}

function testSetKeyTrue1() {
    $res = true;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setKey(KEY);
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyTrue1';
}
function testSetKeyTrue2() {
    $res = true;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setKey('1');
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyTrue2';
}
function testSetKeyTrue3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setKey(NULL);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyTrue3';
}
function testSetKeyFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setKey('-1');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyFalse1';
}
function testSetKeyFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setKey('Bonjour');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyFalse2';
}
function testAvailabilityTrue() {
    $res = true;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setAvailability(AVAILABILITY);
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testAvailabilityTrue1';
}
function testAvailabilityFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setAvailability(-1);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testAvailabilityFalse1';
}
function testAvailabilityFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setAvailability('12:03:36');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testAvailabilityFalse2';
}
function testAvailabilityFalse3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setAvailability('Bonjour');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testAvailabilityFalse3';
}
function testAvailabilityNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setAvailability(NULL);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testAvailabilityNull';
}
function testSetMedicalVisitTrue() {
    $res = true;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit(MEDICAL_VISITE);
    } catch(Exception $e) {
        $res = false;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetKeyTrue1';
}
function testMedicalVisitFalse1() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit(-1);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMedicalVisitFalse1';
}
function testMedicalVisitFalse2() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit('12:03:36');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMedicalVisitFalse2';
}
function testMedicalVisitFalse3() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit('Bonjour');
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMedicalVisitFalse3';
}
function testSetMedicalVisitNull() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit(NULL);
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testSetMedicalVisitNull';
}

function testGetKey() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setKey(KEY);
    if(KEY === $c->getKey())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetKey';
}
function testGetName() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(NAME === $c->getName())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName';
}
function testGetFirstname() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(FIRSTNAME === $c->getFirstname())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetFirstname';
}
function testGetEmail() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(EMAIL === $c->getEmail())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetEmail';
}
function testGetPhone() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(PHONE === $c->getPhone())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetPhone';
}
function testGetAddress() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(ADDRESS === $c->getAddress())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetAddress';
}
function testGetCity() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(CITY === $c->getCity())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetCity';
}
function testGetPostcode() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    if(POSTCODE === $c->getPostcode())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetPostcode';
}
function testGetAvailability() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setAvailability(AVAILABILITY);
    if(AVAILABILITY === $c->getAvailability())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetAvailability';
}
function testGetMedicalVisit() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setMedicalVisit(MEDICAL_VISITE);
    if(MEDICAL_VISITE === $c->getMedicalVisit())
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetMedicalVisit';
}

function testExportToSQL_WithoutVisitTrue() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setAvailability(AVAILABILITY);
    $c = $c->exportToSQL();

    if(count($c) === 8 && $c["name"] === NAME && $c["firstname"] === FIRSTNAME && $c["email"] === EMAIL && $c["phone"] === PHONE && $c["address"] === ADDRESS && $c["city"] === CITY && $c["post_code"] === POSTCODE && $c["availability"] === AVAILABILITY)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_WithoutVisitTrue';
}
function testExportToSQL_WithVisitTrue() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setMedicalVisit(MEDICAL_VISITE);
    $c->setAvailability(AVAILABILITY);
    $c = $c->exportToSQL();

    if(count($c) === 9 && $c["name"] ===  NAME && $c["firstname"] === FIRSTNAME && $c["email"] === EMAIL && $c["phone"] === PHONE && $c["address"] === ADDRESS && $c["city"] === CITY && $c["post_code"] === POSTCODE && $c["availability"] === AVAILABILITY && $c["medical_visit"] === MEDICAL_VISITE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_WithVisitTrue';
}
function testExportToSQL_WithoutVisitFalse() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c = $c->exportToSQL();
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_WithoutVisitFalse';
}
function testExportToSQL_WithVisitFalse() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit(MEDICAL_VISITE);
        $c = $c->exportToSQL();
    } catch(Exception $e) {
        $res = true;
    }
    
    if($res) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_WithVisitFalse';
}
function testExportToSQL_update() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c = $c->exportToSQL_update();
    if(count($c) === 7 && $c["name"] === NAME && $c["firstname"] === FIRSTNAME && $c["email"] === EMAIL && $c["phone"] === PHONE && $c["address"] === ADDRESS && $c["city"] === CITY && $c["post_code"] === POSTCODE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_update';
}
function testExportToSQL_Key() {
    $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
    $c->setMedicalVisit(MEDICAL_VISITE);
    $c->setAvailability(AVAILABILITY);
    $c->setKey(KEY);
    $c = $c->exportToSQL_Key();
    if(count($c) === 10 && $c["id"] === KEY && $c["name"] ===  NAME && $c["firstname"] === FIRSTNAME && $c["email"] === EMAIL && $c["phone"] === PHONE && $c["address"] === ADDRESS && $c["city"] === CITY && $c["post_code"] === POSTCODE && $c["availability"] === AVAILABILITY && $c["medical_visit"] === MEDICAL_VISITE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_Key';
}
function testExportToSQL_KeyFalse() {
    $res = false;
    try {
        $c = new Candidate(NAME, FIRSTNAME, EMAIL, PHONE, ADDRESS, CITY, POSTCODE);
        $c->setMedicalVisit(MEDICAL_VISITE);
        $c->setAvailability(AVAILABILITY);
        $c = $c->exportToSQL_Key();
    } catch(Exception $e) {
        $res == true;
    }
    
    if($res)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL_KeyFalse';
}

function test() {
    echo "<h1>Test de la classe Candidate.php</h1>";
    echo "<h2>Test de constructeurs</h2>";
    echo "<h3>Test classique</h3>";
    testConstructorTrue();

    echo "<h3>Test de détection des erreurs - False</h3>";
    testConstructorNameFalse1();
    testConstructorNameFalse2();
    testConstructorFirstnameFalse1();
    testConstructorFirstnameFalse2();
    testConstructorEmailFalse1();
    testConstructorEmailFalse2();
    testConstructorEmailFalse3();
    testConstructorPhoneFalse1();
    testConstructorPhoneFalse2();
    testConstructorPhoneFalse3();
    testConstructorPhoneFalse4();
    testConstructorPhoneFalse5();
    testConstructorAddressFalse1();
    testConstructorAddressFalse2();
    testConstructorCityFalse1();
    testConstructorCityFalse2();
    testConstructorPostcodeFalse1();
    testConstructorPostcodeFalse2();
    testConstructorPostcodeFalse3();

    echo "<h3>Test de détection des erreurs - Null</h3>";
    testConstructorNameNull();
    testConstructorFirstnameNull();
    testConstructorEmailNull();
    testConstructorPhoneNull();
    testConstructorAddressNull();
    testConstructorCityNull();
    testConstructorPostcodeNull();

    echo "<h2>Test de setters</h2>";
    echo "<h3>Test classique</h3>";
    testSetKeyTrue1();
    testSetKeyTrue2();
    testSetKeyTrue3();
    testAvailabilityTrue();
    testSetMedicalVisitTrue();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testSetKeyFalse1();
    testSetKeyFalse2();
    testAvailabilityFalse1();
    testAvailabilityFalse2();
    testAvailabilityFalse3();
    testMedicalVisitFalse1();
    testMedicalVisitFalse2();
    testMedicalVisitFalse3();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testAvailabilityNull();
    testSetMedicalVisitNull();

    echo "<h2>Test de getters</h2>";
    testGetKey();
    testGetName();
    testGetFirstname();
    testGetPhone();
    testGetEmail();
    testGetAddress();
    testGetCity();
    testGetPostcode();
    testGetAvailability();
    testGetMedicalVisit();

    echo "<h2>Test d'exports</h2>";
    testExportToSQL_WithoutVisitTrue();
    testExportToSQL_WithVisitTrue();
    testExportToSQL_WithoutVisitFalse();
    testExportToSQL_WithVisitFalse();
    testExportToSQL_update();
    testExportToSQL_Key();
}

test();