<?php
namespace app\core;

use PDO;

class Database {
  private static ?PDO $pdo = null;

  public static function init(array $config): void {
    if (self::$pdo === null) {
      self::$pdo = new PDO(
        $config['dsn'],
        $config['user'],
        $config['password'],
        $config['options'] ?? []
      );
    }
  }

  public static function pdo(): PDO {
    if (!self::$pdo) {
      throw new \RuntimeException('Database not initialized');
    }
    return self::$pdo;
  }
}
?>