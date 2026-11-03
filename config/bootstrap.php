<?php
declare(strict_types=1);
session_start();
$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) { http_response_code(500); exit('Server configuration missing. Copy config/config.example.php to config/config.php.'); }
$config = require $configPath;
try {
  $pdo = new PDO(
    'mysql:host='.$config['db_host'].';dbname='.$config['db_name'].';charset=utf8mb4',
    $config['db_user'], $config['db_pass'],
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]
  );
} catch (Throwable $e) { http_response_code(500); exit('Database connection failed.'); }
function json_response(array $data, int $status=200): never { http_response_code($status); header('Content-Type: application/json; charset=utf-8'); echo json_encode($data); exit; }
function require_admin(): void { if (empty($_SESSION['admin_id'])) json_response(['ok'=>false,'message'=>'Unauthorized'],401); }
function csrf_token(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function require_csrf(): void { $token=$_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''; if(!hash_equals($_SESSION['csrf'] ?? '',$token)) json_response(['ok'=>false,'message'=>'Invalid request'],419); }
function clean(string $s): string { return trim($s); }
function valid_courier(string $c): bool { return in_array($c,['DHL','FedEx','DTDC','Aramex','UPS','Blue Dart'],true); }
function valid_status(string $s): bool { return in_array($s,['Booked','Picked Up','In Transit','Out for Delivery','Delivered'],true); }
