<?php

namespace Terminal\Capability;

/**
 * Automatic margin consists of wrapping text to a newline if cursor exceeds the
 * end of the line.
 */
trait AutoMargin
{
    public function hasAutoMargin(): bool
    {
        return $this->configuration->hasAll(['enter_am_mode', 'exit_am_mode']);
    }

    public function enterAutoMarginMode(): void
    {
        if (!$this->hasAutoMargin()) {
            return;
        }

        $this->output->write($this->configuration->get('enter_am_mode'));
    }

    public function exitAutoMarginMode(): void
    {
        if (!$this->hasAutoMargin()) {
            return;
        }

        $this->output->write($this->configuration->get('exit_am_mode'));
    }

    public function withAutoMarginMode(callable $function)
    {
        $this->enterAutoMarginMode();
        try {
            return $function();
        } finally {
            $this->exitAutoMarginMode();
        }
    }

    public function withoutAutoMarginMode(callable $function)
    {
        $this->exitAutoMarginMode();
        try {
            return $function();
        } finally {
            $this->enterAutoMarginMode();
        }
    }
}
