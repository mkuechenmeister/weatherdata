
<?php
    require_once 'controllers/Controller.php';

// entry point for the application
// e.g. http://localhost/php41/index.php?r=credentials/view&id=25
// select route: credentials/view&id=25 -> controller=credentials, action=view, id=25
$route = isset($_GET['r']) ? explode('/', trim($_GET['r'], '/')) : ['measurement'];
$controller = sizeof($route) > 0 ? $route[0] : 'measurement';

if ($controller == 'measurement') {
require_once('controllers/WeatherdataController.php');
(new WeatherdataController())->handleRequest($route);
} else {
Controller::showError("Page not found", "Page for operation " . $controller . " was not found!");
}
