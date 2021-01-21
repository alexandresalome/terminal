<?php

namespace Terminal\Capability;

/**
 * Screen features
 */
trait Screen
{
    public function canClearScreen(): bool
    {
        return $this->configuration->has('clear_screen');
    }

    public function clearScreen(): void
    {
        if (!$this->canClearScreen()) {
            return;
        }

        $this->output->write($this->configuration->get('clear_screen'));
    }

    public function canClearEndOfScreen(): bool
    {
        return $this->configuration->has('clr_eos');
    }

    public function clearEndOfScreen(): void
    {
        if (!$this->canClearEndOfScreen()) {
            return;
        }

        $this->output->write($this->configuration->get('clr_eos'));
    }

    public function canFlashScreen(): bool
    {
        return $this->configuration->hasAny(['bell', 'flash_screen']);
    }

    public function flashScreen(): void
    {
        if ($this->configuration->has('bell')) {
            $this->output->write($this->configuration->get('bell'));
            $this->output->flush();

            return;
        }

        if ($this->configuration->has('flash_screen')) {
            $this->output->write($this->configuration->get('flash_screen'));
            $this->output->flush();
        }
    }
}
