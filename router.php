<?php
namespace app\core;

class Router {
  private array $routes = [];

  public function get(string $path, callable|array $handler): void {
    $this->routes['GET'][$path] = $handler;
  }

  public function post(string $path, callable|array $handler): void {
    $this->routes['POST'][$path] = $handler;
  }

  public function dispatch(string $baseNamespace, array $config): void {
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $base = rtrim(parse_url($config['base_url'], PHP_URL_PATH), '/');
    $uri = '/' . ltrim(substr($path, strlen($base)), '/');

    $handler = $this->routes[$method][$uri] ?? null;
    if (!$handler) {
      http_response_code(404);
      echo 'Not Found';
      return;
    }
    if (is_array($handler)) {
      [$class, $action] = $handler;
      $ctr = new $class($config);
      $ctr->$action();
    } else {
      $handler();
    }
  }
}
?>
