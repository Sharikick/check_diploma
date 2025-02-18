<?php

namespace Core\Router;

use Core\Container\Container;

class Router implements RouterInterface
{
    private readonly Container $container;
    private array $routes;

    public function __construct()
    {
        $this->container = new Container();
        $this->initRoutes();
    }

    public function resolve(): void
    {
        $request = $this->container->getRequest();
        $method = $request->getMethod();
        $uri = $request->getUri();

        if (isset($this->routes[$method][$uri])) {
            [$controller, $handler] = $this->routes[$method][$uri];
            $controller = new $controller($this->container);

            call_user_func([$controller, $handler]);
            return;
        }

        $view = $this->container->getView();
        $view->render("not-found", ["title" => "Not Found"]);
    }

    private function initRoutes(): void
    {
        $config = $this->container->getConfig();
        $this->routes = $config->get("routes");
    }
}
