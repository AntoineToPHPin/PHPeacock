<?php

declare(strict_types=1);

use PHPeacock\Autoloader;

require_once '../src/Autoloader.php';

(new Autoloader)->register();

$config = require_once '../config/config.php';
