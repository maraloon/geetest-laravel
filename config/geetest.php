<?php

return [
    'api_endpoint' => 'http://api.geetest.com',
    'id' => env('GEETEST_ID'),
    'key' => env('GEETEST_KEY'),
    'sdk_version' => 'php-laravel:3.1.0',
    'bypass_endpoint' => 'https://bypass.geetest.com/v1/bypass_status.php',
    'is_api_available_redis_key' => 'REDIS_CHECK_GEETEST_STATUS_KEY',
];
