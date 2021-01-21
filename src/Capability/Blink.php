<?php

namespace Terminal\Capability;

trait Blink
{
    public function hasBlink(): bool
    {
        return $this->configuration->hasAll(['enter_blink_mode', 'exit_attribute_mode']);
    }

    public function blink(string $text): string
    {
        if (!$this->hasBlink()) {
            return $text;
        }

        return
            $this->configuration->get('enter_blink_mode').
            $text.
            $this->configuration->get('exit_attribute_mode')
        ;
    }

}
