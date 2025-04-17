<?php

namespace App\Core\Router;

use App\Core\Middleware\AuthMiddleware;
use App\Exceptions\FeatureExceptions;
use App\Exceptions\RouterExceptions;

/**
 * Class représenting a Route in the router
 * 
 * @author Arthur MATHIS <arthur.mathis@diaconat-mulhouse.fr>
 */
class Route {
    /**
     * Constructor class
     *
     * @param string $controller The controller of the functionnal
     * @param string $method The method of the functionnal
     * @param ?array $feature The list of feature's primary key
     * @param ?int $authentification The required role to access at the route
     * @throws RouterException If the feature's primary key is invalid
     * @throws AuthentificationExceptions If the role's primary key is invalid
     */
    public function __construct(
        protected string $controller, 
        protected string $method, 
        protected ?int $authentification = null, 
        protected ?array $feature = null
    ) {
        if(!empty($authentification)) {
            AuthMiddleware::isValidRole($authentification);
        }

        if(!empty($feature)) {
            foreach($feature as $obj) {
                if($obj <= 0) {
                    throw new FeatureExceptions("Génération de la route impossible, la fonctionnalité : {$feature} est invalide.");
                }
            }
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
     * Public method returning the list of feature's primary key
     *
     * @return ?array
     */
    public function getFeatures(): ?array { return $this->feature; }
    /**
     * Public method searching and returning a feature's primary key by its index in the list of features
     *
     * @param int $index Its index
     * @throws RouterException If the index is invalid
     * @return int Its primary key
     */
    public function getFeatureByIndex(int $index): int {
        if($index < 0) {
            throw new RouterExceptions("Impossible d'accéder à une feature d'indice négatif : {$index}.");
        }

        $size = count($this->getFeatures());
        if($size < $index) {
            throw new RouterExceptions("Impossible d'accèder à la feature d'indice : {$index}, l'indice maximum est : {$size}.");
        }

        return $this->getFeatures()[$index];
    }
}