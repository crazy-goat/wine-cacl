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
    /**
     * @var array
     */
    private $availTranslations;
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct(Translator $translator, array $availTranslations, string $defaultLocale)
    {
        $this->translator = $translator;
        $this->availTranslations = $availTranslations;
        $this->defaultLocale = $defaultLocale;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader('Accept-Language')) {
            $languages = $this->getAcceptedLanguages($request->getHeaderLine('Accept-Language'));

            foreach ($languages as $lang) {
                if (in_array($lang, $this->availTranslations)) {
                    $this->translator->setLocale($lang);
                    return $handler->handle($request);
                }
            }
        }
        $this->translator->setLocale($this->defaultLocale);
        return $handler->handle($request);
    }

    private function getAcceptedLanguages(string $header): array
    {
        $languages = explode(',', $header);

        $languages = array_reduce(
            $languages,
            function (array $carry, string $lang) {
                $lang = strtolower(substr(trim($lang), 0, 2));
                if (preg_match('/^[a-z]{2}$/', $lang) === 1) {
                    $carry[] = $lang;
                }
                return $carry;
            },
            []
        );

        return $languages;
    }
}