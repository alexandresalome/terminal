<?php

namespace Terminal;

/**
 * This class hold the Terminal capabilities, using terminfo identifiers.
 */
class Configuration implements \IteratorAggregate
{
    private array $values;
    private TerminfoExpression $terminfoExpression;

    public function __construct(array $values = [])
    {
        $this->values = $values;
        $this->terminfoExpression = new TerminfoExpression();
    }

    public function get(string $name): string
    {
        if (!array_key_exists($name, $this->values)) {
            throw new \InvalidArgumentException(sprintf('No value named "%s".', $name));
        }

        return $this->values[$name];
    }

    public function getParameterized(string $name, array $parameters): string
    {
        return $this->terminfoExpression->evaluate($this->get($name), $parameters);
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

    public function hasAll(array $names): bool
    {
        foreach ($names as $name) {
            if (!array_key_exists($name, $this->values)) {
                return false;
            }
        }

        return true;
    }

    public function getIterator(): \Traversable
    {
        foreach ($this->values as $name => $value) {
            yield $name => $value;
        }
    }
}
