<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    'controller::main' => function(ContainerInterface $container): \WineCalc\Controller\Main {
        return new \WineCalc\Controller\Main($container->get('renderer'));
    }
];