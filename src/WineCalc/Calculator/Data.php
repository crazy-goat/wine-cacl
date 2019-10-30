<?php
declare(strict_types=1);

namespace WineCalc\Calculator;

final class Data
{
    /**
     * @var Loader
     */
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function getData(Single $recipe): array
    {
        return [
            'title' => $recipe->getTitle(),
            'head' => $recipe->getHead(),
            'steps' => $recipe->getSteps()
        ];
    }

    public function getRecipe(string $culture, string $url): ?Single
    {
        $data = $this->loader->load();
        return $data[$culture][$url] ?? null;
    }
}