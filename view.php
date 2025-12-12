<?php
namespace app\core;

class View {
  public static function render(string $viewPath, array $params = [], string $layout = 'layouts/main'): void {
    extract($params, EXTR_SKIP);
    $viewFile = __DIR__ . '/../views/' . $viewPath . '.php';
    $layoutFile = __DIR__ . '/../views/' . $layout . '.php';

    ob_start();
    if (file_exists($viewFile)) require $viewFile;
    $content = ob_get_clean();

    require $layoutFile;
  }

  public static function partial(string $viewPath, array $params = []): void {
    extract($params, EXTR_SKIP);
    $viewFile = __DIR__ . '/../views/' . $viewPath . '.php';
    require $viewFile;
  }
}
?>
