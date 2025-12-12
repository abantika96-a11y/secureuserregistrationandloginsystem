<?php
namespace app\core;

class Controller {
  protected array $config;

  public function __construct(array $config) {
    $this->config = $config;
  }

  protected function redirect(string $path): void {
    $base = rtrim($this->config['base_url'], '/');
    header('Location: ' . $base . $path);
    exit;
  }
}
?>
