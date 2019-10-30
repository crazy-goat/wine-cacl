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

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $response->getBody()->write(
            $this->render->render(
                'main/index',
                []
            )
        );
        return $response;
    }
}