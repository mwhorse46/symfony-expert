<?php
declare(strict_types=1);

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import('../../src/Http/Controller/', 'annotation')
        ->prefix('api');

    $routingConfigurator->import('../../src/Kernel.php', 'annotation');

    $routingConfigurator->add('api_login_check', '/api/login')
        ->methods(['POST']);

    $routingConfigurator->add('gesdinet_jwt_refresh_token', '/api/login-refresh')
        ->methods(['POST'])
        ->controller('gesdinet.jwtrefreshtoken::refresh');
};
