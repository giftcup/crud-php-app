<?php

declare(strict_types=1);

spl_autoload_register(function($class) {
    $path = __DIR__ . '/../' . lcfirst(str_replace('\\', '/', $class)) . '.php';

    if (file_exists($path)) {
        require $path;
    }
});

use App\User;
use App\Router;

$router = new Router();
$router->post('/create', [App\User::class, 'create_user']);
$router->post('/update', [App\User::class, 'update_user']);
$router->get('/read', [App\User::class, 'read_user']);
$router->delete('/delete', [App\User::class, 'delete_user']);


$router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));