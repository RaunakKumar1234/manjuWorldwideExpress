<?php
require __DIR__.'/../config/bootstrap.php'; require_admin(); require_csrf();
header('Content-Type: text/csv; charset=utf-8'); header('Content-Disposition: attachment; filename="MANJU_Shipments.csv"');
$out=fopen('php://output','w'); fputcsv($out,['manju_tracking_no','customer_name','courier','actual_awb','destination','status','created_at']);
foreach($pdo->query('SELECT manju_tracking_no,customer_name,courier,actual_awb,destination,status,created_at FROM shipments ORDER BY id DESC') as $r) fputcsv($out,$r); fclose($out); exit;
