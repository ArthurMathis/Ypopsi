<?php

include '../../define.php';
include 'TestsManipulations.php';
include '../../'.CLASSE.DS.'User.php';

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

/**
 * Class testing the User class
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TestsUsers extends TestsManipulation {
    /**
     * Public function running unit tests
     *
     * @return Void
     */
    public function run() {
        $this->writteH1("Test de la classe User.php");
        $this->writteH2("Tests de constructeurs");
        $this->writteH3("<h3>Test classique</h3>");
        $this->constructorTrue();

        $this->writteSuccess();
        $this->writteH3("<h3>Test de détection des erreurs - False</h3>");
        $this->constructorIdentifierFalse();
        $this->constructorNameFalse();
        $this->constructorFirstnameFalse();
        $this->constructorEmailFalse();
        $this->constructorEstablishmentFalse();
        $this->constructorRoleFalse();
        $this->writteSuccess();

        $this->writteH2("Tests de getters");
        $this->getIdentifier();
        $this->getName();
        $this->getFirstname();
        $this->getEmail();
        $this->getPassword();
        $this->getEstablishment();
        $this->getRole();
        $this->writteSuccess();

        $this->writteH2("Méthodes statiques");
        $this->makeUserWithoutKey();
        $this->makeUserWithKey();
        $this->writteSuccess();

        $this->writteH2("Méthodes d'exports");
        $this->exportToArrayWithoutKey();
        $this->exportToArrayWithKey();
        $this->exportToSQL();
        $this->writteSuccess();
    }

    // * CONSTRUCTOR * //
    /**
     * Fonction publique testant si le constructeur fonctionne correctement avec tout les paramètres
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorTrue() {
        try {
            $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);

        } catch(Exception $e) { 
            $this->writteFailure('constructorTrue'); 
        }
        $this->successTest();
    }

    //// FALSE ////
    /**
     * Fonction publique testant la gestion des erreurs avec un indetifiant contenant un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorIdentifierFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User('1', NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorIdentifierFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un nom contenant un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorNameFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, '1', FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorNameFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un prénom contenant un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorFirstnameFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, NAME, '1', EMAIL, PASSWORD, ESTABLISHMENT, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorFirstnameFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un email contenant un nom
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorEmailFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, ESTABLISHMENT, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorEmailFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un password sous forme d'un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPasswordFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, 123, ESTABLISHMENT, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorPasswordFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un établissement négatif
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorEstablishmentFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, -1, ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorEstablishmentFalse");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un rôle négatif
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorRoleFalse() {
        $res = $this->FAILURE();
        try {
            $u = new User(IDENTIFIER, NAME, FIRSTNAME, NAME, PASSWORD, ESTABLISHMENT, -1);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorRoleFalse");
    }

    // * GET * //
    /**
     * Fonction publique testant la fonction getIdentifier
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getIdentifier() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getIdentifier() === IDENTIFIER)
            $this->successTest();
        else 
            $this->writteFailure("getIdentifier");
    }
    /**
     * Fonction publique testant la fonction getName
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getName() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getName() === NAME)
            $this->successTest();
        else 
            $this->writteFailure("getName");
    }
    /**
     * Fonction publique testant la fonction getFirstname
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getFirstname() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getFirstname() === FIRSTNAME)
            $this->successTest();
        else 
            $this->writteFailure("getFirstname");
    }
    /**
     * Fonction publique testant la fonction getEmail
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getEmail() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getEmail() === EMAIL)
            $this->successTest();
        else 
            $this->writteFailure("getEmail");
    }
    /**
     * Fonction publique testant la fonction getPassword
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getPassword() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getPassword() === PASSWORD)
            $this->successTest();
        else 
            $this->writteFailure("getPassword");
    }
    /**
     * Fonction publique testant la fonction getEstablishment
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getEstablishment() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getEstablishment() === ESTABLISHMENT)
            $this->successTest();
        else 
            $this->writteFailure("getEstablishment");
    }
    /**
     * Fonction publique testant la fonction getRole
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getRole() {
        if((new User(IDENTIFIER, NAME, FIRSTNAME, EMAIL, PASSWORD, ESTABLISHMENT, ROLE))->getRole() === ROLE)
            $this->successTest();
        else 
            $this->writteFailure("getRole");
    }

    // * STATIC * //
    //// MAKE ////
    /**
     * Fonction publique testant la génération d'un utilisateur depuis un tableau de données sans clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function makeUserWithoutKey() {
        $u = User::makeUser(ARRAY_WITHOUT_KEY);
        if($u->getIdentifier() === IDENTIFIER && $u->getName() === NAME && $u->getFirstname() === FIRSTNAME && $u->getEmail() === EMAIL &&$u->getPassword() === PASSWORD && $u->getEstablishment() === ESTABLISHMENT && $u->getRole() === ROLE && $u->getKey() === NULL)
            $this->successTest();
        else 
            $this->writteFailure("makeUserWithoutKey");
    }
    /**
     * Fonction publique testant la génération d'un utilisateur depuis un tableau de données avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function makeUserWithKey() {
        $u = User::makeUser(ARRAY_WITH_KEY);
        if($u->getIdentifier() === IDENTIFIER && $u->getName() === NAME && $u->getFirstname() === FIRSTNAME && $u->getEmail() === EMAIL &&$u->getPassword() === PASSWORD && $u->getEstablishment() === ESTABLISHMENT && $u->getRole() === ROLE && $u->getKey() === KEY)
            $this->successTest();
        else 
            $this->writteFailure("makeUserWithKey");
    }

    //// EXPORT ////
    /**
     * Fonction publique testant l'exportation d'un utilisateur sans clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToArrayWithoutKey() {
        $array = User::makeUser(ARRAY_WITHOUT_KEY)->exportToArray();
        if($array === ['identifier' => IDENTIFIER, 'email' => EMAIL, 'password' => PASSWORD, 'role' => ROLE, 'key' => NULL]) 
            $this->successTest();
        else 
            $this->writteFailure("exportToArrayWithoutKey");
    }
    /**
     * Fonction publique testant l'exportation d'un utilisateur avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToArrayWithKey() {
        $array = User::makeUser(ARRAY_WITH_KEY)->exportToArray();
        if($array === ['identifier' => IDENTIFIER, 'email' => EMAIL, 'password' => PASSWORD, 'role' => ROLE, 'key' => KEY]) 
            $this->successTest();
        else 
            $this->writteFailure("exportToArrayWithKey");
    }
    /**
     * Fonction publique testant l'exportation SQL d'un utilisateur avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQL() {
        $array = User::makeUser(ARRAY_WITHOUT_KEY)->exportToSQL();
        if($array['identifier'] === IDENTIFIER && $array['name'] === NAME && $array['firstname'] === FIRSTNAME && $array['email'] === EMAIL && password_verify(PASSWORD, $array['password']) && ESTABLISHMENT === $array['key_establishments'] && ROLE === $array['key_roles'])
            $this->successTest();
        else 
            $this->writteFailure("exportToSQL");
    }
}

(new TestsUsers())->run();