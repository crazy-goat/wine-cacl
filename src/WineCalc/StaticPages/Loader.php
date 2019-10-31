<?php
declare(strict_types=1);

namespace WineCalc\StaticPages;

class Loader
{
    /**
     * @var string
     */
    private $path;

    /** @var bool */
    private $loaded;
    /**
     * @var array
     */
    private $cultures;
    private $data;

    public function __construct(string $path, array $cultures)
    {
        $this->path = $path;
        $this->cultures = $cultures;
        $this->loaded = false;
    }

    public function load(): array
    {
        if (!$this->isLoaded()) {
            $this->data = [];
            foreach ($this->cultures as $culture) {
                $files = glob($this->path.'/'.$culture.'/*.json');
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $page = Page::parse($file);
                        $this->data[$culture][$page->getId()] = $page;
                    }
                }
            }
            $this->loaded = true;
        }

        return $this->data;
    }

    /**
     * @return bool
     */
    public function isLoaded(): bool
    {
        return $this->loaded;
    }
}