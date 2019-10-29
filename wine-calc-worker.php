<?php
declare(strict_types=1);

ini_set('display_errors', 'stderr');
include "vendor/autoload.php";

/** @var \Psr\Container\ContainerInterface $container */
$container = include "config/bootstrap.php";

/** @var \Spiral\RoadRunner\PSR7Client $rrServer */
$rrServer = $container->get('rr:server');

/** @var \Slim\App $app */
$app = $container->get('app');

include "config/routes.php";

while ($req = $rrServer->acceptRequest()) {
    try {
        $rrServer->respond($app->handle($req));
    } catch (\Throwable $e) {
        $rrServer->getWorker()->error((string)$e);
    }
}