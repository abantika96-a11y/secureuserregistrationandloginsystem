<?php
use app\controllers\HomeController;
use app\controllers\AuthController;

/** @var \app\core\Router $router */
$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'loginPost']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'registerPost']);
$router->get('/dashboard', [AuthController::class, 'dashboard']);
$router->post('/logout', [AuthController::class, 'logout']);
?>