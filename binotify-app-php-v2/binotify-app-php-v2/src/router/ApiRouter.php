<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/exceptions/BadRequestException.php";
require_once PROJECT_ROOT_PATH . "/src/exceptions/MethodNotAllowedException.php";

class ApiRouter {
  private $pathAndHandler;

  public function addHandler($path, $handler, $middlewares) {
    $this->pathAndHandler[$path] = [$handler, $middlewares];
  }

  public function run($path, $method) {
    try {
      $pathWithoutQuery = explode('?', $path)[0];
      $this->routing($pathWithoutQuery, $method);
    } catch (BadRequestException $e) {
      header("HTTP/1.0 400 Bad Request");
      echo (new BaseResponse(
        false,
        null,
        $e->getMessage(),
        400
      ))->toJSON();
    } catch (MethodNotAllowedException $e) {
      header("HTTP/1.0 405 Method Not Allowed");
      echo (new BaseResponse(
        false,
        null,
        $e->getMessage(),
        405
      ))->toJSON();
    } catch (Exception $e) {
      header("HTTP/1.0 500 Internal Server Error");
      echo (new BaseResponse(
        false,
        null,
        $e->getMessage(),
        500
      ))->toJSON();
    } catch (Exception $e) {
      Logger::error($e->getMessage());
      header("HTTP/1.0 500 Internal Server Error");
      echo (new BaseResponse(
        false,
        null,
        "INTERNAL SERVER ERROR",
        500
      ))->toJSON();
    }
  }

  private function routing($path, $method) {
    foreach ($this->pathAndHandler as $key => $value) {
      $match = $this->isMatch($path, $key);
      if ($match[0]) {
        $middlewares = $value[1];

        $isPass = true;
        foreach ($middlewares as $middleware) {
          $isPass = $middleware($path, $method);
          if (!$isPass) {
            break;
          }
        }
      
        if ($isPass) {
          echo $value[0]->handle($method, $match[1]);
          exit();
        }
      }
    }
    throw new MethodNotAllowedException("Method not allowed");
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

