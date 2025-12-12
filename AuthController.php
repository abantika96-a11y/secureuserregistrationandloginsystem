<?php
namespace app\controllers;

use app\core\Controller;
use app\core\View;
use app\core\Session;
use app\core\Csrf;
use app\models\User;

class AuthController extends Controller {
  private function throttleKey(): string {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    return 'login_attempts_' . $ip;
  }

  public function login(): void {
    View::render('auth/login', [
      'title' => 'Login',
      'csrf'  => Csrf::token()
    ]);
  }

  public function loginPost(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::validate($token)) {
      http_response_code(400);
      echo 'Invalid CSRF token';
      return;
    }

    $attempts = (int)Session::get($this->throttleKey(), 0);
    if ($attempts > 10) {
      http_response_code(429);
      echo 'Too many attempts. Try again later.';
      return;
    }

    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = (new User())->verify($identifier, $password);
    if (!$user) {
      Session::set($this->throttleKey(), $attempts + 1);
      View::render('auth/login', [
        'title' => 'Login',
        'error' => 'Invalid credentials.',
        'csrf' => Csrf::token()
      ]);
      return;
    }

    Session::set('user_id', $user['id']);
    Session::unset($this->throttleKey());
    $this->redirect('/dashboard');
  }

  public function register(): void {
    View::render('auth/register', [
      'title' => 'Register',
      'csrf'  => Csrf::token()
    ]);
  }

  public function registerPost(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::validate($token)) {
      http_response_code(400);
      echo 'Invalid CSRF token';
      return;
    }

    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $errors = [];
    if (!$email) $errors[] = 'Valid email required.';
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) $errors[] = 'Username must be 3-20 chars, alnum/underscore.';
    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    $model = new User();
    if ($email && $model->findByEmail($email)) $errors[] = 'Email already in use.';
    if ($username && $model->findByUsername($username)) $errors[] = 'Username already in use.';

    if ($errors) {
      View::render('auth/register', [
        'title' => 'Register',
        'errors' => $errors,
        'csrf' => Csrf::token()
      ]);
      return;
    }

    $id = $model->create($email, $username, $password);
    Session::set('user_id', $id);
    $this->redirect('/dashboard');
  }

  public function dashboard(): void {
    $uid = Session::get('user_id');
    if (!$uid) {
      $this->redirect('/login');
      return;
    }
    View::render('auth/dashboard', [
      'title' => 'Dashboard'
    ]);
  }

  public function logout(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::validate($token)) {
      http_response_code(400);
      echo 'Invalid CSRF token';
      return;
    }
    Session::unset('user_id');
    $this->redirect('/');
  }
}
?>