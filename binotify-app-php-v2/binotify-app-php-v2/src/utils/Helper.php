<?php

class Helper {
  public static function getYearFromDate($date) {
    return date("Y", strtotime($date));
  }

  public static function getDateFromDateTime($date) {
    return date("d M Y", strtotime($date));
  }

  public static function formatDuration($second) {
    $hours = floor($second / 3600);
    $minutes = floor(($second / 60) % 60);
    $seconds = $second % 60;

    $str = "";
    if ($hours > 0) {
      $str .= $hours . ":";
    }
    $str .= $minutes . ":";
    $str .= $seconds / 10 < 1 ? "0" . $seconds : $seconds;

    return $str;
  }

  public static function formatLongDuration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;

    $str = "";
    if ($hours > 0) {
      $str .= $hours . " hr ";
    }
    if ($minutes > 0) {
      $str .= $minutes . " min ";
    }
    if ($seconds > 0) {
      $str .= $seconds . " sec";
    }

    return $str;
  }
}

