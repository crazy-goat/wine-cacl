<?php
declare(strict_types=1);

namespace WineCalc\Plates\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Symfony\Component\Translation\Translator as SymfonyTranslator;

final class Translator implements ExtensionInterface
{
    /**
     * @var SymfonyTranslator
     */
    private $translator;

    public function __construct(SymfonyTranslator $translator)
    {
        $this->translator = $translator;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('trans', [$this, 'trans']);
        $engine->registerFunction('lang', [$this, 'lang']);
    }

    public function trans(): string {
        $args = func_get_args();
        return $this->translator->trans(...$args);
    }

    public function lang(): string
    {
        return $this->translator->getLocale() ?? 'en';
    }
}
