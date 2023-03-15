<?php

require_once "inc/bootstrap.php";
require_once PROJECT_ROOT_PATH . "/src/router/PageRouter.php";
require_once PROJECT_ROOT_PATH . "/routes.php";

$router = new PageRouter($routes);
$router->setErrorRoute(PROJECT_ROOT_PATH . "/public/view/404.php");
$router->routing($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
