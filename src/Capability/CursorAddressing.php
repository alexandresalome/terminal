<?php

namespace Terminal\Capability;

trait CursorAddressing
{
    public function hasCursorAddressing(): bool
    {
        return $this->configuration->hasAll(['enter_ca_mode', 'exit_ca_mode']);
    }

    public function enterCursorAddressingMode(): void
    {
        if (!$this->hasCursorAddressing()) {
            return;
        }

        $this->output->write($this->configuration->get('enter_ca_mode'));
    }

    public function exitCursorAddressingMode(): void
    {
        if (!$this->hasCursorAddressing()) {
            return;
        }

        $this->output->write($this->configuration->get('exit_ca_mode'));
    }

    public function withCursorAddressingMode(callable $function)
    {
        $this->enterCursorAddressingMode();
        try {
            return $function();
        } finally {
            $this->exitCursorAddressingMode();
        }
    }
}
