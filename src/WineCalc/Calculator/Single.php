<?php
declare(strict_types=1);

namespace WineCalc\Calculator;

use WineCalc\Calculator\Partials\Step;

final class Single
{
    /** @var string */
    private $title;

    /** @var string */
    private $head;

    /** @var Step[] */
    private $steps;

    /** @var string */
    private $id;

    public function __construct(string $id, array $data)
    {
        $this->validate($data);
        $this->title = $data['title'];
        $this->head = implode(' ', $data['head']);
        $this->steps = array_map(
            function (array $step): Step {
                return new Step($step['title'] ?? null, $step['text']);
            },
            $data['steps']
        );
        $this->id = $id;
    }

    /**
     * @param string $filename
     * @return Single
     */
    public static function parse(string $filename): Single
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new \RuntimeException('File '.$filename.' not exists or is not readable');
        }

        $data = json_decode(file_get_contents($filename), true);
        if ($data === false) {
            throw new \RuntimeException('Error reading json file ('.$filename.'): '.json_last_error_msg());
        }

        $id = pathinfo($filename, PATHINFO_FILENAME);

        return new self($id, $data);
    }

    private function validate(array $data)
    {
    }

    /**
     * @return string
     */
    public function getHead(): string
    {
        return $this->head;
    }

    public function getSteps(): array
    {
        return array_map(
            function (Step $step): array {
                return $step->toArray();
            },
            $this->steps
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}