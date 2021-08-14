<?php

declare(strict_types=1);

use App\Database\Entity\User;
use Symfony\Config\SecurityConfig;

return static function (SecurityConfig $security): void {

    $security->enableAuthenticatorManager(true);

    $security->accessDecisionManager()
        ->strategy('unanimous')
        ->allowIfAllAbstain(false);

    $security->provider('app_user_provider')
        ->entity()
        ->class(User::class)
        ->property('username');

    $security->firewall('login')
        ->pattern('^/api/login')
        ->stateless(true)
        ->jsonLogin()
        ->checkPath('/api/login')
        ->successHandler('lexik_jwt_authentication.handler.authentication_success')
        ->failureHandler('lexik_jwt_authentication.handler.authentication_failure');

    $security->firewall('api')
        ->pattern('^/api')
        ->stateless(true)
        ->guard()
        ->authenticators(['lexik_jwt_authentication.jwt_token_authenticator']);

    $security->firewall('api_token_refresh')
        ->pattern('^/api/login-refresh')
        ->stateless(true);

    $security->passwordHasher(User::class)
        ->algorithm('auto')
        ->cost(12);
};