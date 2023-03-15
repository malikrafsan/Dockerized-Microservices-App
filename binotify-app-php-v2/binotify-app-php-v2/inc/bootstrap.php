<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/..");
error_reporting((E_ALL ^ E_WARNING) ^ E_DEPRECATED);

session_start();

require_once PROJECT_ROOT_PATH . "/src/utils/EnvLoader.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Logger.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Debugger.php";

$dotenv = new EnvLoader(PROJECT_ROOT_PATH . "/.env");
$dotenv->load();
