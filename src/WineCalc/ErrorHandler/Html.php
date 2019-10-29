<?php
declare(strict_types=1);

namespace WineCalc\ErrorHandler;

use League\Plates\Engine;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

final class Html implements ErrorRendererInterface
{
    /**
     * @var Engine
     */
    private $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        if ($exception instanceof HttpNotFoundException) {
            return $this->engine->render(
                'error/404',
                []
            );
        }

        return $this->engine->render(
            'error/500',
            []
        );
    }
}