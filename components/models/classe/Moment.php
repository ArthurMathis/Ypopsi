<?php

/**
 *  Class representing one moment's Exception
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class InvalideMomentExceptions extends Exception {
    public function __construct($message){
        parent::__construct($message);
    }
}

/**
 * Class representing a moment (time)
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Moment {
    /**
     *  Private attribute containing the moment's date
     * @var String The moment's date (Y-m-d)
     */
    private $date;
    /**
     *  Private attribute containing the moment's hour
     * @var String The moment's hour (H:i:s)
     */
    private $hour;

    /**
     *  Class constructor
     * @param Int $timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     */
    public function __construct($timestamp) {
        $this->setDate($timestamp);
        $this->setHour($timestamp);
    }

    /**
     *  Public method returning the moment's date
     * @return String (Y-m-d)
     */
    public function getDate(): String { return $this->date; }
    /**
     *  Publuc method returniing moment's hour
     * @return String (H:i:s)
     */
    public function getHour(): String { return $this->hour; }
        /**
     *  Public method calculing and returning the moment's timestamp
     * @return Int The moment's timestamp
     */
    public function getTimestamp(): int {
        return strtotime($this->getDate() . ' ' . $this->getHour());
    }


    /**
     *  Private method setting the moment's date
     * @param Int $timestamp The moment's timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     * @return void
     */
    private function setDate($timestamp){
        if(!Moment::isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
            
        $this->date = date('Y-m-d', $timestamp);
    }
    /**
     *  Private method setting the moment's hour
     * @param Int $timestamp The moment's timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     * @return void
     */
    private function setHour($timestamp){
        if(!Moment::isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
            
        $this->hour = date('H:i:s', $timestamp);
    }

    /**
     *  Public method comparing two moment
     * @param Int|String $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean TRUE - If this moment's timestamp is taller than the second timestamp ; FALSE - if not
     */
    public function isTallerThan($timestamp): bool {
        if(!Moment::isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");

        return intval($timestamp) < $this->getTimestamp();
    }
    /**
     *  Public method comparing two moment
     * @param Int|String $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean  TRUE - If this moment's timestamp is equal to the second timestamp ; FALSE - if not
     */
    public function isEqualTo($timestamp): bool {
        if(!Moment::isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
        
        return intval($timestamp) === $this->getTimestamp();
    }
    /**
     *  Public method comparing two moment
     * @param Int|String $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean  TRUE - If this moment's timestamp is taller or equal to the second timestamp ; FALSE - if not
     */
    public function isTallerOrEqualTo($timestamp): bool {
        if(!Moment::isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
        
        return intval($timestamp) <= $this->getTimestamp();
    }

    /**
     *  Public static method returning if a string represents a date or not
     * @param String $dateString The string containing the date 
     * @param String $format The date format
     * @return Boolean TRUE - if the string is a date ; FALSE - if not
     */
    public static function isDate($dateString, $format = 'Y-m-d'): bool {
        $dateTime = DateTime::createFromFormat($format, $dateString);
        return $dateTime && $dateTime->format($format) === $dateString;
    }
    /**
     *  Public static method returning if a string represents an hour or not
     * @param String $hourString The string containing the hour 
     * @param String $format The hour format
     * @return Boolean TRUE - if the string is an hour ; FALSE - if not
     */
    public static function isHour($hourString, $format = 'H:i:s'): bool {
        if (strlen($hourString) === 5 && substr_count($hourString, ':') === 1) 
            $hourString .= ':00';
        $dateTime = DateTime::createFromFormat($format, $hourString);
        return $dateTime && $dateTime->format($format) === $hourString;
    } 
    /**
     *  Public static method returning if one timestamp is valid or not
     * @param Int|String $timestamp The timestamp
     * @return boolean TRUE - If it is valid ; FALSE - if not
     */
    public static function isTimestamp($timestamp): bool {
        return !(empty($timestamp) || !is_numeric($timestamp) || intval($timestamp) < 0);
    }
    /**
     *  Public static method creating the current moment
     * @return Moment The current moment
     */
    public static function currentMoment(): Moment {
        return new Moment(time());
    }
    /**
     *  Public static method creating one moment from a date and an hour
     * @param String $date The date
     * @param String $hour The hour
     * @throws InvalideMomentExceptions If the date or the hour is invalid
     * @return Moment|NULL 
     */
    public static function fromDate($date, $hour = '12:00:00'): ?Moment {
        if(!Moment::isDate($date) || !Moment::isHour($hour))
            throw new InvalideMomentExceptions('Impossible de générer le moment sans date');

        return new Moment(strtotime($date . ' ' . $hour));
    }
}