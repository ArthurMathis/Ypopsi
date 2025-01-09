<?php

require_once('../../define.php');
require_once('TestsManipulations.php');
include '../../'.CLASSE.DS.'Candidate.php';

define('CANDIDATES_KEY', (int) 1);
define('CANDIDATES_NAME', 'Dupond');
define('CANDIDATES_FIRSTNAME', 'Jean');
define('CANDIDATES_GENDER', true);
define('CANDIDATES_EMAIL', 'jean.dupond@diaconat-mulhouse.fr');
define('CANDIDATES_PHONE', '06.38.85.55.57');
define('CANDIDATES_ADDRESS', '22 rue de la praire');
define('CANDIDATES_CITY', 'PrairieVille');
define('CANDIDATES_POSTCODE', '68100');
define('CANDIDATES_AVAILABILITY', '2024-12-25');
define('CANDIDATES_MEDICAL_VISITE', '2024-09-09');

/**
 * Class testing the Candidate class
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TestsCandidates extends TestsManipulation {
    /**
     * Public function running unit tests
     *
     * @return Void
     */
    public function run() {
        $this->writteH1("Tests de la classe Candidate.php");
        $this->writteH2("Tests de constructeurs");
        $this->writteH3("Tests classiques");
        $this->constructorTrue();
        $this->constructorPhoneNull();
        $this->constructorAddressNull();
        $this->constructorCityNull();
        $this->constructorPostcodeNull();
        $this->writteSuccess();

        $this->writteH3("Tests de détections des erreurs - False");
        $this->constructorNameFalse1();
        $this->constructorNameFalse2();
        $this->constructorFirstnameFalse1();
        $this->constructorFirstnameFalse2();
        $this->constructorEmailFalse1();
        $this->constructorEmailFalse2();
        $this->constructorEmailFalse3();
        $this->constructorPhoneFalse1();
        $this->constructorPhoneFalse2();
        $this->constructorPhoneFalse3();
        $this->constructorPhoneFalse4();
        $this->constructorPhoneFalse5();
        $this->constructorAddressFalse1();
        $this->constructorAddressFalse2();
        $this->constructorCityFalse1();
        $this->constructorCityFalse2();
        $this->constructorPostCodeFalse1();
        $this->constructorPostCodeFalse2();
        $this->constructorPostCodeFalse3();
        $this->writteSuccess();

        $this->writteH2("Tests de setters");
        $this->writteH3("Tests classiques");
        $this->setKeyTrue();
        $this->setAvailabilityTrue();
        $this->setMedicalVisitTrue();
        $this->writteSuccess();
        
        $this->writteH3("Tests de détections des erreurs - False");
        $this->setKeyFalse();
        $this->setAvailabilityFalse1();
        $this->setAvailabilityFalse2();
        $this->setAvailabilityFalse3();
        $this->setMedicalVisitFalse1();
        $this->setMedicalVisitFalse2();
        $this->setMedicalVisitFalse3();
        $this->writteSuccess();
        
        $this->writteH2("Tests de getters");
        $this->getKey();
        $this->getName();
        $this->getFirstname();
        $this->getPhone();
        $this->getEmail();
        $this->getAddress();
        $this->getCity();
        $this->getPostcode();
        $this->getAvailability();
        $this->getMedicalVisit();
        $this->writteSuccess();
        
        $this->writteH2("Tests d'exports");
        $this->writteH3("Tests classiques");
        $this->exportToSQLTrue();
        $this->exportToSQLTrue_WithoutVisit();
        $this->exportToSQL_update();
        $this->exportToSQL_Key();
        $this->writteSuccess();

        $this->writteH3("Tests de détections des erreurs - False");
        $this->exportToSQL_KeyFalse();
        $this->writteSuccess();
    }


    // * CONSTRUCTOR * //
    /**
     * Public function testing whether the builder works perfectly with all the parameters entered and intact
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorTrue() {
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);

        } catch(Exception $e) { 
            $this->writteFailure('constructorTrue'); 
        }
        $this->successTest();
    }

    //// NULL ////
    /**
     * Fonction testant si le constructeur fonctionne correctement avec le numéro de téléphone null
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorPhoneNull() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, NULL, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);

        } catch(Exception $e) { 
            $this->writteFailure('constructorPhoneNull'); 
        }
        $this->successTest();
    }
    /**
     * Fonction testant si le constructeur fonctionne correctement avec l'adresse null
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorAddressNull() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, NULL, CANDIDATES_CITY, CANDIDATES_POSTCODE);

        } catch(Exception $e) { 
            $this->writteFailure('constructorAddressNull'); 
        }
        $this->successTest();
    }
    /**
     * Fonction testant si le constructeur fonctionne correctement avec la ville null
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorCityNull() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, NULL, CANDIDATES_POSTCODE);

        } catch(Exception $e) { 
            $this->writteFailure('constructorCityNull'); 
        }
        $this->successTest();
    }
    /**
     * Fonction testant si le constructeur fonctionne correctement avec le code postal null
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function constructorPostcodeNull() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, NULL);

        } catch(Exception $e) { 
            $this->writteFailure('constructorPostcodeNull'); 
        }
        $this->successTest();
    }

    //// FALSE ////
    /**
     * Fonction publique testant la gestion des erreurs avec un nom contenant un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorNameFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate('1', CANDIDATES_FIRSTNAME, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorNameFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme nom
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorNameFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(1, CANDIDATES_FIRSTNAME, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorNameFalse2");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec un prénom contenant un entier
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorFirstnameFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, '1', CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorFirstnameFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme prénom
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorFirstnameFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, 1, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorFirstnameFalse2");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec un nom comme email
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorEmailFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_NAME, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorEmailFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme email
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorEmailFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, 1, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorEmailFalse2");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un email contenant un entier (uniquement)
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorEmailFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, '1', CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorEmailFalse3");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme numéro de téléphone
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPhoneFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, 123654789, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorNameFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un numéro de téléphone trop court
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPhoneFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, '0.2', CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPhoneFalse2");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un numéro de téléphone trop court (encore)
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPhoneFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, '0.22.23.21', CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPhoneFalse3");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un numéro de téléphone trop long
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPhoneFalse4() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, '0.22.23.21.24.26.32', CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPhoneFalse4");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un numéro de téléphone mal séparé
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPhoneFalse5() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, '022.2321.24', CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPhoneFalse5");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec une adresse comprenant des nombres entiers
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorAddressFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, "12354", CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorAddressFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme adresse
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorAddressFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, 1, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorAddressFalse2");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec une ville comprenant des nombres entiers
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorCityFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, "12354", CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorCityFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme ville
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorCityFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, 1, CANDIDATES_POSTCODE);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorCityFalse2");
    }

    /**
     * Fonction publique testant la gestion des erreurs avec un mot comme code postal
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPostcodeFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, "bonjour");
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPostcodeFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un entier comme code postal
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPostcodeFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, 12);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPostcodeFalse2");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un code postal trop long
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function constructorPostcodeFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, 123456789111213141516171819);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("constructorPostcodeFalse2");
    }

    // * SET * //

    /**
     * Fonction publique ajoutant un nombre entier comme clé 
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function setKeyTrue() {
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setKey(CANDIDATES_KEY);

        } catch(Exception $e) {
            $this->writteFailure("setKeyTrue1");
        }
        $this->successTest();  
    }

    /**
     * Fonction publique ajoutant une disponibilité (année-mois-jour)
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function setAvailabilityTrue() {
        $res = $this->SUCCESS();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setAvailability(CANDIDATES_AVAILABILITY); 

        } catch(Exception $e) {
            $this->writteFailure("setAvailabilityTrue1");
        }
        $this->successTest();  
    }

    /**
     * Fonction publique ajoutant une visite médicale
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function setMedicalVisitTrue() {
        $res = $this->SUCCESS();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setMedicalVisit(CANDIDATES_MEDICAL_VISITE);

        } catch(Exception $e) {
            $this->writteFailure("setMedicalVisitTrue");
        }
        $this->successTest();
    }

    //// FALSE ////
    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'une clé négative
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setKeyFalse() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setKey('-1');
            
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setKeyFalse1");
    }

    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'une entier négatif comme disponibilité
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setAvailabilityFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setAvailability(-1);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setAvailabilityFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'une heure comme disponibilté
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setAvailabilityFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setAvailability('12:03:36');
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setAvailabilityFalse2");
    }
    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'un mot comme disponibilité
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setAvailabilityFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setAvailability('Bonjour');
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setAvailabilityFalse3");
    }

    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'une entier négatif comme visite médicale
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setMedicalVisitFalse1() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setMedicalVisit(-1);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setMedicalVisitFalse1");
    }
    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'une heure comme visite médicale
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setMedicalVisitFalse2() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setMedicalVisit('12:03:36');
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setMedicalVisitFalse2");
    }
    /**
     * Fonction publique testant la gestion des erreurs lors de l'ajout d'un mot comme disponibilité 
     * 
     * Goal : Failure
     *
     * @return Void
     */
    public function setMedicalVisitFalse3() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setMedicalVisit('Bonjour');
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res) 
            $this->successTest();
        else 
            $this->writteFailure("setMedicalVisitFalse3");
    }


    // * GET * //
    /**
     * Fonction publique testant si le getKey retourne bien la clé
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getKey() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setKey(CANDIDATES_KEY);
        if(CANDIDATES_KEY === $c->getKey())
            $this->successTest();
        else 
            $this->writteFailure("getKey");
    }
    /**
     * Fonction publique testant si le getName retourne bien le nom
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getName() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_NAME === $c->getName())
            $this->successTest();
        else 
            $this->writteFailure("getName");
    }
    /**
     * Fonction publique testant si le getFirstname retourne bien le prénom
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getFirstname() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_FIRSTNAME === $c->getFirstname())
            $this->successTest();
        else 
            $this->writteFailure("getFirstname");
    }
    /**
     * Fonction publique testant si le getEmail retourne bien l'email
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getEmail() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_EMAIL === $c->getEmail())
            $this->successTest();
        else 
            $this->writteFailure("getEmail");
    }
    /**
     * Fonction publique testant si le getPhone retourne bien le nuùméro de téléphone
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getPhone() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_PHONE === $c->getPhone())
            $this->successTest();
        else 
            $this->writteFailure("getPhone");
    }
    /**
     * Fonction publique testant si le getAddress retourne bien l'adresse
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getAddress() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_ADDRESS === $c->getAddress())
            $this->successTest();
        else 
            $this->writteFailure("getAddress");   
    }
    /**
     * Fonction publique testant si le getCity retourne bien la ville
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getCity() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_CITY === $c->getCity())
            $this->successTest();
        else 
            $this->writteFailure("getCity");
    }
    /**
     * Fonction publique testant si le getPostcode retourne bien le codepostal
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getPostcode() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        if(CANDIDATES_POSTCODE === $c->getPostcode())
            $this->successTest();
        else 
            $this->writteFailure("getPostcode");
    }
    /**
     * Fonction publique testant si le getAvailabilité retourne bien la disponibilité
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getAvailability() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setAvailability(CANDIDATES_AVAILABILITY);
        if(CANDIDATES_AVAILABILITY === $c->getAvailability())
            $this->successTest();
        else 
            $this->writteFailure("getAvailability");
    }
    /**
     * Fonction publique testant si le getMedicalVisit retourne bien la visite médicale
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function getMedicalVisit() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setMedicalVisit(CANDIDATES_MEDICAL_VISITE);
        if(CANDIDATES_MEDICAL_VISITE === $c->getMedicalVisit())
            $this->successTest();
        else 
            $this->writteFailure("getMedicalVisit");
    }

    // * EXPORT * //
    /**
     * Fonction publique testant si l'export des données est juste
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQLTrue() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setMedicalVisit(CANDIDATES_MEDICAL_VISITE);
        $c->setAvailability(CANDIDATES_AVAILABILITY);
        $c = $c->exportToSQL();

        if(count($c) === 10 && $c["name"] ===  CANDIDATES_NAME && $c["firstname"] === CANDIDATES_FIRSTNAME && $c["email"] === CANDIDATES_EMAIL && $c["phone"] === CANDIDATES_PHONE && $c["address"] === CANDIDATES_ADDRESS && $c["city"] === CANDIDATES_CITY && $c["post_code"] === CANDIDATES_POSTCODE && $c["availability"] === CANDIDATES_AVAILABILITY && $c["medical_visit"] === CANDIDATES_MEDICAL_VISITE)
            $this->successTest();
        else 
            $this->writteFailure("exportToSQLTrue");
    }
    /**
     * Fonction publique testant si l'export des données sans visite médical est juste
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQLTrue_WithoutVisit() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setAvailability(CANDIDATES_AVAILABILITY);
        $c = $c->exportToSQL();

        if(count($c) === 9 && $c["name"] === CANDIDATES_NAME && $c["firstname"] === CANDIDATES_FIRSTNAME && $c["email"] === CANDIDATES_EMAIL && $c["phone"] === CANDIDATES_PHONE && $c["address"] === CANDIDATES_ADDRESS && $c["city"] === CANDIDATES_CITY && $c["post_code"] === CANDIDATES_POSTCODE && $c["availability"] === CANDIDATES_AVAILABILITY)
            $this->successTest();
        else 
            $this->writteFailure("exportToSQLTrue_WithoutVisit");
    }

    /**
     * Fonction publique testant si l'export des données sans visite médical est juste
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQL_update() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c = $c->exportToSQL_update();
        if(count($c) === 7 && $c["name"] === CANDIDATES_NAME && $c["firstname"] === CANDIDATES_FIRSTNAME && $c["email"] === CANDIDATES_EMAIL && $c["phone"] === CANDIDATES_PHONE && $c["address"] === CANDIDATES_ADDRESS && $c["city"] === CANDIDATES_CITY && $c["post_code"] === CANDIDATES_POSTCODE)
            $this->successTest();
        else 
            $this->writteFailure("exportToSQL_update");
    }
    /**
     * Fonction publique testant si l'export des données sans visite médical est juste
     * 
     * Goal : Success
     *
     * @return Void
     */
    public function exportToSQL_Key() {
        $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
        $c->setMedicalVisit(CANDIDATES_MEDICAL_VISITE);
        $c->setAvailability(CANDIDATES_AVAILABILITY);
        $c->setKey(CANDIDATES_KEY);
        $c = $c->exportToSQL_Key();
        if(count($c) === 10 && $c["id"] === CANDIDATES_KEY && $c["name"] ===  CANDIDATES_NAME && $c["firstname"] === CANDIDATES_FIRSTNAME && $c["email"] === CANDIDATES_EMAIL && $c["phone"] === CANDIDATES_PHONE && $c["address"] === CANDIDATES_ADDRESS && $c["city"] === CANDIDATES_CITY && $c["post_code"] === CANDIDATES_POSTCODE && $c["availability"] === CANDIDATES_AVAILABILITY && $c["medical_visit"] === CANDIDATES_MEDICAL_VISITE)
            $this->successTest();
        else 
            $this->writteFailure("exportToSQL_Key");
    }

    //// FALSE ////
    public function exportToSQL_KeyFalse() {
        $res = $this->FAILURE();
        try {
            $c = new Candidate(CANDIDATES_NAME, CANDIDATES_FIRSTNAME, CANDIDATES_GENDER, CANDIDATES_EMAIL, CANDIDATES_PHONE, CANDIDATES_ADDRESS, CANDIDATES_CITY, CANDIDATES_POSTCODE);
            $c->setMedicalVisit(CANDIDATES_MEDICAL_VISITE);
            $c->setAvailability(CANDIDATES_AVAILABILITY);
            $c = $c->exportToSQL_Key();
            
        } catch(InvalideCandidateExceptions|Exception $e) {
            $res = $this->SUCCESS();
        } 
        
        if($res)
            $this->successTest();
        else 
            $this->writteFailure("exportToSQL_KeyFalse");
    }
}