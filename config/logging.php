<?php

use Monolog\Handler\StreamHandler;

$config = [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
        ],


        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' =>  env('APP_LOG_MAX_FILES', 5),
        ],

        'rollbar' => [
            'driver' => 'monolog',
            'handler' => \Rollbar\Laravel\MonologHandler::class,
            'access_token' => env('ROLLBAR_TOKEN'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
        ],


        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'debug',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [ 'stream' => 'php://stdout', ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('APP_LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('APP_LOG_LEVEL', 'debug'),
        ],
    ],

];

if ((env('APP_ENV')=='production')  && env('ROLLBAR_TOKEN')) {
    array_push($config['channels']['stack']['channels'], 'rollbar');
}


return $config;
