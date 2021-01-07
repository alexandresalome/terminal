<?php

namespace Terminal;

class Capabilities implements \IteratorAggregate
{
    private array $values;

    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    public function get(string $name): string
    {
        if (!array_key_exists($name, $this->values)) {
            throw new \InvalidArgumentException(sprintf('No value named "%s".', $name));
        }

        return $this->values[$name];
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->values);
    }

    public function hasAny(array $names): bool
    {
        foreach ($names as $name) {
            if (array_key_exists($name, $this->values)) {
                return true;
            }
        }

        return false;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->values as $name => $value) {
            yield $name => $value;
        }
    }
}
