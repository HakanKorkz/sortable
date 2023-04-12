<?php
use Korkz\Server\App\config\CorsHandler;

require_once __DIR__."/vendor/autoload.php";

$crossHandler= new CorsHandler("allowedOrigins.json");

$crossHandler->handleCors();

$json = file_get_contents('php://input');

$data = json_decode($json);

$sortOrder=[1,2,3,4];

echo json_encode($sortOrder);