<?php

include '../define.php';
include '../'.COMPONENTS.DS.'FormsManip.php';
include '../'.CLASSE.DS.'User.php';

define('KEY', 1);
define('IDENTIFIER', 'mathis.a');
define('NAME', 'Mathis');
define('FIRSTNAME', 'Arthur');
define('EMAIL', 'arthur.mathis@diaconat-mulhouse.fr');
define('PASSWORD', 'Arthur123');
define('ESTABLISHMENT', 1);
define('ROLE', 1);
define('ARRAY_WITH_KEY', ['key' => KEY, 'identifier' => IDENTIFIER, 'name' => NAME, 'firstname' => FIRSTNAME, 'email' => EMAIL, 'password' => PASSWORD, 'establishment' => ESTABLISHMENT, 'role' => ROLE]);
define('ARRAY_WITHOUT_KEY', ['identifier' => IDENTIFIER, 'name' => NAME, 'firstname' => FIRSTNAME, 'email' => EMAIL, 'password' => PASSWORD, 'establishment' => ESTABLISHMENT, 'role' => ROLE]);


function testConstructorTrue() {
    $res = true;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = false;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorTrue';
}
function testConstructorIdentifierFalse() {
    $res = false;
    try {
        $u = new User('1', NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorIdentifierFalse';
}
function testConstructorNameFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, '1', FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameFalse';
}
function testConstructorFirstnameFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, '1', EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFirstnameFalse';
}
function testConstructorEmailFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEmailFalse';
}
function testConstructorPasswordFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, '1', EMAIL, 123, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPasswordFalse';
}
function testConstructorEstablishmentFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, 'Canard', ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEstablishmentFalse';
}
function testConstructorRoleFalse() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, ESTABLISHMENT, 'Paul');
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorRoleFalse';
}
function testConstructorIdentifierNull() {
    $res = false;
    try {
        $u = new User(NULL, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorIdentifierNull';
}
function testConstructorNameNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NULL, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorNameNull';
}
function testConstructorFirstnameNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, NULL, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorFirstnameNull';
}
function testConstructorEmailNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NULL, PASSWORD, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEmailNull';
}
function testConstructorPasswordNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, NULL, ESTABLISHMENT, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorPasswordNull';
}
function testConstructorEstablishmentNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, NULL, ROLE);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorEstablishmentNull';
}
function testConstructorRoleNull() {
    $res = false;
    try {
        $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, ESTABLISHMENT, NULL);
    } catch(Exception $e) {
        $res = true;
    }  

    if($res)
        echo '<p>Test validé !</p>';
    else 
        echo '<p><b>Erreur :</b> testConstructorRoleNull';
}

function testGetIdentifier() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getIdentifier() === IDENTIFIER)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetIdentifier';
}
function testGetName() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getName() === NAME)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetName';
}
function testGetFirstname() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getFirstname() === FIRSTNAME)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetFirstname';
}
function testGetEmail() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getEmail() === EMAIL)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetEmail';
}
function testGetPassword() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getPassword() === PASSWORD)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetPassword';
}
function testGetEstablshment() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getEstablishment() === ESTABLISHMENT)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetEstablshment';
}
function testGetRole() {
    $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);
    if($u->getRole() === ROLE)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testGetRole';
}

function testMakeUserWithoutKey() {
    $u = User::makeUser(ARRAY_WITHOUT_KEY);
    if($u->getIdentifier() === IDENTIFIER && $u->getName() === NAME && $u->getFirstname() === FIRSTNAME && $u->getEmail() === EMAIL &&$u->getPassword() === PASSWORD && $u->getEstablishment() === ESTABLISHMENT && $u->getRole() === ROLE && $u->getKey() === NULL)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeUserWithoutKey';
}
function testMakeUserWithKey() {
    $u = User::makeUser(ARRAY_WITH_KEY);
    if($u->getIdentifier() === IDENTIFIER && $u->getName() === NAME && $u->getFirstname() === FIRSTNAME && $u->getEmail() === EMAIL &&$u->getPassword() === PASSWORD && $u->getEstablishment() === ESTABLISHMENT && $u->getRole() === ROLE && $u->getKey() === KEY)
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testMakeUserWithKey';
}
function testExportToArrayWithoutKey() {
    $array = User::makeUser(ARRAY_WITHOUT_KEY)->exportToArray();
    if($array === ['identifier' => IDENTIFIER, 'email' => EMAIL, 'password' => PASSWORD, 'role' => ROLE, 'key' => NULL]) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToArrayWithoutKey';
}
function testExportToArrayWithKey() {
    $array = User::makeUser(ARRAY_WITH_KEY)->exportToArray();
    if($array === ['identifier' => IDENTIFIER, 'email' => EMAIL, 'password' => PASSWORD, 'role' => ROLE, 'key' => KEY]) 
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToArrayWithKey';
}
function testExportToSQL() {
    $array = User::makeUser(ARRAY_WITHOUT_KEY)->exportToSQL();
    if($array['identifier'] === IDENTIFIER && $array['name'] === NAME && $array['firstname'] === FIRSTNAME && $array['email'] === EMAIL && password_verify(PASSWORD, $array['password']) && ESTABLISHMENT === $array['key_establishment'] && ROLE === $array['key_role'])
        echo '<p>Test validé</p>';
    else 
        echo '<p><b>Erreur :</b> testExportToSQL';
}

function test() {
    echo "<h1>Test de la classe User.php</h1>";
    echo "<h2>Tests de constructeurs</h2>";
    echo "<h3>Test classique</h3>";
    testConstructorTrue();
    echo "<h3>Test de détection des erreurs - False</h3>";
    testConstructorIdentifierFalse();
    testConstructorNameFalse();
    testConstructorFirstnameFalse();
    testConstructorEmailFalse();
    testConstructorEstablishmentFalse();
    testConstructorRoleFalse();
    echo "<h3>Test de détection des erreurs - Null</h3>";
    testConstructorIdentifierNull();
    testConstructorNameNull();
    testConstructorFirstnameNull();
    testConstructorEmailNull();
    testConstructorEstablishmentNull();
    testConstructorRoleNull();
    
    echo "<h2>Tests de getters</h2>";
    testGetIdentifier();
    testGetName();
    testGetFirstname();
    testGetEmail();
    testGetPassword();
    testGetEstablshment();
    testGetRole();

    echo "<h2>Méthodes statiques</h2>";
    testMakeUserWithoutKey();
    testMakeUserWithKey();

    echo "<h2>Méthodes d'exports</h2>";
    testExportToArrayWithoutKey();
    testExportToArrayWithKey();
    testExportToSQL();
}

test();