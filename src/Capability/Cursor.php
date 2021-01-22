<?php

namespace Terminal\Capability;

use Terminal\Vector;

trait Cursor
{
    public function cursorAddress($vector): void
    {
        $vector = Vector::create($vector);
        $value = $this->configuration->get('cursor_address');

        $this->output->write(str_replace(
            ['%i%p1%d', '%p2%d'],
            [$vector->x(), $vector->y()],
            $value
        ));
        $this->output->flush();
    }

    public function hasCursorAddressingMode(): bool
    {
        return $this->configuration->hasAll(['enter_ca_mode', 'exit_ca_mode']);
    }

    public function cursorAddressingMode($cursorAddressingMode = true): void
    {
        if (!$this->hasCursorAddressingMode()) {
            throw new \RuntimeException('Cursor addressing mode is unavailable.');
        }

        if ($cursorAddressingMode) {
            $this->output->write($this->configuration->get('enter_ca_mode'));
        } else {
            $this->output->write($this->configuration->get('exit_ca_mode'));
        }
    }

    public function withCursorAddressingMode(callable $function, bool $clearScreen = true)
    {
        $this->cursorAddressingMode();
        if ($clearScreen) {
            $this->clearScreen();
        }

        try {
            return $function();
        } finally {
            $this->cursorAddressingMode(false);
        }
    }
}
