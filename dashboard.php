<?php $config = require __DIR__ . '/../../config/config.php'; $base = rtrim($config['base_url'], '/'); ?>
<section class="dash">
  <h2>Welcome to your dashboard</h2>
  <p>You are logged in. This area can show your profile, sessions, and security settings.</p>
  <form method="post" action="<?= $base ?>/logout">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(\app\core\Csrf::token()) ?>">
    <button class="btn" type="submit">Logout</button>
  </form>
</section>
