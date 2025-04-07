<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . lcfirst(str_replace('\\', '/', $class)) . '.php';

    if (file_exists($path)) {
        require $path;
    }
});

header('Content-Type: application/json');

use App\Router;

$router = new Router();
$router->post('/users/create', [App\User::class, 'create_user']);
$router->post('/users/update', [App\User::class, 'update_user']);
$router->get('/users/read', [App\User::class, 'read_user']);
$router->delete('/users/delete', [App\User::class, 'delete_user']);

try {
    $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
} catch (\App\Exceptions\RouteNotFoundException $e) {
    http_response_code($e->getCode());
    echo json_encode(['message' => $e->getMessage()]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
