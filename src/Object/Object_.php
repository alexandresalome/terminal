<?php

namespace Terminal\Object;

use Terminal\Vector;

abstract class Object_
{
    private bool $changed = false;
    private Vector $position;
    private Vector $size;

    public function __construct(mixed $position = null, mixed $size = null)
    {
        $this->position = Vector::create($position);
        $this->size = Vector::create($size);
    }

    /** @return string[] */
    abstract public function render(): array;

    public function getPosition(): Vector
    {
        return $this->position;
    }

    public function getSize(): Vector
    {
        return $this->size;
    }

    public function setSize(Vector $newSize): void
    {
        $this->changed = true;
        $this->size = $newSize;
    }

    protected function setChanged(bool $changed = true): void
    {
        $this->changed = true;
    }

    public function hasChanged(): bool
    {
        return $this->changed;
    }

    public function __toString(): string
    {
        return implode("\n", $this->render())."\n";
    }
}
