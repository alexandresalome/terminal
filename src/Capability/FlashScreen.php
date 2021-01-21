<?php

namespace Terminal\Capability;

/**
 * Produces a signal on user's terminal.
 */
trait FlashScreen
{
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
