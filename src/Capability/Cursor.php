<?php

namespace Terminal\Capability;

use Terminal\Vector;

trait Cursor
{
    public function hasCursorVisible(): bool
    {
        return $this->configuration->hasAll(['cursor_visible', 'cursor_invisible']);
    }

    /**
     * Switches the visibility of the text cursor.
     */
    public function cursorVisible(bool $visible = true): void
    {
        if (!$this->hasCursorVisible()) {
            throw new \RuntimeException('Cursor visibility is unavailable.');
        }

        if ($visible) {
            $this->output->write($this->configuration->get('cursor_visible'));
        } else {
            $this->output->write($this->configuration->get('cursor_invisible'));
        }
    }

    public function cursorAddress($vector): void
    {
        $vector = Vector::create($vector);
        $value = $this->configuration->get('cursor_address');

        $this->output->write($this->configuration->getParameterized('cursor_address', [
            $vector->x(),
            $vector->y(),
        ]));
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
