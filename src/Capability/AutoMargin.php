<?php

namespace Terminal\Capability;

trait AutoMargin
{
    public function hasAutoMargin(): bool
    {
        return $this->configuration->hasAll(['enter_am_mode', 'exit_am_mode']);
    }

    /**
     * Auto margin wraps text to a newline if the cursor exceeds the end of
     * line.
     *
     * Without auto margin mode, at the end of line, the cursor move back to the
     * beginning of the same line.
     *
     * With auto margin mode, at the end of line, the cursor moves to the next
     * line.
     */
    public function autoMargin($enable = true): void
    {
        if (!$this->hasAutoMargin()) {
            return;
        }

        if ($enable) {
            $this->output->write($this->configuration->get('enter_am_mode'));
        } else {
            $this->output->write($this->configuration->get('exit_am_mode'));
        }
    }
}
