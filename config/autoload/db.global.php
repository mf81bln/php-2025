<?php

declare(strict_types=1);

return [
    'db' => [
        'driver' => 'Pdo_Pgsql',
        'hostname' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: '5432',
        'database' => getenv('DB_NAME') ?: 'contacts',
        'username' => getenv('DB_USER') ?: 'laminas',
        'password' => getenv('DB_PASSWORD') ?: 'laminas_secret',
    ],
    'service_manager' => [
        'factories' => [
            \Laminas\Db\Adapter\AdapterInterface::class => \Laminas\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
];
