<?php

require_once __DIR__.'/../autoload.php';

use App\Core\DIContainer;
use App\Repositories\Logger\LoggerFile;
use App\Repositories\Logger\LoggerInterface;
use App\Repositories\Task\TaskRepositoryFile;
use App\Repositories\Task\TaskRepositoryInterface;

$container = new DIContainer();

// set task repository implemintation
$container->set(
    TaskRepositoryInterface::class,
    new TaskRepositoryFile(__DIR__.'/../tasks.json')
);

// set Logger implemintation
$container->set(
    LoggerInterface::class,
    new LoggerFile(__DIR__.'/../log.txt')
);

$app = function($controller, $method, array $vars = []) use ($container) {

    // check if controller exists
    if(!class_exists('App\\Controllers\\'.$controller.'Controller')) {
        throw new \Exception("Command '{$controller}' doesn't exist");
    }
    
    // check if method exists
    if(!method_exists('App\\Controllers\\'.$controller.'Controller', $method)) {
        throw new \Exception("Action '{$method}' doesn't exist");
    }

    // get controllers' instance
    $controllerInstance = $container->get('App\\Controllers\\'.$controller.'Controller');
    return call_user_func_array([$controllerInstance, $method], $vars);
};