<?php
declare(strict_types=1);

namespace WineCalc\Controller;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use WineCalc\Calculator\Data;
use WineCalc\Calculator\Loader;
use WineCalc\Calculator\Single;

final class Calculator
{
    /**
     * @var Engine
     */
    private $render;
    /**
     * @var Data
     */
    private $loader;

    public function __construct(Engine $render, Data $loader)
    {
        $this->render = $render;
        $this->loader = $loader;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws HttpNotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $recipe = $this->loader->getRecipe(
            $request->getAttribute('culture'),
            $request->getAttribute('url')
        );

        if (!$recipe instanceof Single) {
            throw new HttpNotFoundException($request);
        }

        $response->getBody()->write(
            $this->render->render(
                'calculator/index',
                $this->loader->getData($recipe)
            )
        );

        return $response;
    }
}