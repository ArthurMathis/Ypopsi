<?php

namespace App\Core\Router;

use App\Core\Middleware\AuthMiddleware;

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
     * @param ?int $middleware The required role to access at the route
     * @throws AuthentificationExceptions If the role is invalid
     */
    public function __construct(
        protected string $controller, 
        protected string $method, 
        protected ?int $middleware = null
    ) {
        if(!empty($middleware)) {
            AuthMiddleware::isValidRole($middleware);
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
     * @return string
     */
    public function getMiddleware(): ?int { return $this->middleware; }
}