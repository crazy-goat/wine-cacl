<?php
declare(strict_types=1);

namespace WineCalc\Plates\Extensions;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Slim\Interfaces\RouteParserInterface;

final class StaticPageLink implements ExtensionInterface
{
    /**
     * @var RouteParserInterface
     */
    private $router;

    public function __construct(\Closure $router)
    {
        $this->router = $router;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('staticPageUrl', [$this, 'staticPageUrl']);
    }

    public function staticPageUrl(string $id, string $cultuer): string
    {
        return ($this->router)()->urlFor('staticPage', ['url' => $id, 'culture'=> $cultuer]);
    }
}