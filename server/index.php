<?php

use Korkz\Server\App\config\CorsHandler;
use Korkz\Server\App\router\Router;

require_once __DIR__ . "/vendor/autoload.php";
$crossHandler = new CorsHandler("allowedOrigins.json");
$crossHandler->handleCors();

$router = new Router();
$router->get('/index', function () {
    echo json_encode("Veriler burada");
});
$router->dispatch();




























//    /**
//     * @throws Exception
//     */
//    public function dispatch(): void
//    {
//        $method = $_SERVER['REQUEST_METHOD'];
//        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//        $path = str_replace('/sortable/server', '', $path);
//
//        foreach ($this->routes[$method] as $route => $callback) {
//            $params = [];
//            $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[a-z0-9-]+)', $route);
//            if (preg_match("#^$pattern$#", $path, $matches)) {
//                foreach ($matches as $key => $match) {
//                    if (is_string($key)) {
//                        $params[$key] = $match;
//                    }
//                }
//                if (is_callable($callback)) {
//                    $callback($params);
//                    return;
//                } else {
//                    throw new Exception("Invalid callback specified");
//                }
//            }
//        }
//
//        http_response_code(404);
//        echo "Aradığınız sayfa bulunamadı.";
//    }
//$db = new DbOperations();
//
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
//
//$data = [
//    'parent_id' => 0,
//    'category_name' => 'Test3',
//    'category_sort_by' => 2
//    ];
//$where = ['id' => 1];
//try {
//    if ($db->updateData('categories', $data, $where)) {
//        echo 'Kategori bilgileri başarıyla güncellendi.';
//    } else {
//        echo 'Kategori bilgileri güncellenirken bir hata oluştu.';
//    }
//} catch (Exception $e) {
//    throw new Exception($e->getMessage());
//}
//$json = file_get_contents('php://input');
//
//$data = json_decode($json);
//
//$sortOrder=[1,2,3,4];
//
//echo json_encode($sortOrder);