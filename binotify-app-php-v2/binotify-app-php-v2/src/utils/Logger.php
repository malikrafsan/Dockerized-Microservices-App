<?php

class Logger
{
  protected static $log_file;
  protected static $file;
  protected static $options = [
    'dateFormat' => 'd-M-Y',
    'logFormat' => 'H:i:s d-M-Y'
  ];
  private static $instance;
  private static $logdir = PROJECT_ROOT_PATH . '/logs';

  public static function createLogFile()
  {
    $time = date(static::$options['dateFormat']);
    static::$log_file = static::$logdir . "/log-{$time}.txt";

    if (!file_exists(static::$logdir)) {
      mkdir(static::$logdir, 0777, true);
    }

    if (!file_exists(static::$log_file)) {
      fopen(static::$log_file, 'w') or exit("Can't create {static::log_file}!");
    }

    if (!is_writable(static::$log_file)) {
      throw new Exception("ERROR: Unable to write to file!", 1);
    }
  }

  public static function setOptions($options = [])
  {
    static::$options = array_merge(static::$options, $options);
  }

  public static function info($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'INFO',
      'context' => $context
    ]);
  }

  public static function notice($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'NOTICE',
      'context' => $context
    ]);
  }

  public static function debug($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'DEBUG',
      'context' => $context
    ]);
  }

  public static function warning($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'WARNING',
      'context' => $context
    ]);
  }

  public static function error($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'ERROR',
      'context' => $context
    ]);
  }

  public static function fatal($message, array $context = [])
  {
    $bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);

    static::writeLog([
      'message' => $message,
      'bt' => $bt,
      'severity' => 'FATAL',
      'context' => $context
    ]);
  }

  public static  function writeLog($args = [])
  {
    static::createLogFile();

    if (!is_resource(static::$file)) {
      static::openLog();
    }

    $time = date(static::$options['logFormat']);

    $context = json_encode($args['context']);

    $caller = array_shift($args['bt']);
    $btLine = $caller['line'];
    $btPath = $caller['file'];

    $path = static::absToRelPath($btPath);

    $timeLog = is_null($time) ? "[N/A] " : "[{$time}] ";
    $pathLog = is_null($path) ? "[N/A] " : "[{$path}] ";
    $lineLog = is_null($btLine) ? "[N/A] " : "[{$btLine}] ";
    $severityLog = is_null($args['severity']) ? "[N/A]" : "[{$args['severity']}]";
    $messageLog = is_null($args['message']) ? "N/A" : "{$args['message']}";
    $contextLog = empty($args['context']) ? "" : "{$context}";

    fwrite(static::$file, "{$timeLog}{$pathLog}{$lineLog}: {$severityLog} - {$messageLog} {$contextLog}" . PHP_EOL);

    static::closeFile();
  }

  private static function openLog()
  {
    $openFile = static::$log_file;
    static::$file = fopen($openFile, 'a') or exit("Can't open $openFile!");
  }

  public static function closeFile()
  {
    if (static::$file) {
      fclose(static::$file);
    }
  }

  public static function absToRelPath($pathToConvert)
  {
    $pathAbs = str_replace(['/', '\\'], '/', $pathToConvert);
    $documentRoot = str_replace(['/', '\\'], '/', $_SERVER['DOCUMENT_ROOT']);
    return $_SERVER['SERVER_NAME'] . str_replace($documentRoot, '', $pathAbs);
  }

  protected function __construct()
  {
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __destruct()
  {
  }
}
