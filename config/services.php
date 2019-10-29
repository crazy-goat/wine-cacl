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
        $app->addRoutingMiddleware();
        $app->addMiddleware($container->get('middleware.accept-language'));

        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        $errorMiddleware->getDefaultErrorHandler()->registerErrorRenderer(
            'text/html',
            $container->get('error_handler.html')
        );
        return $app;
    },
    'middleware.accept-language' => function(ContainerInterface $container): \WineCalc\Middleware\AcceptLanguage {
        return new \WineCalc\Middleware\AcceptLanguage(
            $container->get('translator'),
            $container->get('translations'),
            $container->get('default_locale')
        );
    },
    'renderer' => function (ContainerInterface $container): \League\Plates\Engine {
        $engine =  new League\Plates\Engine($container->get('template')['path']);
        $engine->loadExtension($container->get('renderer.translator'));
        return $engine;
    },
    'renderer.translator' => function(ContainerInterface $container): \WineCalc\Plates\Extensions\Translator {
        return new \WineCalc\Plates\Extensions\Translator(
            $container->get('translator')
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
    'error_handler.html' => function(ContainerInterface $container):\Slim\Interfaces\ErrorRendererInterface
    {
        return new \WineCalc\ErrorHandler\Html($container->get('renderer'));
    }
];
