<?php

namespace Terminal\Capability;

/**
 * Clean the terminal screen.
 */
trait ClearScreen
{
    public function canClearScreen(): bool
    {
        return $this->configuration->has('clear_screen');
    }

    public function clearScreen(): void
    {
        if (!$this->configuration->has('clear_screen')) {
            return;
        }

        $this->output->write($this->configuration->get('clear_screen'));
    }
}
