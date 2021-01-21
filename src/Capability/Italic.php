<?php

namespace Terminal\Capability;

trait Italic
{
    public function hasItalic(): bool
    {
        return $this->configuration->hasAll(['enter_italics_mode', 'exit_italics_mode']);
    }

    public function italic(string $text): string
    {
        if (!$this->hasItalic()) {
            return $text;
        }

        return
            $this->configuration->get('enter_italics_mode').
            $text.
            $this->configuration->get('exit_italics_mode')
            ;
    }
}
