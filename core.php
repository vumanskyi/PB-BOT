<?php
/**
 * =================
 * Init project
 * =================
 * Source of project
 */

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once PATH . '/vendor/autoload.php';

//configuration for .env files
try {
    $dotenv = Dotenv\Dotenv::create(__DIR__);
    $dotenv->load();
} catch (Exception $e) {
    die('Couldn\'t load Dotenv extension: ' . $e->getMessage());
}


$app = new \PB\App();

$content = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(CONFIG . '/binding.yml'));

if (empty($content['services'])) {
    throw new RuntimeException('Missed service fiend in building.yml');
}

foreach ($content['services'] as $key => $value) {
    $app->bind($key, new $value);
}

//Add monolog configuration
try {
    $log = new Logger('test');
    $log->pushHandler(
        new StreamHandler(
            CACHE_PATH . '/' . getenv('LOG_FILE_NAME'),
            getenv('APP_ENV') === 'prod' ? Logger::INFO : Logger::DEBUG)
    );
} catch (Exception $e) {
    die('Couldn\'t load logger extension: ' . $e->getMessage());
}

$app->addInstance('Logger', $log);


return $app;