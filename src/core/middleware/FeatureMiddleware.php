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

            if(!$feature->getEnable()) {
                throw new FeatureExceptions("La fonctionnalité <b>" . $feature->getTitled() . " a été temporairement désactivée</b>. Veuillez réessayer ultérieurement. <br>Si l'incident persiste, <b>contactez le support informatique</b>.");
            }
        }
    }

    // * ATTRIBUTE * //
    public static int $CONNEXION = 1;
    public static int $INSCRIPT_CANDIDATE = 2, $INSCRIPT_CONTRACT = 3, $INSCRIPT_OFFER = 4, $INSCRIPT_APPLICATIPON = 5, $INSCRIPT_MEETING = 6, $INSCRIPT_DOCUMENT = 7;
    public static int $EDIT_CANDIDATE = 8, $EDIT_RATING = 9, $EDIT_CONTRACT = 10, $EDIT_OFFER = 11, $EDIT_APPLICATIPON = 12, $EDIT_MEETING = 13, $EDIT_DOCUMENT = 14;
    public static int $DELETE_CANDIDATE = 15, $DELETE_MEETING = 16, $DELETE_DOCUMENT = 17;
    public static int $MANAGE_CONTRACT = 18, $MANAGE_OFFER = 19, $MANAGE_APPLICATIPON = 20;
}