<?php

namespace App\Core\Tools\DataFormat;

use \DateTime;
use \DateTimeZone;
use App\Exceptions\TimeManagerExceptions;

/**
 * Class representing a TimeManager 
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class TimeManager {
    /**
     * Class constructor
     * 
     * @param string $date The date at the format : Y-m-d h:m:s
     * @throws TimeManagerExceptions If the date is invalid
     */
    public function __construct(
        protected string $date
    ) {
        if(!TimeManager::isFullDate($date)) {
            throw new TimeManagerExceptions("La date : {$date} est invalide.");
        }
    }

    // * GET * //
    /**
     * Public method returning the date
     * 
     * @return string
     */
    public function getDate(): string { return $this->date; }
    /**
     * Public method calculing and returning the TimeManager's timestamp
     * 
     * @return int The TimeManager's timestamp
     */
    public function getTimestamp(): int { return strtotime($this->getDate());}


    // * STATIC * //
    /**
     * Public static method creating the current TimeManager
     * 
     * @return TimeManager The current TimeManager
     */
    public static function currentTime(): TimeManager {
        $zone = getenv('TIMEZONE');
        $format = getenv('FULL_DATE_FORMAT');
        $dateTime = new DateTime('now', new DateTimeZone($zone));
        return new TimeManager($dateTime->format($format));
    }

    //// IS ////
    /**
     * Protected static method returning if a string represents a date or not
     * 
     * @param string $datestring The string containing the date 
     * @param string $format The date format
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    protected static function isValidDate(string $datestring, string $format): bool {
        $dateTime = DateTime::createFromFormat($format, $datestring);
        return $dateTime && $dateTime->format($format) === $datestring;
    }
    
    /**
     * Public static method returning if a string represents a small date or not
     * 
     * @param string $datestring The string containing the date 
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    public static function isYmdDate(string $date) : bool {
        $format = getenv('SMALL_DATE_FORMAT');
        return TimeManager::isValidDate($date, $format);
    }
    /**
     * Public static method returning if a string represents a full date or not
     * 
     * @param string $datestring The string containing the date 
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    public static function isFullDate(string $date): bool {
        $format = getenv('FULL_DATE_FORMAT');
        return TimeManager::isValidDate($date, $format);
    }
    /**
     * Public static method returning if a string represents a date or not
     * 
     * @param string $datestring The string containing the date 
     * @return bool TRUE - if the string is a date ; FALSE - if not
     */
    public static function isDate(string $date): bool {
        return TimeManager::isYmdDate($date) || TimeManager::isFullDate($date);
    }
    /**
     * Public static method returning if a string represents an hour or not
     * 
     * @param string $hour The string containing the hour 
     * @return bool TRUE - if the string is an hour ; FALSE - if not
     */
    public static function isHour(string $hour): bool {
        if (strlen($hour) === 5 && substr_count($hour, ':') === 1) {
            $hour .= ':00';
        }

        $format = getenv('HOUR_FORMAT');
        return TimeManager::isValidDate($hour, $format);
    } 

    //// CONVERT ////
    /**
     * Public static method converting a date into a day (Y-m-d)
     * 
     * @param string $date The date (Y-m-d h:m:s)
     * @throws TimeManagerExceptions If the date is invalid
     * @return string The date at the day format
     */
    public static function dayFromDate(string $date): string {
        if(!TimeManager::isFullDate($date)) {
            throw new TimeManagerExceptions("La date : {$date} est invalide.");
        }

        $format = getenv('SMALL_DATE_FORMAT');
        return (new DateTime($date))->format($format);
    }
    /**
     * Public static method converting a date into an hour (h:m:s)
     * 
     * @param string $date The date (Y-m-d h:m:s)
     * @throws TimeManagerExceptions If the date is invalid
     * @return string The date at the hour format
     */
    public static function hourFromDate(string $date): string {
        if(!TimeManager::isFullDate($date)) {
            throw new TimeManagerExceptions("La date : {$date} est invalide.");
        }

        $format = getenv('HOUR_FORMAT');
        return (new DateTime($date))->format($format);
    }

    /**
     * Public method returning of one hour in timestamp
     *
     * @param int $hour
     * @return int
     */
    public static function hourToTimsetamp(int $hour): int { return $hour * 60; }
}