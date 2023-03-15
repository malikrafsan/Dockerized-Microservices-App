<?php

class PageRouter {
  private $routes;
  private $errorRoute;
  
  public function __construct($routes) {
    $this->routes = $routes;
  }

  public function routing($path, $method) {
    $path = explode("?", $path)[0];
    foreach ($this->routes as $key => $value) {
      $match = $this->isMatch($path, $key);
      $_GLOBALS['__urlParams'] = $match[1];
      if ($match[0]) {
        require $value;
        exit();
      }
    }

    if (isset($this->errorRoute)) {
      require $this->errorRoute;
    } else {
      header("HTTP/1.0 404 Not Found");
    }
  }

  public function setErrorRoute($errorRoute) {
    $this->errorRoute = $errorRoute;
  }

  public function isMatch($path, $keyHandler) {
    $path = explode("/", $path);
    $keyHandler = explode("/", $keyHandler);

    if (count($path) !== count($keyHandler)) {
      return [false, []];
    }

    $urlParams = [];

    for ($i = 0; $i < count($path); $i++) {
      if ($path[$i] !== $keyHandler[$i] && $keyHandler[$i] !== "*") {
        return [false, []];
      }

      if ($keyHandler[$i] === "*") {
        $urlParams[] = $path[$i];
      }
    }

    return [true, $urlParams];
  }
}
