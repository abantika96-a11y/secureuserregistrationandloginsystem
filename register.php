<?php $config = require __DIR__ . '/../../config/config.php'; $base = rtrim($config['base_url'], '/'); ?>
<section class="auth-card">
  <h2>Create account</h2>
  <?php if (!empty($errors)): ?>
    <div class="alert error">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
  <form method="post" action="<?= $base ?>/register" autocomplete="off">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
    <label>Email</label>
    <input type="email" name="email" required><br><br>
    <label>Username</label>
    <input type="text" name="username" required><br><br>
    <label>Password</label>
    <input type="password" name="password" required><br><br>
    <label>Confirm password</label>
    <input type="password" name="confirm_password" required><br><br>
    <button class="btn primary" type="submit">Register</button><br><br>
  </form>
</section>
