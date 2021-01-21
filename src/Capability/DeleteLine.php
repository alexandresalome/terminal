<?php

namespace Terminal\Capability;

/**
 * Delete the line under the text cursor.
 */
trait DeleteLine
{
    public function canDeleteLine(): bool
    {
        return $this->configuration->has('delete_line');
    }

    public function deleteLine(): void
    {
        if (!$this->configuration->has('delete_line')) {
            return;
        }

        $this->output->write($this->configuration->get('delete_line'));
    }
}
