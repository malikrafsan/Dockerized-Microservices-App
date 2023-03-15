<?php
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

if (!AuthSrv::getInstance()->isAdmin()) {
  header("Location: /");
  exit();
}

$userSrv = UserSrv::getInstance();
$users = $userSrv->getAllUser();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/userlist.css">
  <title>User List Panel - SoundClown</title>
</head>

<body>
  <div class="page d-flex">
    <?php
    echo Sidebar();
    ?>
    <div id="main">
      <div class="wrapper-sidebar-control">
        <?php echo SidebarControl(); ?>
      </div>
      <div id="content">
        <h1>User List</h1>
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Username</th>
              <th>Name</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($users as $user) {
              echo "<tr>";
              echo "<td>" . $user->get('user_id') . "</td>";
              echo "<td>" . $user->get('username') . "</td>";
              echo "<td>" . $user->get('nama') . "</td>";
              echo "<td>" . $user->get('email') . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script defer async src="/public/js/shared.js"></script>
</body>

</html>