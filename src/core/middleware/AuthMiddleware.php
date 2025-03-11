<?php

namespace App\Core\Middleware;

use App\Exceptions\AuthentificationExceptions;

/**
 * Class checking the user's access rights 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class AuthMiddlware {
    /**
     * Public static attribute contaiing the roles 
     *
     * @var array
     */
    public static array $ROLE = array(OWNER, ADMIN, MOD, USER, INVITE);

    public static function isValidRole(int $role): void {
        if(!in_array($role, AuthMiddlware::$ROLE)) {
            throw new AuthentificationExceptions("Role invalide.");
        }
    }

    /**
     * Public static method handle a url request and checking if the user's access rights are enough
     *
     * @param ?int $required_role The required role for the action
     * @return void
     */
    public static function handle(?int $required_role = null): void {
        if(is_null($required_role)) { 
            return ;
        }

        if(!isset($_SESSION["user"]) or empty($_SESSIOn["user"])) {
            throw new AuthentificationExceptions("Aucun utilisateur conecté.");
        }

        if($_SESSION["user"]->getRole() < $required_role) {
            throw new AuthentificationExceptions("Les droits d'accès sont insuffisants.");
        }
    }
}