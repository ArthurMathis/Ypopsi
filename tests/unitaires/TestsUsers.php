<?php

require_once('../../define.php');
require_once('TestsManipulations.php');
include '../../'.CLASSE.DS.'User.php';

define('USER_KEY', 1);
define('USER_IDENTIFIER', 'mathis.a');
define('USER_NAME', 'Mathis');
define('USER_FIRSTNAME', 'Arthur');
define('USER_EMAIL', 'arthur.mathis@diaconat-mulhouse.fr');
define('USER_PASSWORD', 'Arthur123');
define('USER_ESTABLISHMENT', 1);
define('USER_ROLE', 1);
define('USER_ARRAY_WITH_KEY', ['key' => USER_KEY, 'identifier' => USER_IDENTIFIER, 'name' => USER_NAME, 'firstname' => USER_FIRSTNAME, 'email' => USER_EMAIL, 'password' => USER_PASSWORD, 'establishment' => USER_ESTABLISHMENT, 'role' => USER_ROLE]);
define('USER_ARRAY_WITHOUT_KEY', ['identifier' => USER_IDENTIFIER, 'name' => USER_NAME, 'firstname' => USER_FIRSTNAME, 'email' => USER_EMAIL, 'password' => USER_PASSWORD, 'establishment' => USER_ESTABLISHMENT, 'role' => USER_ROLE]);

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
        $this->writeH1("Tests de la classe User.php");
        $this->writeH2("Tests de constructeurs");
        $this->writeH3("Tests classique");
        $this->constructorTrue();

        $this->writeSuccess();
        $this->writeH3("Tests de détection des erreurs - False");
        $this->constructorIdentifierFalse();
        $this->constructorNameFalse();
        $this->constructorFirstnameFalse();
        $this->constructorEmailFalse();
        $this->constructorEstablishmentFalse();
        $this->constructorRoleFalse();
        $this->writeSuccess();

        $this->writeH2("Tests de getters");
        $this->getIdentifier();
        $this->getName();
        $this->getFirstname();
        $this->getEmail();
        $this->getPassword();
        $this->getEstablishment();
        $this->getRole();
        $this->writeSuccess();

        $this->writeH2("Méthodes statiques");
        $this->makeUserWithoutKey();
        $this->makeUserWithKey();
        $this->writeSuccess();

        $this->writeH2("Méthodes d'exports");
        $this->exportToArrayWithoutKey();
        $this->exportToArrayWithKey();
        $this->exportToSQL();
        $this->writeSuccess();
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
            $u = new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) { 
            $this->writeFailure('constructorTrue'); 
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
            $u = new User('1', USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writeFailure("constructorIdentifierFalse");
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
            $u = new User(USER_IDENTIFIER, '1', USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorNameFalse");
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
            $u = new User(USER_IDENTIFIER, USER_NAME, '1', USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorFirstnameFalse");
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
            $u = new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_NAME, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorEmailFalse");
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
            $u = new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, 123, USER_ESTABLISHMENT, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorPasswordFalse");
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
            $u = new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_NAME, USER_PASSWORD, -1, USER_ROLE);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorEstablishmentFalse");
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
            $u = new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_NAME, USER_PASSWORD, USER_ESTABLISHMENT, -1);

        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }  

        if($res)
            $this->successTest();
        else 
            $this->writeFailure("constructorRoleFalse");
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
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getIdentifier() === USER_IDENTIFIER)
            $this->successTest();
        else 
            $this->writeFailure("getIdentifier");
    }
    /**
     * Fonction publique testant la fonction getName
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getName() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getName() === USER_NAME)
            $this->successTest();
        else 
            $this->writeFailure("getName");
    }
    /**
     * Fonction publique testant la fonction getFirstname
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getFirstname() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getFirstname() === USER_FIRSTNAME)
            $this->successTest();
        else 
            $this->writeFailure("getFirstname");
    }
    /**
     * Fonction publique testant la fonction getEmail
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getEmail() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getEmail() === USER_EMAIL)
            $this->successTest();
        else 
            $this->writeFailure("getEmail");
    }
    /**
     * Fonction publique testant la fonction getPassword
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getPassword() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getPassword() === USER_PASSWORD)
            $this->successTest();
        else 
            $this->writeFailure("getPassword");
    }
    /**
     * Fonction publique testant la fonction getEstablishment
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getEstablishment() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getEstablishment() === USER_ESTABLISHMENT)
            $this->successTest();
        else 
            $this->writeFailure("getEstablishment");
    }
    /**
     * Fonction publique testant la fonction getRole
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getRole() {
        if((new User(USER_IDENTIFIER, USER_NAME, USER_FIRSTNAME, USER_EMAIL, USER_PASSWORD, USER_ESTABLISHMENT, USER_ROLE))->getRole() === USER_ROLE)
            $this->successTest();
        else 
            $this->writeFailure("getRole");
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
        $u = User::makeUser(USER_ARRAY_WITHOUT_KEY);
        if($u->getIdentifier() === USER_IDENTIFIER && $u->getName() === USER_NAME && $u->getFirstname() === USER_FIRSTNAME && $u->getEmail() === USER_EMAIL &&$u->getPassword() === USER_PASSWORD && $u->getEstablishment() === USER_ESTABLISHMENT && $u->getRole() === USER_ROLE && $u->getKey() === NULL)
            $this->successTest();
        else 
            $this->writeFailure("makeUserWithoutKey");
    }
    /**
     * Fonction publique testant la génération d'un utilisateur depuis un tableau de données avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function makeUserWithKey() {
        $u = User::makeUser(USER_ARRAY_WITH_KEY);
        if($u->getIdentifier() === USER_IDENTIFIER && $u->getName() === USER_NAME && $u->getFirstname() === USER_FIRSTNAME && $u->getEmail() === USER_EMAIL &&$u->getPassword() === USER_PASSWORD && $u->getEstablishment() === USER_ESTABLISHMENT && $u->getRole() === USER_ROLE && $u->getKey() === USER_KEY)
            $this->successTest();
        else 
            $this->writeFailure("makeUserWithKey");
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
        $array = User::makeUser(USER_ARRAY_WITHOUT_KEY)->exportToArray();
        if($array === ['identifier' => USER_IDENTIFIER, 'email' => USER_EMAIL, 'password' => USER_PASSWORD, 'role' => USER_ROLE, 'key' => NULL]) 
            $this->successTest();
        else 
            $this->writeFailure("exportToArrayWithoutKey");
    }
    /**
     * Fonction publique testant l'exportation d'un utilisateur avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToArrayWithKey() {
        $array = User::makeUser(USER_ARRAY_WITH_KEY)->exportToArray();
        if($array === ['identifier' => USER_IDENTIFIER, 'email' => USER_EMAIL, 'password' => USER_PASSWORD, 'role' => USER_ROLE, 'key' => USER_KEY]) 
            $this->successTest();
        else 
            $this->writeFailure("exportToArrayWithKey");
    }
    /**
     * Fonction publique testant l'exportation SQL d'un utilisateur avec clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQL() {
        $array = User::makeUser(USER_ARRAY_WITHOUT_KEY)->exportToSQL();
        if($array['identifier'] === USER_IDENTIFIER && $array['name'] === USER_NAME && $array['firstname'] === USER_FIRSTNAME && $array['email'] === USER_EMAIL && password_verify(USER_PASSWORD, $array['password']) && USER_ESTABLISHMENT === $array['key_establishments'] && USER_ROLE === $array['key_roles'])
            $this->successTest();
        else 
            $this->writeFailure("exportToSQL");
    }
}