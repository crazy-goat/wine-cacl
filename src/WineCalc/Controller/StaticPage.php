<?php
declare(strict_types=1);

namespace WineCalc\Controller;

use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use WineCalc\StaticPages\Page;
use WineCalc\StaticPages\Data;

class StaticPage
{
    /**
     * @var Data
     */
    private $staticPage;
    /**
     * @var Engine
     */
    private $render;

    public function __construct(Data $staticPage, Engine $render)
    {
        $this->staticPage = $staticPage;
        $this->render = $render;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws HttpNotFoundException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {
        $staticPage = $this->staticPage->getStaticPage(
            $request->getAttribute('culture'),
            $request->getAttribute('url')
        );

        if (!$staticPage instanceof Page) {
            throw new HttpNotFoundException($request);
        }

        $response->getBody()->write(
            $this->render->render(
                'static_page/index',
                $this->staticPage->getData($staticPage)
            )
        );
        return $response;
    }
}