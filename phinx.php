<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/src/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/src/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => $_ENV['APP_ENV'],
        'production' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
