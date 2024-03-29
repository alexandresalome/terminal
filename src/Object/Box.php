<?php

namespace Terminal\Object;

use Terminal\Vector;

class Box extends Object_
{
    public const BORDERS = [
        'ascii' => ['+', '-', '+', '|', '|', '+', '-', '+'],
        'dashed' => ['┌', '┄', '┐', '┊', '┊', '└', '┄', '┘'],
        'dashed_bold' => ['┏', '┅', '┓', '┋', '┋', '┗', '┅', '┛'],
        'thin' => ['┌', '─', '┐', '│', '│', '└', '─', '┘'],
        'rounded' => ['╭', '─', '╮', '│', '│', '╰', '─', '╯'],
        'double' => ['╔', '═', '╗', '║', '║', '╚', '═', '╝'],
        'bold' => ['┏', '━', '┓', '┃', '┃', '┗', '━', '┛'],
        'big' => ['█', '▀', '█', '█', '█', '█', '▄', '█'],
        'very_big' => ['█', '█', '█', '█', '█', '█', '█', '█'],
    ];

    /** @var string[] */
    private array $lines;
    private ?array $borders;

    public function __construct(string $content, ?array $borders = null, array $colors = [], $position = null, $size = null)
    {
        $this->lines = explode("\n", $content);
        $this->borders = $borders ?? self::BORDERS['bold'];
        parent::__construct($position, $size ?? $this->computeSize());

    }

    public function render(): array
    {
        $size = $this->getSize();
        $leftBorder = $this->borders[3] . ' ';
        $borderMargin = 2;
        $rightBorder = ' ' . $this->borders[4];

        $result = [$this->borders[0] . str_repeat($this->borders[1], $size->columns() + $borderMargin) . $this->borders[2]];

        for ($i = 0; $i < $size->lines(); $i++) {
            $line = $this->lines[$i] ?? '';
            $result[] =
                $leftBorder.
                $line.
                str_repeat(" ", $size->columns() - mb_strlen($line)).
                $rightBorder
            ;
        }

        $result []= $this->borders[5] . str_repeat($this->borders[6], $size->columns() + $borderMargin) . $this->borders[7];

        return $result;
    }

    private function computeSize(): Vector
    {
        $width = max(array_map('mb_strlen', $this->lines));

        return new Vector(count($this->lines), $width);
    }
}
