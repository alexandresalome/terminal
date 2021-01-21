<?php

namespace Terminal\Capability;

trait Bold
{
    public function hasBold(): bool
    {
        return $this->configuration->hasAll(['enter_bold_mode', 'exit_attribute_mode']);
    }

    public function bold(string $text): string
    {
        if (!$this->hasBold()) {
            return $text;
        }

        return
            $this->configuration->get('enter_bold_mode').
            $text.
            $this->configuration->get('exit_attribute_mode')
        ;
    }
}
