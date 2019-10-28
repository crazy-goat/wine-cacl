<?php
/**
 * Created by PhpStorm.
 * User: piotr
 * Date: 26.10.19
 * Time: 21:09
 */

namespace WineCalc\Plates\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Symfony\Component\Translation\Translator as SymfonyTranslator;

class Translator implements ExtensionInterface
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
    }

    public function trans(): string {
        $args = func_get_args();
        return $this->translator->trans(...$args);
    }
}
