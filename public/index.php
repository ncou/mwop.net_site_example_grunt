<?php
/**
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @copyright Copyright (c) Matthew Weier O'Phinney
 */

namespace Mwop;

use Zend\Expressive\Application;
use Zend\Expressive\Helper;
use Zend\Stratigility\Middleware\OriginalMessages;

error_reporting(E_ALL & ~E_USER_DEPRECATED);

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$container = require 'config/container.php';
$app       = $container->get(Application::class);
$app->run();
