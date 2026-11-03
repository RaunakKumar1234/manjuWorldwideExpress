<?php
require __DIR__.'/../config/bootstrap.php';
// Run once, then DELETE this file from the server.
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $u=clean($_POST['username']??'');$p=$_POST['password']??'';
 if(strlen($u)<3||strlen($p)<10)$msg='Username must be 3+ chars and password 10+ chars.';
 else{$hash=password_hash($p,PASSWORD_DEFAULT);$st=$pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?) ON DUPLICATE KEY UPDATE password_hash=VALUES(password_hash)');$st->execute([$u,$hash]);$msg='Admin created/updated. DELETE setup_admin.php now.';}
}
?><!doctype html><html><head><meta charset="utf-8"><title>MANJU Admin Setup</title><style>body{font-family:Arial;background:#f4f8fc;padding:40px}.box{max-width:420px;background:white;padding:25px;border-radius:14px;margin:auto}input{width:100%;padding:12px;margin:8px 0 15px;box-sizing:border-box}button{padding:12px 18px;background:#0b3158;color:white;border:0;border-radius:8px;font-weight:bold}</style></head><body><div class="box"><h2>MANJU Admin Setup</h2><p><?=htmlspecialchars($msg)?></p><form method="post"><label>Username</label><input name="username" required><label>Password</label><input name="password" type="password" required><button>Create Admin</button></form></div></body></html>
