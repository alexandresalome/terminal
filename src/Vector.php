<?php

namespace Terminal;

class Vector
{
    public $x = null;
    public $y = null;

    public function __construct($x = null, $y = null)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function create(mixed $vector): Vector
    {
        if (null === $vector) {
            return new Vector();
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

    public function x(): int
    {
        if (!is_int($this->x)) {
            throw new \RuntimeException(sprintf(
                'Value X "%s" is not resolved.',
                $this->x
            ));
        }

        return $this->x;
    }

    public function y(): int
    {
        if (!is_int($this->y)) {
            throw new \RuntimeException(sprintf(
                'Value Y "%s" is not resolved.',
                $this->y
            ));
        }

        return $this->y;
    }

    public static function zero(): Vector
    {
        return new self(0, 0);
    }

    public function withX(int $x): Vector
    {
        return new self($x, $this->y);
    }

    public function withY(int $y): Vector
    {
        return new self($this->x, $y);
    }
}
