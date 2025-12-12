<?php
namespace app\controllers;

use app\core\Controller;
use app\core\View;

class HomeController extends Controller {
  public function index(): void {
    View::render('home/index', [
      'title' => 'Secure User Registration and Login System'
    ]);
  }
}
?>
