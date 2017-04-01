<?php
declare(strict_types=1);

use Lcobucci\DependencyInjection\ContainerBuilder;
use Lcobucci\SecretSauce\DependencyInjection as SecretSauce;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();

define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: 'dev');

if (APPLICATION_ENV == 'dev') {
    $builder->useDevelopmentMode();
}

return $builder->setParameter('app.basedir', realpath(__DIR__ . '/../') . '/')
    ->addFile(__DIR__ . '/services.xml')
    ->addFile(__DIR__ . '/../src/services.xml')
    ->setDumpDir(__DIR__ . '/../storage/di')
    ->addPass(new SecretSauce\RegisterRoutes('app.main', 'app.router'))
    ->addPass(new SecretSauce\RegisterHandlers())
    ->getContainer();
