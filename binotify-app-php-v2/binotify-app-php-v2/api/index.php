<?php
require_once "../inc/bootstrap.php";
require_once PROJECT_ROOT_PATH . "/api/routes.php";
require_once PROJECT_ROOT_PATH . "/src/router/ApiRouter.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/auth/CheckUsernameController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/auth/CheckEmailController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/auth/LoginController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/auth/RegisterController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/song/SongController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/song/CreateSongController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/song/DetailSongController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/album/AlbumController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/album/CreateAlbumController.php";
require_once PROJECT_ROOT_PATH . "/src/controllers/album/DetailAlbumController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/upload/FileUploadController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/song/LimitSongController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/shared/CheckHealthController.php";

require_once PROJECT_ROOT_PATH . "/src/middlewares/CheckLogin.php";
require_once PROJECT_ROOT_PATH . "/src/middlewares/CheckAdmin.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/subscription/SubscriptionCallbackController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/subscription/SubscriptionController.php";

require_once PROJECT_ROOT_PATH . "/src/controllers/premium/PremiumSongController.php";

$routeHandler = new ApiRouter();

$routeHandler->addHandler("/api", CheckHealthController::getInstance(), []);

$routeHandler->addHandler("/api/auth/check-username", CheckUsernameController::getInstance(), []);

$routeHandler->addHandler("/api/auth/check-email", CheckEmailController::getInstance(), []);

$routeHandler->addHandler("/api/auth/login", LoginController::getInstance(), []);

$routeHandler->addHandler("/api/auth/register", RegisterController::getInstance(), []);

$routeHandler->addHandler("/api/song", SongController::getInstance(), []);

$routeHandler->addHandler("/api/song/create", CreateSongController::getInstance(), [CheckAdmin::getInstance()]);

$routeHandler->addHandler("/api/song/*", DetailSongController::getInstance(), []);

$routeHandler->addHandler("/api/album", AlbumController::getInstance(), []);

$routeHandler->addHandler("/api/album/create", CreateAlbumController::getInstance(), [CheckAdmin::getInstance()]);

$routeHandler->addHandler("/api/album/*", DetailAlbumController::getInstance(), []);

$routeHandler->addHandler("/api/upload", FileUploadController::getInstance(), []);

$routeHandler->addHandler("/api/limit", LimitSongController::getInstance(), []);

$routeHandler->addHandler("/api/subscription/callback", SubscriptionCallbackController::getInstance(), []);

$routeHandler->addHandler("/api/subscription", SubscriptionController::getInstance(), [CheckLogin::getInstance()]);

$routeHandler->addHandler("/api/premium/song", PremiumSongController::getInstance(), []);

$routeHandler->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
