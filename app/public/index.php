<?php

declare(strict_types=1);

use App\Application;
use Core\Http\JsonRequest;

define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', __DIR__.DS);
define('ROOT_DIR', PUBLIC_DIR.'..'.DS);
define('CONFIG_DIR', ROOT_DIR.'config'.DS);
define('SRC_DIR', ROOT_DIR.'src'.DS);

require_once ROOT_DIR.'/vendor/autoload.php';

$request = new JsonRequest();
$app = new Application();
$response = $app->handle($request);
$response->send();
