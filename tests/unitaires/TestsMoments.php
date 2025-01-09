<?php

require_once('../../define.php');
require_once('TestsManipulations.php');
include '../../'.CLASSE.DS.'Moment.php';

define('TIMESTAMP', 1065348000);
define('TIMESTAMP_2', 12345678911);
define('DATE', '2003-10-05');
define('HOUR', '12:00:00');

/**
 * Class ing the Moment class
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class TestsMoments extends TestsManipulation { 
    /**
     * Public function running unit tests
     *
     * @return Void
     */
    public function run() {
        $this->writteH1("Tests de la classe Moment.php");
        $this->writteH2("Tests de constructeurs");
        $this->writteH3("Tests classiques");
        $this->constructorTrue();
        $this->writteSuccess();
        $this->writteH3("Tests de détection des erreurs - False");
        $this->constructorFalse();
        $this->writteSuccess();
    
        $this->writteH2("Tests des getters");
        $this->getDate();
        $this->getHour();
        $this->getTimestamp();
        $this->currentMoment();
        $this->writteSuccess();
    
        $this->writteH2("Méthodes statiques");
        $this->writteH3("Tests classiques");
        $this->isDateTrue();
        $this->isHourTrue1();
        $this->isHourTrue2();
        $this->isTimestampTrue();
    
        $this->writteSuccess();
        $this->writteH3("Tests de détection des erreurs - False");
        $this->isDateFalse1();
        $this->isDateFalse2();
        $this->isDateFalse3();
        $this->isDateFalse4();
        $this->isDateFalse5();
        $this->isDateFalse6();
        $this->isHourFalse1();
        $this->isHourFalse2();
        $this->isHourFalse3();
        $this->isHourFalse4();
        $this->isHourFalse5();
        $this->isHourFalse6();
        $this->isTimestampFalse();
        $this->writteSuccess();
    
        $this->writteH2("Méthodes de comparaison");
        $this->writteH3("Tests classiques");
        $this->isTallerThanTrue();
        $this->isEqualToTrue();
        $this->isTallerOrEqualToTrue();
        $this->writteSuccess();
        $this->writteH3("Tests de détection des erreurs - False");
        $this->isTallerThanFalse();
        $this->isEqualToFalse();
        $this->isTallerOrEqualToFalse();
        $this->writteSuccess();

        $this->writteH2("Tests de fromDate");
        $this->writteH3("Tests classiques");
        $this->fromDateTrue1();
        $this->fromDateTrue2();
        $this->writteSuccess();
        $this->writteH3("Tests de détection des erreurs - False");
        $this->fromDateFalse1();
        $this->fromDateFalse2();
        $this->fromDateFalse3();
        $this->fromDateFalse4();
        $this->fromDateFalse5();
        $this->fromDateFalse6();
        $this->fromDateFalse7();
        $this->fromDateFalse8();
        $this->fromDateFalse9();
        $this->writteSuccess();
    }

    // * CONSTRUCTEUR * //
    /**
     * Fonction publique testant si le constructeur fonctionne correctement
     * 
     * Goal : Success
     *
     * @return Void
     */
    function constructorTrue() {
        try {
            $m = new Moment(TIMESTAMP);

        } catch(Exception $e) {
            echo $e; exit;
            $this->writteFailure("constructorTrue");
        }
        $this->successTest();
    }

    ////  FALSE ////
    /**
     * Fonction publique testant la gestion des erreurs avec un timestamp négatif
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function constructorFalse() {
        $res = $this->FAILURE();
        try {
            $m = new Moment(-1);
        } catch(Exception $e) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else 
            $this->writteFailure("constructorFalse1");
    }

    // *  GET * //
    /**
     * Fonction publique testant la fonction getDate
     * 
     * Goal : Success
     *
     * @return Void
     */
    function getDate() {
        $m = new Moment(TIMESTAMP);
        if($m->getDate() === DATE)
            $this->successTest();
        else 
            $this->writteFailure("getDate");

    }
    /**
     * Fonction publique testant la fonction getHour
     * 
     * Goal : Success
     *
     * @return Void
     */
    function getHour() {
        $m = new Moment(TIMESTAMP);
        if($m->getHour() === HOUR)
            $this->successTest();
        else 
            $this->writteFailure("getHour");
    }
    /**
     * Fonction publique testant la fonction getTimestamp
     * 
     * Goal : Success
     *
     * @return Void
     */
    function getTimestamp() {
        $m = new Moment(TIMESTAMP);
        if($m->getTimestamp() === TIMESTAMP)
            $this->successTest();
        else 
            $this->writteFailure("getTimestamp");
    }
    /**
     * Fonction publique testant la fonction currentMoment
     * 
     * Goal : Success
     *
     * @return Void
     */
    function currentMoment() {
        $t = time();
        $m = new Moment($t);
        $time = $m->getTimestamp();

        if($time === $t)
            $this->successTest();
        else 
            $this->writteFailure("currentMoment");
    }

    // * IS * //
    //// DATE ////
    /**
     * Fonction publique testant si la méthode isDate foctionne correctement
     * 
     * Goal : Success
     *
     * @return Void
     */
    function isDateTrue() {
        if(Moment::isDate(DATE))
            $this->successTest();
        else 
            $this->writteFailure("isDateTrue");
    }
    /**
     * Fonction publique testant la gestion des erreurs avec une date incomplète
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse1() {
        if(Moment::isDate('2024-08'))
            $this->writteFailure("isDateFalse1");
        else 
            $this->successTest(); 
    }
    /**
     * Fonction publique testant la gestion des erreurs avec une date incomplète
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse2() {
        if(Moment::isDate('20-24-08'))
            $this->writteFailure("isDateFalse2");
        else 
            $this->successTest(); 
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un mois inexistant
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse3() {
        if(Moment::isDate('2024-24-08'))
            $this->writteFailure("isDateFalse3");
        else 
            $this->successTest(); 
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un jour inexistant
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse4() {
        if(Moment::isDate('2024-02-30'))
            $this->writteFailure("isDateFalse4");
        else 
            $this->successTest(); 
    }
    /**
     * Fonction publique testant la gestion des erreurs avec une date incomplète
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse5() {
        if(Moment::isDate('2024-2-3'))
            $this->writteFailure("isDateFalse5");
        else 
            $this->successTest(); 
    }
    /**
     * Fonction publique testant la gestion des erreurs avec un mot comme date
     * 
     * Goal : Failure
     *
     * @return Void
     */
    function isDateFalse6() {
        if(Moment::isDate('bonjour à tous'))
            $this->writteFailure("isDateFalse6");
        else 
            $this->successTest(); 
    }


    //// HOUR ////
    /**
     * Fonction publique testant si la méthode isHour foctionne correctement
     * 
     * Goal : Success
     *
     * @return Void
     */
    function isHourTrue1() {
        if(Moment::isHour(HOUR))
            $this->successTest();
        else 
            $this->writteFailure("isHourTrue1");
    }
    /**
     * Fonction publique testant si la méthode isHour foctionne correctement avec une heure abrégée
     * 
     * Goal : Success
     *
     * @return Void
     */
    function isHourTrue2() {
        if(Moment::isHour('12:30'))
            $this->successTest();
        else 
            $this->writteFailure("isHourTrue2");
    }
    function isHourFalse1() {
        if(Moment::isHour(TIMESTAMP))
            $this->writteFailure("isHourFalse1");
        else 
            $this->successTest(); 
    }
    function isHourFalse2() {
        if(Moment::isHour('Bonjour à tous'))
            $this->writteFailure("isHourFalse2");
        else 
            $this->successTest(); 
    }
    function isHourFalse3() {
        if(Moment::isHour('26:12:12'))
            $this->writteFailure("isHourFalse3");
        else 
            $this->successTest(); 
    }
    function isHourFalse4() {
        if(Moment::isHour('06:72:12'))
            $this->writteFailure("isHourFalse4");
        else 
            $this->successTest(); 
    }
    function isHourFalse5() {
        if(Moment::isHour('06:2:2'))
            $this->writteFailure("isHourFalse5");
        else 
            $this->successTest(); 
    }
    function isHourFalse6() {
        if(Moment::isHour(123456))
            $this->writteFailure("isHourFalse6");
        else 
            $this->successTest(); 
    }

    //// TIMESTAMP ////
    /**
     * Fonction publique testant si la méthode isTimestamp foctionne correctement
     * 
     * Goal : Success
     *
     * @return Void
     */
    function isTimestampTrue() {
        if(Moment::isTimestamp(TIMESTAMP))
            $this->successTest();
        else
            $this->writteFailure("isTimestampTrue");
    }
    function isTimestampFalse() {
        if(Moment::isTimestamp(-1))
            $this->writteFailure("isTimestampFalse");
        else
            $this->successTest();
    }
    
    //// COMPARE ////
    function isTallerThanTrue() {
        $m = new Moment(TIMESTAMP_2);
        if($m->isTallerThan(TIMESTAMP))
            $this->successTest();
        else
            $this->writteFailure("isTallerThanTrue");
    }
    function isTallerThanFalse() {
        $m = new Moment(TIMESTAMP);
        if($m->isTallerThan(TIMESTAMP_2))
            $this->writteFailure("isTallerThanFalse");
        else
            $this->successTest();
    }
    function isEqualToTrue() {
        $m = new Moment(TIMESTAMP);
        if($m->isEqualTo(TIMESTAMP))
            $this->successTest();
        else
        $this->writteFailure("isEqualToTrue");
    }
    function isEqualToFalse() {
        $m = new Moment(TIMESTAMP);
        if($m->isEqualTo(TIMESTAMP_2))
            $this->writteFailure("isEqualToFalse");
        else
            $this->successTest();
    }
    function isTallerOrEqualToTrue() {
        $m = new Moment(TIMESTAMP);
        if($m->isTallerOrEqualTo(TIMESTAMP))
            $this->successTest();
        else
        $this->writteFailure("isTallerOrEqualToTrue");
    }
    function isTallerOrEqualToFalse() {
        $m = new Moment(TIMESTAMP);
        if($m->isTallerOrEqualTo(TIMESTAMP_2))
            $this->writteFailure("isTallerOrEqualToFalse");
        else
            $this->successTest();
    }

    // * FROM * //
    function fromDateTrue1() {
        $res = $this->SUCCESS();
        try {
            $m = Moment::fromDate(DATE, HOUR);
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res) 
            $this->successTest();  
        else
            $this->writteFailure("fromDateTrue1");
    }
    function fromDateTrue2() {
        $res = $this->SUCCESS();
        try {
            $m = Moment::fromDate(DATE);
        } catch(Exception) {
            $res = $this->FAILURE();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateTrue2");
    }
    function fromDateFalse1() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate('Bonjour');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse1");
    }
    function fromDateFalse2() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate('1');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse2");
    }
    function fromDateFalse3() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate(-123);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse3");
    }
    function fromDateFalse4() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate('24-20-26');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse4");
    }
    function fromDateFalse5() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate('2024-2-2');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse5");
    }
    function fromDateFalse6() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate('2024-12');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse6");
    }
    function fromDateFalse7() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate(DATE, 12);
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse7");
    }
    function fromDateFalse8() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate(DATE, '1:2:3');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse8");
    }
    function fromDateFalse9() {
        $res = $this->FAILURE();
        try {
            $m = Moment::fromDate(DATE, '12:23:34:45');
        } catch(Exception) {
            $res = $this->SUCCESS();
        }
        
        if($res)
            $this->successTest();
        else
            $this->writteFailure("fromDateFalse9");
    }
}