<?php

declare(strict_types=1);

use Core\Http\Interfaces\ResponseInterface;
use Core\Http\JsonRequest;
use Core\Http\JsonResponse;

define('DS', DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', __DIR__.DS);
define('ROOT_DIR', PUBLIC_DIR.'..'.DS);
define('CONFIG_DIR', ROOT_DIR.'config'.DS);
define('SRC_DIR', ROOT_DIR.'src'.DS);

require_once ROOT_DIR.'/vendor/autoload.php';

$requestCount = 100;
$start = microtime(true);

for ($i = 0; $i < $requestCount; $i++) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost:8000/transactions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
    "id": "1123123",
    "sku": 13123123,
    "variant_id": 1,
    "title": "Product 1"
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response . "--\n";
}

$end = microtime(true);

$time = $end - $start;
printf("Time took: %.8f secs (%.8f secs per request)\n\n", $time, ($time / $requestCount));
