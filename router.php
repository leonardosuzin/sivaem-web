<?php
$routes = require 'routes.php';
$url = $_SERVER['REQUEST_URI'];

if (array_key_exists($url, $routes)) {
    require $routes[$url];
} else {
    // Rota não encontrada, redirecionar para uma página de erro ou fazer algo apropriado
    echo "404 - Rota não encontrada";
}
?>