<?php

namespace Terminal;

class Vector
{
    private int $lines;
    private int $columns;

    public function __construct(int $lines, int $columns)
    {
        $this->lines = $lines;
        $this->columns = $columns;
    }

    public static function create(mixed $vector): Vector
    {
        if (null === $vector) {
            return new Vector(0, 0);
        }

        if ($vector instanceof self) {
            return $vector;
        }

        if (is_array($vector) && isset($vector[0], $vector[1])) {
            return new Vector($vector[0], $vector[1]);
        }

        throw new \InvalidArgumentException(sprintf(
            'Unable to create Vector from a "%s".',
            is_object($vector) ? get_class($vector) : strtolower(gettype($vector))
        ));
    }

    public function lines(): int
    {
        return $this->lines;
    }

    public function columns(): int
    {
        return $this->columns;
    }

    public static function zero(): Vector
    {
        return new self(0, 0);
    }

    public function withLines(int $lines): Vector
    {
        return new self($lines, $this->columns);
    }

    public function withColumns(int $columns): Vector
    {
        return new self($this->lines, $columns);
    }
}
