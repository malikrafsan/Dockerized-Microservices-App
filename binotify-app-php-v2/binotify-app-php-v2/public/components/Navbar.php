<?php

require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";

function Navbar($toSearch = '/search', $possibleGenresDef = null, $placeholderDef = null)
{
  $title = ($_GET["title"]);
  $chosenGenre = ($_GET["genre"]);
  $chosenSort = ($_GET["sort"]);
  $isDesc = ($_GET["isDesc"]);
  $ascSelected = $isDesc ? "" : "selected";
  $descSelected = $isDesc ? "selected" : "";

  $songSrv = SongSrv::getInstance();
  $possibleGenres = $possibleGenresDef ? $possibleGenresDef : $songSrv->getAllGenres();
  Logger::debug(json_encode($possibleGenres));
  $genreOptions = implode("", array_map(function ($genre) use ($chosenGenre) {
    if (!isset($genre)) {
      return "";
    }

    $selected = $genre == $chosenGenre ? "selected" : "";
    return "<option value='$genre' " . $selected . " >$genre</option>";
  }, $possibleGenres));

  $possibleSorts = ["Sort by Title" => 'judul', "Sort by Year" => 'tanggal_terbit', "Sort by Singer" => 'penyanyi', "Sort by Genre" => 'genre'];
  $sortOptions = implode("", array_map(function ($label, $value) use ($chosenSort) {
    $selected = $value == $chosenSort ? "selected" : "";
    return "<option value='$value' " . $selected . ">$label</option>";
  }, array_keys($possibleSorts), array_values($possibleSorts)));

  $placeholder = $placeholderDef ? $placeholderDef : "What do you want to listen to?";

  $sidebarControl = SidebarControl();
  $userProfile = UserProfile();

  $html = <<<"EOT"
  <div class="navbar pt-4 px-3 px-md-4 d-flex justify-content-between align-items-start">
    $sidebarControl
    <div class="d-flex align-items-center flex-wrap-reverse flex-grow-1 main-navbar">
      <div class="d-flex justify-content-start align-items-center">
        <form action="$toSearch" method="get">
          <div class="navbar-top-container d-flex flex-wrap align-items-center">
            <div class="input-title search-bar position-relative">
              <input type="text" name="title" class="search-input" placeholder="$placeholder" value="$title" />
              <div class="search-bar-icon img-container position-absolute">
                <img src="/public/assets/search-icon.svg" alt="search icon" />
              </div>
            </div>
            <div class="d-flex">
              
            </div>
          </div>
          <div class="navbar-bottom-container d-flex justify-content-center align-items-center flex-wrap">
            <div class="input-genre select-input-navbar">
              <div>
                <select name="genre" id="genre">
                  <option value="">All Genre</option>
                  {$genreOptions}
                </select>
              </div>
            </div>
            <div class="input-sort select-input-navbar">
              <select name="sort" id="sort">
                {$sortOptions}
              </select>
            </div>
            <div class="input-is-desc select-input-navbar">
              <select name="isDesc" id="isDesc">
                <option value="0" $ascSelected>Ascending</option>
                <option value="1" $descSelected>Descending</option>
              </select>
            </div>
            <div class="input-submit-navbar">
              <button type="submit">Go</button>
            </div>
          </div>
        </form>
      </div>
      $userProfile
    </div>
  </div>
EOT;

  return $html;
}
