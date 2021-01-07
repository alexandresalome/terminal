<?php

namespace Terminal\Object;

class Box
{
    public const BORDERS = [
        'ascii'       => ['+', '-', '+', '|', '|', '+', '-', '+'],
        'dashed'      => ['┌', '┄', '┐', '┊', '┊', '└', '┄', '┘'],
        'dashed_bold' => ['┏', '┅', '┓', '┋', '┋', '┗', '┅', '┛'],
        'thin'        => ['┌', '─', '┐', '│', '│', '└', '─', '┘'],
        'double'      => ['╔', '═', '╗', '║', '║', '╚', '═', '╝'],
        'bold'        => ['┏', '━', '┓', '┃', '┃', '┗', '━', '┛'],
        'half'        => ['█', '▀', '█', '█', '█', '█', '▄', '█'],
        'full'        => ['█', '█', '█', '█', '█', '█', '█', '█'],
    ];

    private string $content;
    private ?array $borders;

    public function __construct(string $content, ?array $borders = null)
    {
        $this->content = $content;
        $this->borders = $borders ?: self::BORDERS['thin'];
    }

    public function render(): string
    {
        $lines = explode("\n", $this->content);
        $width = max(array_map('mb_strlen', $lines));

        $leftBorder = $this->borders[3].' ';
        $borderMargin = 2;
        $rightBorder = ' '.$this->borders[4];

        $result = $this->borders[0].str_repeat($this->borders[1], $width + $borderMargin).$this->borders[2]."\n";

        foreach ($lines as $line) {
            $result .= $leftBorder.$line.str_repeat(" ", $width - mb_strlen($line)).$rightBorder."\n";
        }

        $result .= $this->borders[5].str_repeat($this->borders[6], $width + $borderMargin).$this->borders[7]."\n";

        return $result;
    }
}
