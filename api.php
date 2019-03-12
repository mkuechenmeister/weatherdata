<?php

// entry point for the rest api
// e.g. GET http://localhost/php41/api.php?r=credentials/25
// or with url_rewrite GET http://localhost/php41/api/credentials/25
// select route: credentials/25 -> controller=credentials, action=GET, id=25
$route = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : ['measurement'];
$controller = sizeof($route) > 0 ? $route[0] : 'measurement';

if ($controller == 'measurement') {
    require_once('controllers/WeatherdataRESTController.php');
    (new WeatherdataRestController())->handleRequest();
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode("REST-Controller not found");
}