<?php
declare(strict_types=1);

namespace WineCalc\Calculator\Partials;

final class Step
{
    /**
     * @var null|string
     */
    private $title;
    /**
     * @var array
     */
    private $text;

    public function __construct(?string $title, array $lines)
    {
        $this->title = empty($title) ? null : $title;
        $this->text = implode(' ', $lines);
    }

    function toArray(): array
    {
        return [
            'title' => $this->title,
            'text' => $this->text
        ];
    }
}