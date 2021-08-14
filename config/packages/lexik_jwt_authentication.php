<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('lexik_jwt_authentication',
        [
            'secret_key' => '%env(resolve:SECRET_KEY)%',
            'public_key' => '%env(resolve:PUBLIC_KEY)%',
            'pass_phrase' => '%env(PASSPHRASE)%'
        ]);
};

