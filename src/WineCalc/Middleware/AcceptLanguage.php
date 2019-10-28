<?php
declare(strict_types=1);

namespace WineCalc\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Translation\Translator;

final class AcceptLanguage implements MiddlewareInterface
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $accept = $request->getHeaders()['Accept-Language'] ?? ['en'];
        $this->translator->setLocale(reset($accept));
        $response = $handler->handle($request);
        return $response;
    }
}