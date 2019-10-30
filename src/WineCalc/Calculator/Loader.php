<?php
declare(strict_types=1);

namespace WineCalc\Calculator;

final class Loader
{
    /**
     * @var string
     */
    private $path;
    private $loaded;
    private $data;
    private $cultures;

    /**
     * Loader constructor.
     * @param string $path
     * @param array $cultures
     */
    public function __construct(string $path, array $cultures)
    {
        $this->path = $path;
        $this->loaded = false;
        $this->cultures = $cultures;
    }

    public function load(): array
    {
        if (!$this->isLoaded()) {
            $this->data = [];
            foreach ($this->cultures as $culture) {
                $files = glob($this->path.'/'.$culture.'/*.json');
                foreach ($files as $file) {
                    $page = Single::parse($file);
                    $this->data[$culture][$page->getId()] = $page;
                }
            }
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