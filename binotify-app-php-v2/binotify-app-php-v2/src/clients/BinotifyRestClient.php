<?php

require_once PROJECT_ROOT_PATH . "/src/utils/HttpCall.php";

class BinotifyRestClient {
  private static $url = "http://host.docker.internal:8000";

  public static function getPremiumSong($subscriberId, $creatorId) {
    $url = self::$url . "/premium-songs";
    $data = ["subscriber_id" => $subscriberId, "creator_id" => $creatorId];
    $resp = HttpCall::get($url, $data);
    return $resp;
  }

  public static function getPremiumArtist() {
    $url = self::$url . "/artists";
    $resp = HttpCall::get($url);
    
    return json_decode($resp);
  }
}
