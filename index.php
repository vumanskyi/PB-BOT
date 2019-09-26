<?php
require_once __DIR__ . '/defines.php';

$app = require_once PATH . '/core.php';

$kernel = new \PB\Kernel($app);

$kernel->execution();