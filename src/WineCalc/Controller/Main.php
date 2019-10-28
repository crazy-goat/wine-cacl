<?php
declare(strict_types=1);

namespace WineCalc\Controller;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Main {
    /**
     * @var Engine
     */
    private $render;

    public function __construct(Engine $render)
    {
        $this->render = $render;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write(
            $this->render->render(
                'main/index',
                []
            )
        );
        return $response;
    }
}