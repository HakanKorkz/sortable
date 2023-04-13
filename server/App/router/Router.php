<?php

namespace Korkz\Server\App\router;
class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = array();
    }

    public function custom(string $method, string $path, $callback): void
    {
        $this->routes[$method][$path] = $callback;
    }

    public function get(string $path, $callback): void
    {
        $this->routes["GET"][$path] = $callback;
    }
    public function post(string $path, $callback): void
    {
        $this->routes["POST"][$path] = $callback;
    }


    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
       $path = str_replace('/sortable/server', '', $path);

        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/{([^\/]+)}/', '([^/]+)', $route);
            $pattern = "@^" . $pattern . "$@i";
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                $callback(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo "Aradığınız sayfa bulunamadı.";
    }
}

