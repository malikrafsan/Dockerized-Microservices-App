<?php
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

$authSrv = AuthSrv::getInstance();
$authSrv->logout();

header("Location: /login");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>you have logged out</h1>
</body>
</html>