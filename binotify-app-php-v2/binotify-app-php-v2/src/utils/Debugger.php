<?php

class Debugger
{
  public static function log($msg)
  {
    $output = $msg;
    if (is_array($output))
      $output = implode(',', $output);

    error_log(print_r($output, true));
  }
}
