<?php

require_once 'config/routes.php';
require_once 'lib/Utils.php';

// Get the current URL
$url = $_SERVER['REQUEST_URI'];

//get this file name and path and remove it from the url
$script_name = $_SERVER['SCRIPT_NAME'];
$url = str_replace($script_name, '', $url);
// Remove query string from the URL
$url = strtok($url, '?');



try {
    // Check if the route exists
    if (array_key_exists($url, $routes)) {
        // Get the corresponding controller and method
        $controller = $routes[$url] . 'Controller';
        $method = 'index';

        // Include the controller file
        require_once 'lib/Controller.php';
        require_once 'controllers/' . $controller . '.php';

        //keep only the last part of tge controller (after /)
        $controller = explode('/', $controller);
        $controller = end($controller);

        // Create an instance of the controller
        $instance = new $controller();
        $instance->execute();
    } else {
        // Route not found, show a 404 error
        header("HTTP/1.0 404 Not Found");
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Route not found']);
    }
} catch (Exception $e) {
    header("HTTP/1.0 500 Internal Server Error");
    header('Content-Type: application/json');
    Utils\debugLog("Error in index.php at " . date('Y-m-d H:i:s') . " :" . $e->getMessage());
    echo json_encode(['message' => $e->getMessage()]);
}
