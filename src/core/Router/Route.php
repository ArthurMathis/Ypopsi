<?php

namespace App\Core\Router;

use App\Core\Middleware\AuthMiddleware;
use App\Exceptions\FeatureExceptions;
use App\Exceptions\RouterExceptions;

/**
 * Class représenting a Route in the router
 * @author Arthur MATHIS - arthur.mathis@diaconat-mulhouse.fr
 */
class Route {
    /**
     * Constructor class
     *
     * @param string $controller The controller of the functionnal
     * @param string $method The method of the functionnal
     * @param ?int $authentification The required role to access at the route
     * @throws AuthentificationExceptions If the role is invalid
     */
    public function __construct(
        protected string $controller, 
        protected string $method, 
        protected ?int $authentification = null, 
        protected ?int $feature = null
    ) {
        if(!empty($authentification)) {
            AuthMiddleware::isValidRole($authentification);
        }

        if(!empty($feature) && $feature <= 0) {
            throw new RouterExceptions("Génération de la route impossible, la fonctionnalité : {$feature} est invalide.");
        }
    }

    // * GET * //
    /**
     * Public method returning the controller
     *
     * @return string
     */
    public function getController(): string { return $this->controller; }
    /**
     * Public method returning the method
     *
     * @return string
     */
    public function getMethod(): string { return $this->method; }
    /**
     * Public method returning the required role
     *
     * @return ?int
     */
    public function getAuthentification(): ?int { return $this->authentification; }
    /**
     * Public method returning the feature's primary key
     *
     * @return ?int
     */
    public function getFeature(): ?int { return $this->feature; }
}