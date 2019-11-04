<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    'controller::main' => function(ContainerInterface $container): \WineCalc\Controller\Main {
        return new \WineCalc\Controller\Main($container->get('renderer'));
    },
    'controller::static-page' => function(ContainerInterface $container): \WineCalc\Controller\StaticPage {
        return new \WineCalc\Controller\StaticPage(
            $container->get('staticPage::render'),
            $container->get('renderer')
        );
    },
    'controller::calculator' => function(ContainerInterface $container): \WineCalc\Controller\Calculator {
        return new \WineCalc\Controller\Calculator(
            $container->get('renderer'),
            $container->get('calculator::render')
        );
    }
];