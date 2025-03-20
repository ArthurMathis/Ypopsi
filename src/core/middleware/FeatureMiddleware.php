<?php

namespace App\Core\Middleware;

use App\Exceptions\FeatureExceptions;
use App\Repository\FeatureRepository;

/**
 * Class checking the feature availability
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class FeatureMiddleware {
        // * REQUEST * //
    /**
     * Public static method handle a url request and checking if the feature is enable or not
     *
     * @param ?array $key_features The feature's primary key
     * @return void
     */
    public static function handle(?array $key_features = null): void {
        if(is_null($key_features) || empty($key_features)) { 
            return ;
        }

        $feat_repo = new FeatureRepository();

        foreach($key_features as $obj) {
            $feature = $feat_repo->get($obj);

            $error = "La fonctionnalité : '<b>" . $feature->getTitled() . "</b>' a été temporairement désactivée. Veuillez réessayer ultérieurement.<br>Si l'incident persiste, <b>contactez le support informatique</b> via l'adresse : <a href=\"mailto:" . getenv("APP_SUPPORT") . "\">" . getenv("APP_SUPPORT") . "</a>";

            if(!$feature->getEnable()) {
                throw new FeatureExceptions($error);
            }
        }
    }

    // * ATTRIBUTE * //
    /**
     * Public static attribute containing the connexion feature's primary key
     *
     * @var int
     */
    public static int $CONNEXION = 1;

    /**
     * Public static attribute containing the display candidate features' primary key
     *
     * @var int
     */
    public static int $DISPLAY_CANDIDATES = 2, $DISPLAY_CANDIDATE = 3, $DISPLAY_APPLICATIONS = 4;
    /**
     * Public static attribute containing the inscript candidate features' primary key
     *
     * @var int
     */
    public static int $INSCRIPT_CANDIDATE = 5, $INSCRIPT_CONTRACT = 6, $INSCRIPT_OFFER = 7, $INSCRIPT_APPLICATIPON = 8, $INSCRIPT_MEETING = 9, $INSCRIPT_DOCUMENT = 10;
    /**
     * Public static attribute containing the edit candidate features' primary key
     *
     * @var int
     */
    public static int $EDIT_CANDIDATE = 11, $EDIT_RATING = 12, $EDIT_CONTRACT = 13, $EDIT_OFFER = 14, $EDIT_APPLICATIPON = 15, $EDIT_MEETING = 16, $EDIT_DOCUMENT = 17;
    /**
     * Public static attribute containing the delete candidate features' primary key
     *
     * @var int
     */
    public static int $DELETE_CANDIDATE = 18, $DELETE_MEETING = 19, $DELETE_DOCUMENT = 20;
    /**
     * Public static attribute containing the manage candidate features' primary key
     *
     * @var int
     */
    public static int $MANAGE_CONTRACT = 21, $MANAGE_OFFER = 22, $MANAGE_APPLICATIPON = 23;

    /**
     * Public static attribute containing the display user features' primary key
     *
     * @var int
     */
    public static int $DISPLAY_USER = 24, $DISPLAY_USERS = 25, $DISPLAY_CONNEXIONS = 26, $DISPLAY_ACTIONS = 27;
    /**
     * Public static attribute containing the manage user features' primary key
     *
     * @var int
     */
    public static int $INSCRIPT_USER = 28, $EDIT_USER = 29, $DELETE_USER = 30, $EDIT_PASSWORD = 50, $RESET_PASSWORD = 51;

    /**
     * Public static attribute containing the display recruitment features' primary key
     *
     * @var int
     */
    public static int $DISPLAY_JOBS = 31, $DISPLAY_QUALIFICATIONS = 32, $DISPLAY_SOURCES = 33;
    /**
     * Public static attribute containing the inscript recruitment features' primary key
     *
     * @var int
     */
    public static int $INSCRIPT_JOBS = 34, $INSCRIPT_QUALIFICATIONS = 35, $INSCRIPT_SOURCES = 36;
    /**
     * Public static attribute containing the edit recruitment features' primary key
     *
     * @var int
     */
    public static int $EDIT_JOBS = 37, $EDIT_QUALIFICATIONS = 38, $EDIT_SOURCES = 39;

    /**
     * Public static attribute containing the display foundation features' primary key
     *
     * @var int
     */
    public static int $DISPLAY_SERVICES = 40, $DISPLAY_ESTABLISHMENTS = 41, $DISPLAY_HUBS = 42;
    /**
     * Public static attribute containing the inscript foundation features' primary key
     *
     * @var int
     */
    public static int $INSCRIPT_SERVICES = 43, $INSCRIPT_ESTABLISHMENTS = 44, $INSCRIPT_HUBS = 45;
    /**
     * Public static attribute containing the edit foundation features' primary key
     *
     * @var int
     */
    public static int $EDIT_SERVICES = 46, $EDIT_ESTABLISHMENTS = 47, $EDIT_HUBS = 48;

    /**
     * Public static attribute containing the data insertion feature's primary key
     *
     * @var int
     */
    public static int $INSERTION = 49;
}