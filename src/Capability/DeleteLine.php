<?php

namespace Terminal\Capability;

/**
 * Line deletion manipulations.
 */
trait DeleteLine
{
    public function canDeleteLine(): bool
    {
        return $this->configuration->has('delete_line');
    }

    /**
     * Delete current line and move the cursor at the beginning.
     */
    public function deleteLine(): void
    {
        if (!$this->configuration->has('delete_line')) {
            return;
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
        if (!$this->configuration->has('clr_bol')) {
            return;
        }

        $this->output->write($this->configuration->get('clr_bol'));
    }
}
