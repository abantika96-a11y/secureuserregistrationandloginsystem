<?php
// Autoloader
spl_autoload_register(function ($class) {
  $prefix = 'app\\';
  $base_dir = __DIR__ . '/../app/';
  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) return;
  $relative_class = substr($class, $len);
  $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
  if (file_exists($file)) require $file;
});

// Load configs
$config = require __DIR__ . '/../app/config/config.php';
$dbConf = require __DIR__ . '/../app/config/database.php';

use app\core\Database;
use app\core\Router;
use app\core\Session;

Database::init($dbConf);
Session::start($config);

// Register routes
$router = new Router();
require __DIR__ . '/../app/config/routes.php';

// Dispatch
$router->dispatch('app\\controllers', $config);
?>