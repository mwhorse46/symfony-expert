<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (ContainerConfigurator $containerConfigurator, FrameworkConfig $config): void {
    $config->secret('%env(APP_SECRET)%')
        ->httpMethodOverride(false);

    $config->session()
        ->handlerId(null)
        ->cookieSecure('auto')
        ->cookieSamesite('lax')
        ->storageFactoryId('session.storage.factory.native');

    $config->phpErrors([
        'log' => true
    ]);

    if ($containerConfigurator->env('test')) {
        $config->test(true);
        $config->session()
            ->storageFactoryId('session.storage.factory.mock_file');
    }
};
