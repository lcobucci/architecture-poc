<?php
declare(strict_types=1);

/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get('app.main');
$app->run();
