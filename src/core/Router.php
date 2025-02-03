<?php

namespace App\Core;

use App\Exceptions\RouterExceptions;

/**
 * Class representing the Router 
 * @author Arthur MATHIS - arthur.mathis@uha.fr
 */
class Router {
    /**
     * Private attribute containing the array of routes request
     * 
     * @var Array
     */
    protected array $routes = [];
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
    public function __construct() { $this->app_path = getenv('APP_PATH') ?? '/Ypopsi'; }


    // * ROUTES * //
    /**
     * Public method adding a controller and method to an url
     * 
     * @param String $urlPattern The url of the request
     * @param String $controllerMethod The controller to handle the request
     * @param String $methodController The method to handle the request
     * @throws RouterExceptions If the route is already defined 
     * @return Void
     */
    public function addRoute(string $urlPattern, string $controllerClass, string $methodController) { 
        if(isset($this->routes[$urlPattern])) 
            throw new RouterExceptions("Erreur de routage, la route : " . $urlPattern . " est déjà attribuée à " . $this->routes[$urlPattern]['controller'] . '::' . $this->routes[$urlPattern]['method'] . " !");
        else 
            $this->routes[$urlPattern] = ['controller' => $controllerClass, 'method' => $methodController];
    }
    /**
     * Public method launching the process to answer to the request
     * 
     * @throws RouterExceptions If the controller or the method are not declared
     * @return Void
     */
    public function dispatch() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';                                     // Récupération de l'url 
        $path = str_replace($this->app_path, '', $path);                            // Suppression de l'adresse de base
        $path = strtok($path, '?');                                                 // Suppression des paramètres GET
        $path = '/' . ltrim($path, '/');                                            // Suppression des / en début de chaine
        $path = rtrim($path, '/');                                                  // Suppression des / en début de chaine
        
        if ($path === '') {
            $path = '/';
        }

        foreach($this->routes as $route => $target) {
            $routePattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);

            if (preg_match('#^' . $routePattern . '$#', $path, $matches)) {         // Test de la correspondance
                array_shift($matches);

                if(class_exists($target['controller'])) {                           // Instanciation du controller
                    $c = new $target['controller']();
                
                    if(method_exists($c, $target['method']))                        // Appel de la méthode
                        return $c->{$target['method']}(...$matches);
                    else 
                        throw new RouterExceptions("Méthode introuvable.");
                } else {
                    throw new RouterExceptions("Controller introuvable.");
                }
            }
        }
        
        throw new RouterExceptions("Erreur 404 - url introuvable");
    }
} 