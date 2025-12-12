<?php
return [
  'app_name' => 'Secure Auth',
  'base_url' => 'http://localhost/project_Abantika/project/public', // <-- fix
  'env' => 'development',
  'security' => [
    'session_name' => 'SECUREAUTHSESSID',
    'cookie_secure' => false,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict'
  ]
];
