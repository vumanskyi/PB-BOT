<?php
require_once __DIR__ . '/defines.php';

$app = require_once PATH . '/core.php';

$env = $app->getBind(\PB\Config\ConfigInterface::class);

$kernel = new \PB\Kernel($app);

$kernel->execution();