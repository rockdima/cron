<?php

/**
 * Entry point from the web
 */


$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$controller = $path[0];
$method = $path[1];

// comnnand format example: +15;Hello World
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vars = explode(';', $_POST['command']??'');
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $vars = array_slice($path, 2);
}


// run the app
require_once __DIR__ . '/app/app.php';
$app($controller, $method, $vars);