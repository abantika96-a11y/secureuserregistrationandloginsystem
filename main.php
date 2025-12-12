<?php
$config = require __DIR__ . '/../../config/config.php';
$base = rtrim($config['base_url'], '/');
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? $config['app_name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
</head>
<body>
  <header class="site-header">
    <nav class="nav">
      <a href="<?= $base ?>/" class="brand"><?= htmlspecialchars($config['app_name']) ?></a>
      <div class="links">
        <a href="<?= $base ?>/">Home</a>
        <a href="<?= $base ?>/login">Login</a>
        <a href="<?= $base ?>/register">Register</a>
      </div>
    </nav>
  </header>
  <main class="container">
    <?= $content ?>
  </main>
  <footer class="site-footer">
    <p>&copy; <?= date('Y') ?> Secure Auth</p>
  </footer>
  <script src="<?= $base ?>/assets/js/app.js" defer></script>
</body>
</html>
