<?php
  #Log levels note
  // DEBUG (100): Detailed debug information.
  // INFO (200): Interesting events. Examples: User logs in, SQL logs.
  // NOTICE (250): Normal but significant events.
  // WARNING (300): Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
  // ERROR (400): Runtime errors that do not require immediate action but should typically be logged and monitored.
  // CRITICAL (500): Critical conditions. Example: Application component unavailable, unexpected exception.
  // ALERT (550): Action must be taken immediately. Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.
  // EMERGENCY (600): Emergency: system is unusable.
  require_once __DIR__ . '/../vendor/autoload.php';

  // For easy calling function
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;
  use Monolog\Handler\FirePHPHandler;
  use Monolog\Handler\BrowserConsoleHandler;

  // Create Logger Chanel for each use
  $flog = new Logger('front_log'); // Log
  // $blog = new Logger('back_log'); //

  // Log handler [ Handler is handler where log output goes and keep ]
  // $logger->pushHandler(new StreamHandler(__DIR__.'/../log/my_app.log', Logger::DEBUG)); // File log
  $flog->pushHandler(new FirePHPHandler());
  $flog->pushHandler(new BrowserConsoleHandler()); // Ha no more jealous to JS browser log !
  // $blog->pushHandler(new FirePHPHandler());

  // Start logger
  $flog->info('Monolog online');
  // $blog->debug('Back Logger is Online SAFE n SOUND');
?>
