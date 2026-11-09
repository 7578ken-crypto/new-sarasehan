<?php
// Header CORS & RESTful API Handler
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$url = $_GET['url'] ?? 'home';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . 'Controller';

if (file_exists(__DIR__ . '/controllers/' . $controllerName . '.php')) {
    require_once __DIR__ . '/controllers/' . $controllerName . '.php';
    $controller = new $controllerName();
    
    $action = $url[1] ?? 'index';
    $id = $url[2] ?? null;

    if (method_exists($controller, $action)) {
        if ($id !== null) {
            $controller->$action($id);
        } else {
            $controller->$action();
        }
    } else {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Action/Method Tidak Ditemukan']);
    }
} else {
    require_once __DIR__ . '/controllers/HomeController.php';
    $home = new HomeController();
    $home->index();
}
?>