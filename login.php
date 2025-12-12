<?php $config = require __DIR__ . '/../../config/config.php'; $base = rtrim($config['base_url'], '/'); ?>
<section class="auth-card">
  <h2>Login</h2>
  <?php if (!empty($error)): ?>
    <div class="alert error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="post" action="<?= $base ?>/login" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <label>Username or Email</label>
    <input type="text" name="identifier" required><br>
    <label>Password</label>
    <input type="password" name="password" required><br>
    <button class="btn primary" type="submit">Login</button><br>
  </form>
</section>
