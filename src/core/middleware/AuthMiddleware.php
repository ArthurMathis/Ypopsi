<?php

namespace App\Core\Middleware;

use App\Exceptions\AuthentificationExceptions;

/**
 * Class checking the user's access rights 
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class AuthMiddleware {
    // * ATTRIBUTES * //
    /**
     * Public static attribute containing the users' role in the application
     *
     * @var int
     */
    public static int $OWNER = 1, $ADMIN = 2, $MODERATOR = 3, $USER = 4, $INVITE = 5;

    // * REQUEST * //
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

        if(!isset($_SESSION["user"]) or empty($_SESSION["user"])) {
            throw new AuthentificationExceptions("Aucun utilisateur connecté.");
        }

        if(!self::roleIsMore($required_role)) {
            throw new AuthentificationExceptions("Les droits d'accès sont insuffisants.");
        }
    }

    // * UNTILS * //
    /**
     * Public static method checking if the user's role is enough
     *
     * @param integer $role
     * @return void
     */
    public static function isValidRole(int $role): void {
        $roles = array(
            AuthMiddleware::$OWNER, 
            AuthMiddleware::$ADMIN, 
            AuthMiddleware::$MODERATOR,
            AuthMiddleware::$USER, 
            AuthMiddleware::$INVITE
        );

        if(!in_array($role, $roles)) {
            throw new AuthentificationExceptions("Role invalide.");
        }
    }
    /**
     * Protected static ùethod checking if a role is more, eaqual or less than a required role
     *
     * @param int $required_role The required role
     * @return bool
     */
    protected static function roleIsMore(int $required_role): bool {
        if(empty($_SESSION["user"])) {
            throw new AuthentificationExceptions("Aucun utilisateur conecté.");
        }

        self::isValidRole($required_role);

        return $_SESSION["user"]->getRole() <= $required_role;
    }

    // * CHECK ROLE * // 
    /**
     * Public statuc method testing if the user's role is superior or equal to OWNER
     * 
     * @throws AuthentificationExceptions If no user is connected
     * @return bool
     */
    public static function isOwnerOrMore(): bool { return self::roleIsMore(self::$OWNER); }
    /**
     * Public statuc method testing if the user's role is superior or equal to ADMIN
     * 
     * @throws AuthentificationExceptions If no user is connected
     * @return bool
     */
    public static function isAdminOrMore(): bool { return self::roleIsMore(self::$ADMIN); }
    /**
     * Public statuc method testing if the user's role is superior or equal to MOD
     * 
     * @throws AuthentificationExceptions If no user is connected
     * @return bool
     */
    public static function isModeratorOrMore(): bool { return self::roleIsMore(self::$MODERATOR); }
    /**
     * Public statuc method testing if the user's role is superior or equal to USER
     * 
     * @throws AuthentificationExceptions If no user is connected
     * @return bool
     */
    public static function isUserOrMore(): bool { return self::roleIsMore(self::$USER); }
}