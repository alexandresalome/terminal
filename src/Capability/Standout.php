<?php

namespace Terminal\Capability;

trait Standout
{
    public function hasStandout(): bool
    {
        return $this->configuration->hasAll(['enter_standout_mode', 'exit_standout_mode']);
    }

    public function standout(string $text): string
    {
        if (!$this->hasStandout()) {
            return $text;
        }

        return
            $this->configuration->get('enter_standout_mode').
            $text.
            $this->configuration->get('exit_standout_mode')
        ;
    }
}
