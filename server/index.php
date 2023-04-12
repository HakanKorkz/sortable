<?php
use Korkz\Server\App\config\CorsHandler;
use Korkz\Server\App\Connect\DbOperations;

require_once __DIR__."/vendor/autoload.php";

$crossHandler= new CorsHandler("allowedOrigins.json");

$crossHandler->handleCors();

$db = new DbOperations();

//$data = [
//    'parent_id' => 0,
//    'category_name' => 'Test2',
//    'category_sort_by' => 2
//    ];
//
//if ($db->insertData('categories', $data)) {
//    echo 'Kategori başarıyla eklendi.';
//} else {
//    echo 'Kategori eklenirken bir hata oluştu.';
//}

$data = [
    'parent_id' => 0,
    'category_name' => 'Test3',
    'category_sort_by' => 2
    ];
$where = ['id' => 1];
try {
    if ($db->updateData('categories', $data, $where)) {
        echo 'Kategori bilgileri başarıyla güncellendi.';
    } else {
        echo 'Kategori bilgileri güncellenirken bir hata oluştu.';
    }
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}
$json = file_get_contents('php://input');

$data = json_decode($json);

$sortOrder=[1,2,3,4];

echo json_encode($sortOrder);