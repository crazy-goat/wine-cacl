<?php
declare(strict_types=1);

namespace WineCalc\StaticPages;

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

    public function getData(Page $page): array
    {
        return [
            'title' => $page->getTitle(),
            'head' => $page->getHead(),
            'content' => $page->getContent()
        ];
    }

    public function getStaticPage(string $culture, string $url): ?Page
    {
        $data = $this->loader->load();
        return $data[$culture][$url] ?? null;
    }
}