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
            throw new \RuntimeException('Clear screen is unavailable.');
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
            throw new \RuntimeException('Clear end of screen is unavailable.');
        }

        $this->output->write($this->configuration->get('clr_eos'));
    }
    public function canDeleteLine(): bool
    {
        return $this->configuration->has('delete_line');
    }

    /**
     * Delete current line and move the cursor at the beginning.
     */
    public function deleteLine(): void
    {
        if (!$this->canDeleteLine()) {
            throw new \RuntimeException('Delete line is unavailable.');
        }

        $this->output->write($this->configuration->get('delete_line'));
    }

    public function canClearBeginningOfLine(): bool
    {
        return $this->configuration->has('clr_bol');
    }

    /**
     * Clear text on current line before the cursor position and keep the cursor
     * at the same position.
     */
    public function clearBeginningOfLine(): void
    {
        if (!$this->canClearBeginningOfLine()) {
            throw new \RuntimeException('Clear beginning of line is unavailable.');
        }

        $this->output->write($this->configuration->get('clr_bol'));
    }

    public function canClearEndOfLine(): bool
    {
        return $this->configuration->has('clr_eol');
    }

    /**
     * Clear text on current line after the cursor position and keep the cursor
     * at the same position.
     */
    public function clearEndOfLine(): void
    {
        if (!$this->canClearEndOfLine()) {
            throw new \RuntimeException('Clear end of line is unavailable.');
        }

        $this->output->write($this->configuration->get('clr_eol'));
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

            return;
        }

        throw new \RuntimeException('Flash screen is unavailable.');
    }
}
