<?php
require __DIR__.'/../config/bootstrap.php'; require_admin(); require_csrf();
$body=json_decode(file_get_contents('php://input'),true) ?: []; $rows=$body['rows']??[];
if(!is_array($rows)||count($rows)>5000) json_response(['ok'=>false,'message'=>'Invalid import.'],422);
$pdo->beginTransaction(); $count=0;
try{
 foreach($rows as $r){$n=clean((string)($r['manju_tracking_no']??''));$c=clean((string)($r['customer_name']??''));$co=clean((string)($r['courier']??''));$a=clean((string)($r['actual_awb']??''));$d=clean((string)($r['destination']??''));$s=clean((string)($r['status']??'Booked'));
  if($n===''||$a===''||$c===''||$d===''||!valid_courier($co)||!valid_status($s)) continue;
  $st=$pdo->prepare('INSERT INTO shipments(manju_tracking_no,customer_name,courier,actual_awb,destination,status) VALUES(?,?,?,?,?,?) ON DUPLICATE KEY UPDATE customer_name=VALUES(customer_name),courier=VALUES(courier),actual_awb=VALUES(actual_awb),destination=VALUES(destination),status=VALUES(status)');$st->execute([$n,$c,$co,$a,$d,$s]);$count++;
 }
 $pdo->commit(); json_response(['ok'=>true,'count'=>$count]);
}catch(Throwable $e){$pdo->rollBack();json_response(['ok'=>false,'message'=>'Import failed.'],500);}
