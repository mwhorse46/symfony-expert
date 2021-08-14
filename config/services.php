<?php

declare(strict_types=1);

use App\Application\EventListener\RequestEventListener;
use App\Application\Service\UserService;
use App\Http\Resolver\UserResolver;
use App\Application\Contract\{
    DataManagerInterface,
    DataSerializerInterface,
    DataTransformerInterface
};
use App\Application\Data\{
    Manager\JsonDataManager,
    Serializer\JsonSerializer,
    Transformer\UserTransformer
};
use App\Http\Resolver\RequestResolver;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure()
        ->bind('string $baseUrl', '%env(APP_URL)%');

    $services->load('App\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/DependencyInjection/',
            __DIR__ . '/../src/Database/Entity/',
            __DIR__ . '/../src/Kernel.php',
            __DIR__ . '/../src/Tests/'
        ]);


    //Request Services
    $services->set(RequestEventListener::class)
        ->tag('kernel.event_listener', ['event' => KernelEvents::REQUEST]);

    $services->set(RequestResolver::class)
        ->args([service(ValidatorInterface::class)])
        ->tag('controller.request_value_resolver', ['priority' => 50]);

    $services->set(UserResolver::class)
        ->args([service(UserService::class)])
        ->tag('controller.request_value_resolver', ['priority' => 50]);

    //Data Services
    $services->set('app.data.jsonSerializer', JsonSerializer::class)
        ->alias(DataSerializerInterface::class . ' $jsonSerializer', 'app.data.jsonSerializer');

    $services->set('app.data.jsonManager', JsonDataManager::class)
        ->call('setSerializer', [service('app.data.jsonSerializer')])
        ->alias(DataManagerInterface::class . ' $jsonManager', 'app.data.jsonManager');

    $services->set('app.data.userTransformer', UserTransformer::class)
        ->alias(DataTransformerInterface::class . ' $userTransformer', 'app.data.userTransformer');
};
