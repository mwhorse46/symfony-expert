<?php

declare(strict_types=1);

use Symfony\Config\DoctrineMigrationsConfig;

return static function (DoctrineMigrationsConfig $config): void {
    $config->migrationsPath('App\Database\Migration', '%kernel.project_dir%/src/Database/Migration');
    $config->storage([
        'table_storage' => [
            'table_name' => 'migrations'
        ]
    ]);
    $config->enableProfiler('%kernel.debug%');
};
