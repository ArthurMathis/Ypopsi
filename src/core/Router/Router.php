<?php

namespace App\Core\Router;

use App\Core\Router\Route;
use App\Exceptions\RouterExceptions;
use App\Core\Middleware\AuthMiddleware;
use App\Core\Middleware\FeatureMiddleware;

/**
 * Class managing the url request in the application
 * @author Arthur MATHIS - arthur.mathis@uha.fr
 */
class Router {
    /**
     * Private attribute containing the routes
     * 
     * @var Array
     */
    protected array $routes = array();
    /**
     * Protected attribute containing the path of the application
     * 
     * @var String
     */
    protected string $app_path;


    // * CONSTRUCTOR * //
    /**
     * Class' constructor
     */
    public function __construct() { $this->app_path = APP_PATH; }


    // * ROUTES * //
    /**
     * Public method adding a controller and method to an url
     * 
     * @param String $urlPattern The url of the request
     * @param String $controllerMethod The controller to handle the request
     * @param String $methodController The method to handle the request
     * @param ?array $features The list of feature's primary key
     * @param ?int $authentification The required role to access at the functionnal
     * @throws RouterExceptions If the route is already defined 
     * @return Void
     */
    public function addRoute(string $urlPattern, string $controllerClass, string $methodController, ?array $features = null, ?int $authentification = null) { 
        if(isset($this->routes[$urlPattern])) {
            throw new RouterExceptions("Erreur de routage, la route : " . $urlPattern . " est déjà attribuée à " 
                . $this->routes[$urlPattern]->getController() . '::' . $this->routes[$urlPattern]->getMethod() . " !");
        }

        $this->routes[$urlPattern] = new Route(
            $controllerClass,
            $methodController,
            $authentification, 
            $features
        );
    }
    /**
     * Public method launching the process to answer to the request
     * 
     * @param bool $user_connected A boolean indacting is the user is connected or not
     * @throws RouterExceptions If the controller or the method are not declared
     * @return Void
     */
    public function dispatch(bool $user_connected) {
        $path = $_SERVER['REQUEST_URI'] ?? '/';                                     // Récupération de l'url 
        $path = str_replace($this->app_path, '', $path);                            // Suppression de l'adresse de base
        $path = strtok($path, '?');                                                 // Suppression des paramètres GET
        $path = '/' . ltrim($path, '/');                                            // Suppression des / en début de chaine
        $path = rtrim($path, '/');                                                  // Suppression des / en début de chaine

        if ($path === '') {
            $path = '/';
        }

        if(!$user_connected && strpos($path, "/login") !== 0) {
            header("location: " . APP_PATH . "/login/get");
        }

        foreach($this->routes as $route => $target) {
            $routePattern = preg_replace("/\{[^\}]+\}/", "([^/]+)", $route);

            if (preg_match('#^' . $routePattern . '$#', $path, $matches)) {         // Test de la correspondance
                array_shift($matches);

                if(class_exists($target->getController())) {                        // Instanciation du controller
                    $c = new ($target->getController())();

                    if($target->getFeatures()) {
                        FeatureMiddleware::handle($target->getFeatures());
                    }

                    if($target->getAuthentification()) {
                        AuthMiddleware::handle($target->getAuthentification());
                    }
                
                    if(method_exists($c, $target->getMethod())) {                   // Appel de la méthode
                        return $c->{$target->getMethod()}(...$matches);
                    } else {
                        throw new RouterExceptions("Méthode introuvable.");
                    } 
                } else {
                    throw new RouterExceptions("Controller introuvable.");
                }
            }
        }

        throw new RouterExceptions("Erreur 404 - url introuvable");
    }
}