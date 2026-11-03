<?php
require __DIR__.'/../config/bootstrap.php'; require_admin();
if($_SERVER['REQUEST_METHOD']==='GET'){ $rows=$pdo->query('SELECT id,manju_tracking_no,customer_name,courier,actual_awb,destination,status,created_at FROM shipments ORDER BY id DESC')->fetchAll(); json_response(['ok'=>true,'shipments'=>$rows]); }
require_csrf();
$body=json_decode(file_get_contents('php://input'),true) ?: [];
$c=clean((string)($body['customer_name']??'')); $courier=clean((string)($body['courier']??'')); $awb=clean((string)($body['actual_awb']??'')); $dest=clean((string)($body['destination']??'')); $status=clean((string)($body['status']??'Booked'));
if($c===''||$awb===''||$dest===''||!valid_courier($courier)||!valid_status($status)) json_response(['ok'=>false,'message'=>'Please provide valid shipment details.'],422);
do{$code='MWX-'.date('Y').'-'.strtoupper(bin2hex(random_bytes(3))); $q=$pdo->prepare('SELECT id FROM shipments WHERE manju_tracking_no=?'); $q->execute([$code]);}while($q->fetch());
$stmt=$pdo->prepare('INSERT INTO shipments(manju_tracking_no,customer_name,courier,actual_awb,destination,status) VALUES(?,?,?,?,?,?)'); $stmt->execute([$code,$c,$courier,$awb,$dest,$status]);
json_response(['ok'=>true,'tracking_no'=>$code]);
