<?php

namespace App\Core;

use \DateTime;
use \DateTimeZone;
use App\Exceptions\MomentExceptions;

/**
 * Class representing a moment (time)
 * 
 * @author Arthur MATHIS - arthur.mathi@diaconat-mulhouse.fr
 */
class Moment {
    /**
     *  Class constructor
     * @param string $date The date at the format (Y-m-d h:m:s)
     * @throws MomentExceptions If the date is invalid
     */
    public function __construct(protected string $date) {}

    // * GET * //
    /**
     * Public method returning the date
     * 
     * @return string
     */
    public function getDate(): String { return $this->date; }
    /**
     * Public method calculing and returning the moment's timestamp
     * 
     * @return int The moment's timestamp
     */
    public function getTimestamp(): int { return strtotime($this->getDate());}

    public static function hourToTimsetamp(int $hour): int {
        return $hour * 60;
    }


    
    // * STATIC * //
    /**
     *  Public static method creating the current moment
     * @return Moment The current moment
     */
    public static function currentMoment(): Moment {
        $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));

        return new Moment($dateTime->format('Y-m-d H:i:s'));
    }

    //// IS ////
    /**
     *  Public static method returning if a string represents a date or not
     * @param String $dateString The string containing the date 
     * @param String $format The date format
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    public static function isDate($dateString, $format = 'Y-m-d'): bool {
        $dateTime = DateTime::createFromFormat($format, $dateString);

        return $dateTime && $dateTime->format($format) === $dateString;
    }
    /**
     *  Public static method returning if a string represents a date or not
     * @param String $dateString The string containing the date 
     * @param String $format The date format
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    public static function isFullDate($dateString): bool {
        return Moment::isDate($dateString, "Y-m-d H:i:s");
    }
    /**
     *  Public static method returning if a string represents an hour or not
     * @param String $hourString The string containing the hour 
     * @param String $format The hour format
     * @return bool TRUE - if the string is an hour ; FALSE - if not
     */
    public static function isHour($hourString, $format = 'H:i:s'): bool {
        if (strlen($hourString) === 5 && substr_count($hourString, ':') === 1) {
            $hourString .= ':00';
        }

        $dateTime = DateTime::createFromFormat($format, $hourString);

        return $dateTime && $dateTime->format($format) === $hourString;
    } 

    //// CONVERT ////
    /**
     * Public static method converting a date into a day (Y-m-d)
     * 
     * @param string $date The date (Y-m-d h:m:s)
     * @throws MomentExceptions If the date is invalid
     * @return string The date at the day format
     */
    public static function dayFromDate(string $date): string {
        if(!Moment::isFullDate($date)) {
            throw new MomentExceptions("La date : {$date} est invalide.");
        }

        return (new DateTime($date))->format("Y-m-d");
    }
    /**
     * Public static method converting a date into an hour (h:m:s)
     * 
     * @param string $date The date (Y-m-d h:m:s)
     * @throws MomentExceptions If the date is invalid
     * @return string The date at the hour format
     */
    public static function hourFromDate(string $date): string {
        if(!Moment::isFullDate($date)) {
            throw new MomentExceptions("La date : {$date} est invalide.");
        }

        return (new DateTime($date))->format("H:i:s");
    }
}