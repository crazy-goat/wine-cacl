<?php
declare(strict_types=1);

include "vendor/autoload.php";

/** @var \Psr\Container\ContainerInterface $container */
$container = include "config/bootstrap.php";

/** @var \Slim\App $app */
$app = $container->get('app');

include "config/routes.php";

$app->run();