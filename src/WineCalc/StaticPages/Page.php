<?php
declare(strict_types=1);

namespace WineCalc\StaticPages;

use Parsedown;

final class Page
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;
    /**
     * @var string
     */
    private $head;

    /** @var string  */
    private $content;

    /**
     * @param string $path
     * @return Page
     * @throws \InvalidArgumentException
     */
    public static function parse(string $path): Page
    {
        $parser = new Parsedown();
        $data = json_decode(file_get_contents($path), true);
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Error parsing json');
        }

        $data['id'] = pathinfo($path, PATHINFO_FILENAME);
        $mdPath = pathinfo($path, PATHINFO_DIRNAME).'/'.$data['id'].'.md';
        if (file_exists($mdPath) && is_readable($mdPath)) {
            $data['content'] = $parser->text(file_get_contents($mdPath));
        }

        if (self::validate($data)) {
            $page = new Page(
                $data['id'],
                $data['title'],
                $data['head'],
                $data['content']
            );
            return $page;
        }
    }

    public function __construct(string $id, string $title, string $head, string $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->head = $head;
        $this->content = $content;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \InvalidArgumentException
     */
    private static function validate(array $data): bool
    {
        if (!isset($data['id']) || !is_string($data['id'])) {
            throw new \InvalidArgumentException('Id not set or not string');
        }

        if (!isset($data['title']) || !is_string($data['title'])) {
            throw new \InvalidArgumentException('Title not set or not string');
        }

        if (!isset($data['head']) || !is_string($data['head'])) {
            throw new \InvalidArgumentException('Head not set or not string');
        }

        if (!isset($data['content']) || !is_string($data['content'])) {
            throw new \InvalidArgumentException('Content not set or not string');
        }

        return true;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getHead()
    {
        return $this->head;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getId()
    {
        return $this->id;
    }
}