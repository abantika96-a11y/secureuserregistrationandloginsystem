<?php
namespace app\core;

class Csrf {
  public static function token(): string {
    if (!Session::get('csrf_token')) {
      Session::set('csrf_token', bin2hex(random_bytes(32)));
    }
    return Session::get('csrf_token');
  }

  public static function validate(string $token): bool {
    $valid = hash_equals(Session::get('csrf_token', ''), $token);
    if ($valid) {
      // Optional: Rotate token after successful validation
      Session::set('csrf_token', bin2hex(random_bytes(32)));
    }
    return $valid;
  }
}
?>