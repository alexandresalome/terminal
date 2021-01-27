<?php

namespace Terminal\Terminfo\Capability;

use Terminal\Output\OutputInterface;
use Terminal\Terminfo\Capabilities;

/**
 * @property Capabilities $capabilities
 * @property OutputInterface $output
 */
trait Screen
{
    public function canClearScreen(): bool
    {
        return $this->capabilities->has('clear_screen');
    }

    public function clearScreen(): void
    {
        if (!$this->canClearScreen()) {
            throw new \RuntimeException('Clear screen is unavailable.');
        }

        $this->output->write($this->capabilities->get('clear_screen'));
    }

    public function canClearEndOfScreen(): bool
    {
        return $this->capabilities->has('clr_eos');
    }

    public function clearEndOfScreen(): void
    {
        if (!$this->canClearEndOfScreen()) {
            throw new \RuntimeException('Clear end of screen is unavailable.');
        }

        $this->output->write($this->capabilities->get('clr_eos'));
    }
    public function canDeleteLine(): bool
    {
        return $this->capabilities->has('delete_line');
    }

    /**
     * Delete current line and move the cursor at the beginning.
     */
    public function deleteLine(): void
    {
        if (!$this->canDeleteLine()) {
            throw new \RuntimeException('Delete line is unavailable.');
        }

        $this->output->write($this->capabilities->get('delete_line'));
    }

    public function canClearBeginningOfLine(): bool
    {
        return $this->capabilities->has('clr_bol');
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

        $this->output->write($this->capabilities->get('clr_bol'));
    }

    public function canClearEndOfLine(): bool
    {
        return $this->capabilities->has('clr_eol');
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

        $this->output->write($this->capabilities->get('clr_eol'));
    }

    public function canFlashScreen(): bool
    {
        return $this->capabilities->hasAny(['bell', 'flash_screen']);
    }

    public function flashScreen(): void
    {
        if ($this->capabilities->has('bell')) {
            $this->output->write($this->capabilities->get('bell'));
            $this->output->flush();

            return;
        }

        if ($this->capabilities->has('flash_screen')) {
            $this->output->write($this->capabilities->get('flash_screen'));
            $this->output->flush();

            return;
        }

        throw new \RuntimeException('Flash screen is unavailable.');
    }
}
