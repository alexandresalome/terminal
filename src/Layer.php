<?php

namespace Terminal;

use Terminal\Object\Object_;

class Layer
{
    private bool $changed = true;
    /** @var Object_[] */
    private array $objects = [];
    private Vector $origin;
    private Terminal $terminal;

    public function __construct(Terminal $terminal, mixed $origin = null, array $objects = [], bool $cursorAddressing = true)
    {
        $this->terminal = $terminal;
        $this->origin = Vector::create($origin);
        if ($cursorAddressing && !$this->terminal->hasCursorAddressingMode()) {
            throw new \RuntimeException('Terminal does not support cursor addressing mode');
        }

        $this->terminal->cursorAddressingMode();
        $this->terminal->clearScreen();
    }

    public function add(Object_ $object): void
    {
        $this->objects[] = $object;
        $this->changed = true;
    }

    public function draw(bool $force = false): void
    {
        $changed = false;
        foreach ($this->objects as $object) {
            if ($force || $this->changed || $object->hasChanged()) {
                $changed = true;
            }

            if ($changed === false) {
                continue;
            }

            $objectPosition = $object->getPosition();

            $i = 0;
            foreach ($object->render() as $line) {
                $this->terminal->cursorAddress([
                    $this->origin->x() + $objectPosition->x() + $i,
                    $this->origin->y() + $objectPosition->y(),
                ]);
                $i++;
                $this->terminal->write($line);
            }
        }
    }
}
