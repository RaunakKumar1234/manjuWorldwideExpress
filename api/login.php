<?php
require __DIR__.'/../config/bootstrap.php';
require_csrf();
$body=json_decode(file_get_contents('php://input'),true) ?: [];
$user=clean((string)($body['username']??'')); $pass=(string)($body['password']??'');
$stmt=$pdo->prepare('SELECT id,password_hash FROM admins WHERE username=? LIMIT 1'); $stmt->execute([$user]); $a=$stmt->fetch();
if(!$a || !password_verify($pass,$a['password_hash'])) json_response(['ok'=>false,'message'=>'Invalid username or password.'],401);
session_regenerate_id(true); $_SESSION['admin_id']=(int)$a['id']; $_SESSION['admin_user']=$user; $_SESSION['csrf']=bin2hex(random_bytes(32));
json_response(['ok'=>true,'csrf'=>$_SESSION['csrf']]);
