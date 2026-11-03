<?php require __DIR__.'/../config/bootstrap.php'; json_response(['ok'=>true,'csrf'=>csrf_token(),'logged_in'=>!empty($_SESSION['admin_id'])]);
