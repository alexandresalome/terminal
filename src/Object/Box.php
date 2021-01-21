<?php

namespace Terminal\Object;

use Terminal\Vector;

class Box
{
    public const BORDERS = [
        'ascii'       => ['+', '-', '+', '|', '|', '+', '-', '+'],
        'dashed'      => ['┌', '┄', '┐', '┊', '┊', '└', '┄', '┘'],
        'dashed_bold' => ['┏', '┅', '┓', '┋', '┋', '┗', '┅', '┛'],
        'thin'        => ['┌', '─', '┐', '│', '│', '└', '─', '┘'],
        'rounded'     => ['╭', '─', '╮', '│', '│', '╰', '─', '╯'],
        'double'      => ['╔', '═', '╗', '║', '║', '╚', '═', '╝'],
        'bold'        => ['┏', '━', '┓', '┃', '┃', '┗', '━', '┛'],
        'big'         => ['█', '▀', '█', '█', '█', '█', '▄', '█'],
        'very_big'    => ['█', '█', '█', '█', '█', '█', '█', '█'],
    ];

    /** @var string[] */
    private array $content;
    private ?array $borders;
    private Vector $size;

    public function __construct(string $content, ?array $borders = null, ?Vector $size = null)
    {
        $this->lines = explode("\n", $content);
        $this->borders = $borders ?: self::BORDERS['thin'];
        $this->size = $size ?? $this->computeSize($content);
    }

    public function __toString(): string
    {
        $leftBorder = $this->borders[3].' ';
        $borderMargin = 2;
        $rightBorder = ' '.$this->borders[4];

        $result = $this->borders[0].str_repeat($this->borders[1], $this->size->y + $borderMargin).$this->borders[2]."\n";

        for ($i = 0; $i < $this->size->x; $i++) {
            $line = $this->lines[$i] ?? '';
            $result .=
                $leftBorder.
                $line.
                str_repeat(" ", $this->size->y - mb_strlen($line)).
                $rightBorder.
                "\n"
            ;
        }

        $result .= $this->borders[5].str_repeat($this->borders[6], $this->size->y + $borderMargin).$this->borders[7]."\n";

        return $result;
    }

    private function computeSize(string $content): Vector
    {
        $width = max(array_map('mb_strlen', $this->lines));

        return new Vector(count($this->lines), $width);
    }
}
