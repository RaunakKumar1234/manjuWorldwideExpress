<?php
require __DIR__.'/../config/bootstrap.php';
$n=strtoupper(clean($_GET['tracking'] ?? ''));
if($n==='') json_response(['ok'=>false,'message'=>'Enter a MANJU tracking number.'],400);
$stmt=$pdo->prepare('SELECT manju_tracking_no,courier,destination,status,created_at FROM shipments WHERE manju_tracking_no=? LIMIT 1');
$stmt->execute([$n]); $s=$stmt->fetch();
if(!$s) json_response(['ok'=>false,'message'=>'Shipment not found.'],404);
json_response(['ok'=>true,'shipment'=>$s]);
