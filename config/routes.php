<?php
declare(strict_types=1);

if (isset($app)) {
    $app->get('/', 'controller::main');
    $app->get('/static/{culture}/{url}', 'controller::static-page')->setName('staticPage');
    $app->get('/recipe/{culture}/{url}', 'controller::calculator')->setName('calculator');
    $app->get('/recipe/{culture}', 'controller::calculator')->setName('recipeList');
} else {
    throw new RuntimeException('No Slim application found');
}