<?php require __DIR__.'/../config/bootstrap.php'; require_admin(); require_csrf(); $_SESSION=[]; session_destroy(); json_response(['ok'=>true]);
