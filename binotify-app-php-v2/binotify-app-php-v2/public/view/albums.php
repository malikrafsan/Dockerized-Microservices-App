<?php
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/public/components/AlbumCard.php";
require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";

$DEFAULT_SORT = "judul";
$DEFAULT_IS_DESC = false;
$PAGE_NO = $_GET['page_no'] ? $_GET['page_no'] : 1;
$PAGE_SIZE = 10;

$title = ($_GET["title"]);
$genre = ($_GET["genre"]);
$sort = ($_GET["sort"]) ? $_GET["sort"] : $DEFAULT_SORT;
$isDesc = ($_GET["isDesc"]) ? $_GET["isDesc"] : $DEFAULT_IS_DESC;

$albumSrv = AlbumSrv::getInstance();
$albums = $albumSrv->getAll($title, $genre, $sort, $PAGE_NO, $PAGE_SIZE, $isDesc);
$count = $albumSrv->countRow($title, $genre);
$genres = $albumSrv->getAllGenres();

$albumCards = implode("", array_map(function ($album) {
  return AlbumCard($album);
}, $albums));

$MIN_PAGE = 1;
$MAX_PAGE = ceil($count / $PAGE_SIZE);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/lib.css">
  <link rel="stylesheet" href="public/css/shared.css">
  <link rel="stylesheet" href="public/css/albums.css">
  <title>Document</title>
</head>

<body>
  <div class="page d-flex">
    <?php
    echo Sidebar();
    ?>
    <div id="main">
      <?php
      echo Navbar("/albums", $genres, "What album you are looking for?");
      ?>
      <div id="content">
        <div class="album-list d-flex flex-wrap">
          <?php
            echo $albumCards;
          ?>
        </div>

        <form action="/albums" method="get">
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
            <p class="album-search-page-info">
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