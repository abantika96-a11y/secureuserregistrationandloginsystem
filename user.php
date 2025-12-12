<?php
namespace app\models;

use app\core\Model;
use PDO;

class User extends Model {
  public function findByEmail(string $email): ?array {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public function findByUsername(string $username): ?array {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public function create(string $email, string $username, string $password): int {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->db->prepare('INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$email, $username, $hash]);
    return (int)$this->db->lastInsertId();
  }

  public function verify(string $emailOrUser, string $password): ?array {
    $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1');
    $stmt->execute([$emailOrUser, $emailOrUser]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
      return $user;
    }
    return null;
  }
}
?>