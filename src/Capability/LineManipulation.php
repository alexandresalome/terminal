<?php

namespace Terminal\Capability;

/**
 * Line manipulations.
 */
trait LineManipulation
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
        if (!$this->canDeleteLine()) {
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
        if (!$this->canClearBeginningOfLine()) {
            return;
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
        if (!$this->canClearBeginningOfLine()) {
            return;
        }

        $this->output->write($this->configuration->get('clr_eol'));
    }
}
