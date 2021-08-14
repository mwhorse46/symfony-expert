<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (ContainerConfigurator $containerConfigurator, FrameworkConfig $config): void {
    $config->router()->utf8(true);

    if ($containerConfigurator->env('prod')) {
        $config->router()
            ->strictRequirements(null);
    }
};
