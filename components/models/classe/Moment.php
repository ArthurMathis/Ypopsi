<?php

define('FR', 'Europe/Paris');

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
     * Private attribute containing the moment's date
     * 
     * @var String The moment's date (Y-m-d)
     */
    private $date;
    /**
     * Private attribute containing the moment's hour
     * 
     * @var String The moment's hour (H:i:s)
     */
    private $hour;

    /**
     * Class constructor
     * 
     * @param Int $timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     */
    public function __construct(int $timestamp) {
        $this->setDate($timestamp);
        $this->setHour($timestamp);
    }

    /**
     * Public method returning the moment's date
     * 
     * @return String (Y-m-d)
     */
    public function getDate(): String { return $this->date; }
    /**
     * Public method returniing moment's hour
     * 
     * @return String (H:i:s)
     */
    public function getHour(): String { return $this->hour; }
    /**
     * Public method calculing and returning the moment's timestamp
     * 
     * @return Int The moment's timestamp
     */
    public function getTimestamp(): int { return strtotime($this->getDate() . ' ' . $this->getHour()); }


    /**
     * Private method setting the moment's date
     * 
     * @param Int $timestamp The moment's timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     * @return Void
     */
    private function setDate(int $timestamp){
        if(!$this->isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
            
        $this->date = date('Y-m-d', $timestamp);
    }
    /**
     * Private method setting the moment's hour
     * 
     * @param Int $timestamp The moment's timestamp
     * @throws InvalideMomentExceptions If the timestamp is invalid
     * @return Void
     */
    private function setHour(int $timestamp){
        if(!$this->isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
            
        $this->hour = date('H:i:s', $timestamp);
    }

    /**
     * Public method comparing two moment
     * 
     * @param Int $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean TRUE - If this moment's timestamp is taller than the second timestamp ; FALSE - if not
     */
    public function isTallerThan(int $timestamp): bool {
        if(!$this->isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");

        return $timestamp < $this->getTimestamp();
    }
    /**
     * Public method comparing two moment
     * 
     * @param Int $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean  TRUE - If this moment's timestamp is equal to the second timestamp ; FALSE - if not
     */
    public function isEqualTo($timestamp): bool {
        if(!$this->isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
        
        return $timestamp === $this->getTimestamp();
    }
    /**
     * Public method comparing two moment
     * 
     * @param Int $timestamp The moemnt's timestamp
     * @throws InvalideMomentExceptions If the moment's timestamp is invalid
     * @return boolean  TRUE - If this moment's timestamp is taller or equal to the second timestamp ; FALSE - if not
     */
    public function isTallerOrEqualTo(int $timestamp): bool {
        if(!$this->isTimestamp($timestamp))
            throw new InvalideMomentExceptions("Impossible de récupérer la date sans timestamp !");
        
        return $timestamp <= $this->getTimestamp();
    }

    /**
     * Public static method returning if a string represents a date or not
     * 
     * @param String $dateString The string containing the date 
     * @param String $format The date format
     * @return Boolean TRUE - if the string is a date ; FALSE - if not
     */
    public static function isDate(string $dateString, string $format = 'Y-m-d'): bool {
        $datetime = DateTime::createFromFormat($format, $dateString); 
        return $datetime && $datetime->format($format) === $dateString;
    }
    /**
     * Public static method returning if a string represents an hour or not
     * 
     * @param String $hourString The string containing the hour 
     * @param String $format The hour format
     * @return Boolean TRUE - if the string is an hour ; FALSE - if not
     */
    public static function isHour(string $hourString, string $format = 'H:i:s'): bool {
        if (strlen($hourString) === 5 && substr_count($hourString, ':') === 1) 
            $hourString .= ':00';

        $datetime = DateTime::createFromFormat($format, $hourString);
        return $datetime && $datetime->format($format) === $hourString;
    } 
    /**
     *  Public static method returning if one timestamp is valid or not
     * @param Int|String $timestamp The timestamp
     * @return boolean TRUE - If it is valid ; FALSE - if not
     */
    public static function isTimestamp(int $timestamp): bool { return 0 <= $timestamp; }
    /**
     *  Public static method creating the current moment
     * @return Moment The current moment
     */
    public static function currentMoment(): Moment { return new Moment(time()); }
    /**
     *  Public static method creating one moment from a date and an hour
     * @param String $date The date
     * @param String $hour The hour
     * @throws InvalideMomentExceptions If the date or the hour is invalid
     * @return Moment|Null 
     */
    public static function fromDate(string $date, string $hour = '12:00:00'): ?Moment {
        if(!Moment::isDate($date) || !Moment::isHour($hour))
            throw new InvalideMomentExceptions('Impossible de générer le moment sans date');
        
        return new Moment((new DateTime($date . ' ' . $hour, new DateTimeZone(FR)))->getTimestamp());
    }
    /**
     * Public static method returning the moment's date(Y-m-d H:i:s) 
     * 
     * * Using the method for the SQL requests
     * 
     * @param String $date The moment's date
     * @param String $hour The moment's time
     * @throws InvalideMomentExceptions If the InvalideMomentExceptions are invalids
     * @return Int|Null The date
     */
    public static function getTimestampFromDate(string $date, string $hour = '12:00:00'): ?int {
        if(!Moment::isDate($date) || !Moment::isHour($hour))
            throw new InvalideMomentExceptions('Impossible de générer le moment sans date');

        return date('Y-m-d H:i:s', (new DateTime($date . ' ' . $hour, new DateTimeZone(FR)))->getTimestamp());
    }
}