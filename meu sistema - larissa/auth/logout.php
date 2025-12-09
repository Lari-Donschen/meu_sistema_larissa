<?php
require_once __DIR__ . '/functions.php';

fazer_logout();
header('Location: /auth/login.php');
exit;