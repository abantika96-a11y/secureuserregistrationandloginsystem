<?php
namespace app\core;

class Session {
  public static function start(array $cfg): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_name($cfg['security']['session_name'] ?? 'SESSID');
      session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $cfg['security']['cookie_secure'] ?? false,
        'httponly' => $cfg['security']['cookie_httponly'] ?? true,
        'samesite' => $cfg['security']['cookie_samesite'] ?? 'Strict'
      ]);
      session_start();
      if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
      }
    }
  }

  public static function get(string $key, $default = null) {
    return $_SESSION[$key] ?? $default;
  }

  public static function set(string $key, $value): void {
    $_SESSION[$key] = $value;
  }

  public static function unset(string $key): void {
    unset($_SESSION[$key]);
  }

  public static function destroy(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time()-42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
  }
}
?>
