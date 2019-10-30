<?php
declare(strict_types=1);
/** @var \Slim\App $app */

$app->get('/', 'controller::main');
$app->get('/static/{culture}/{url}', 'controller::static-page')->setName('staticPage');
$app->get('/recipe/{culture}/{url}', 'controller::calculator')->setName('calculator');