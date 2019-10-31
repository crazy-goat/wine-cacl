<?php
declare(strict_types=1);

namespace WineCalc\Plates\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

final class Links implements ExtensionInterface
{
    /**
     * @var \Closure
     */
    private $router;

    public function __construct(\Closure $router)
    {
        $this->router = $router;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('staticPageUrl', [$this, 'staticPageUrl']);
        $engine->registerFunction('recipeListUrl', [$this, 'recipeListUrl']);
    }

    public function staticPageUrl(string $id, string $culture): string
    {
        return ($this->router)()->urlFor('staticPage', ['url' => $id, 'culture'=> $culture]);
    }

    public function recipeListUrl(string $culture): string
    {
        return ($this->router)()->urlFor('recipeList', ['culture'=> $culture]);
    }
}