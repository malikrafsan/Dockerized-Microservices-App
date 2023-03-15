<?php
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongCard.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";

$DEFAULT_SORT = "judul";
$DEFAULT_IS_DESC = false;
$PAGE_NO = $_GET['page_no'] ? $_GET['page_no'] : 1;
$PAGE_SIZE = 10;

$title = ($_GET["title"]);
$genre = ($_GET["genre"]);
$sort = ($_GET["sort"]) ? $_GET["sort"] : $DEFAULT_SORT;
$isDesc = ($_GET["isDesc"]) ? $_GET["isDesc"] : $DEFAULT_IS_DESC;

$songSrv = SongSrv::getInstance();
$songs = $songSrv->getAll($title, $genre, $sort, $PAGE_NO, $PAGE_SIZE, $isDesc);
$count = $songSrv->countRow($title, $genre);

$songElmts = implode("", array_map(function ($song) {
  return SongCard($song);
}, $songs));
$genres = $songSrv->getAllGenres();
$MIN_PAGE = 1;
$MAX_PAGE = ceil($count / $PAGE_SIZE);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/search.css">
  <title>Document</title>
</head>

<body>
  <div class="page d-flex">
    <?php
    echo Sidebar();
    ?>
    <div id="main">
      <?php
      echo Navbar();
      ?>
      <div id="content">
        <div class="song-list d-flex flex-wrap">
          <?php
          echo $songElmts;
          ?>
        </div>

        <form action="/search" method="get">
          <input type="text" class="d-none" name="title" value="<?php echo $title ?>">
          <input type="text" class="d-none" name="genre" value="<?php echo $genre ?>">
          <input type="text" class="d-none" name="sort" value="<?php echo $sort ?>">
          <div class="d-flex justify-content-center align-items-center mt-3">
            <!-- disable button if prev less than 0 -->
            <button type="submit" name="page_no" value="<?php echo $PAGE_NO - 1 ?>" class="btn btn-prev" <?php 
              if ($PAGE_NO - 1 < $MIN_PAGE) {
                echo "disabled";
              }
            ?> >
              <img src="/public/assets/icons/Chevron left.svg" alt="prev button" />
            </button>
            <p class="search-page-info">
              <?php echo "$PAGE_NO : $MAX_PAGE" ?>
            </p>
            <button type="submit" name="page_no" value="<?php echo $PAGE_NO + 1 ?>" class="btn btn-next" <?php 
              if ($PAGE_NO + 1 > $MAX_PAGE) {
                echo "disabled";
              }
            ?> >
              <img src="/public/assets/icons/Chevron right.svg" alt="next button" />
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script defer async src="/public/js/lib.js"></script>
  <script defer async src="/public/js/shared.js"></script>
</body>

</html>