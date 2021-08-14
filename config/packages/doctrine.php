<?php
declare(strict_types=1);

use App\Database\Repository\Filters\DeletedFilter;
use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $config): void {
    $config->dbal()
        ->connection('default', ['url' => '%env(resolve:DATABASE_URL)%']);

    $emDefault = $config->orm()->entityManager('default');

    $emDefault->autoMapping(true)
        ->namingStrategy('doctrine.orm.naming_strategy.underscore_number_aware')
        ->mapping('App\Database\Entity')
        ->isBundle(false)
        ->type('attribute')
        ->dir('%kernel.project_dir%/src/Database/Entity')
        ->prefix('App\Database\Entity')
        ->alias("App");

    $emDefault->filter('deleted')
        ->class(DeletedFilter::class)
        ->enabled(true);

    $config->orm()
        ->autoGenerateProxyClasses(true)
        ->defaultEntityManager('default');

};
