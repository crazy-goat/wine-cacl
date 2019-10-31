<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    'rr:server' => function (): \Spiral\RoadRunner\PSR7Client {
        return new Spiral\RoadRunner\PSR7Client(
            new Spiral\RoadRunner\Worker(
                new Spiral\Goridge\StreamRelay(STDIN, STDOUT)
            )
        );
    },
    'app' => function (ContainerInterface $container): \Slim\App {
        $app = \Slim\Factory\AppFactory::create(
            \Slim\Factory\AppFactory::determineResponseFactory(),
            $container
        );
        $app->addMiddleware($container->get('middleware.accept-language'));
        $app->addRoutingMiddleware();

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        if ($errorHandler instanceof \Slim\Handlers\ErrorHandler) {
            $errorHandler->registerErrorRenderer(
                'text/html',
                $container->get('error_handler.html')
            );
        }
        return $app;
    },
    'middleware.accept-language' => function(ContainerInterface $container): \WineCalc\Middleware\AcceptLanguage {
        return new \WineCalc\Middleware\AcceptLanguage(
            $container->get('translator'),
            $container->get('translations'),
            (string)$container->get('default_locale')
        );
    },
    'renderer' => function (ContainerInterface $container): \League\Plates\Engine {
        $engine =  new League\Plates\Engine($container->get('template')['path']);
        $engine->loadExtension($container->get('renderer.translator'));
        $engine->loadExtension($container->get('renderer.links'));
        return $engine;
    },
    'renderer.translator' => function(ContainerInterface $container): \WineCalc\Plates\Extensions\Translator {
        return new \WineCalc\Plates\Extensions\Translator(
            $container->get('translator')
        );
    },
    'app.closure' => function(ContainerInterface $container): \Closure{
        return function() use ($container): \Slim\Interfaces\RouteParserInterface {
            return $container->get('app')->getRouteCollector()->getRouteParser();
        };
    },
    'renderer.links' => function(ContainerInterface $container): \WineCalc\Plates\Extensions\Links {
        return new \WineCalc\Plates\Extensions\Links(
            $container->get('app.closure')
        );
    },
    'translator' => function (ContainerInterface $container): \Symfony\Component\Translation\Translator {
        $translator = new \Symfony\Component\Translation\Translator(null);
        $translator->addLoader('array', new \Symfony\Component\Translation\Loader\ArrayLoader());
        $translator->addResource('array', include __DIR__ . '/../data/i18n/pl.php', 'pl');
        $translator->addResource('array', include __DIR__ . '/../data/i18n/en.php', 'en');
        $translator->setFallbackLocales([$container->get('default_locale')]);

        return $translator;
    },
    'error_handler.html' => function(ContainerInterface $container): \Slim\Interfaces\ErrorRendererInterface
    {
        return new \WineCalc\ErrorHandler\Html($container->get('renderer'));
    },
    'staticPage::loader' => function(ContainerInterface $container): \WineCalc\StaticPages\Loader {
        return new \WineCalc\StaticPages\Loader(
            (string)$container->get('static_pages_dir'),
            $container->get('translations')
        );
    },
    'staticPage::render' => function(ContainerInterface $container): \WineCalc\StaticPages\Data {
        return new \WineCalc\StaticPages\Data($container->get('staticPage::loader'));
    },
    'calculator::loader' => function(ContainerInterface $container): \WineCalc\Calculator\Loader {
        return new \WineCalc\Calculator\Loader(
            (string)$container->get('recipes_dir'),
            $container->get('translations')
        );
    },
    'calculator::render' => function(ContainerInterface $container): \WineCalc\Calculator\Data {
        return new \WineCalc\Calculator\Data($container->get('calculator::loader'));
    },
];
