<?php
$allowedOrigins = ['http://localhost:5173'];
if (in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
}

require_once __DIR__."/vendor/autoload.php";

$json = file_get_contents('php://input');

$data = json_decode($json);

$sortOrder=[1,2,3,4];

echo json_encode($sortOrder);