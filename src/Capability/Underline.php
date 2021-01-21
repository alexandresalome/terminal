<?php

namespace Terminal\Capability;

use Terminal\Configuration;

trait Underline
{
    public function hasUnderline(): bool
    {
        return $this->configuration->hasAll(['enter_underline_mode', 'exit_underline_mode']);
    }

    public function underline(string $text): string
    {
        if (!$this->hasUnderline()) {
            return $text;
        }

        return
            $this->configuration->get('enter_underline_mode').
            $text.
            $this->configuration->get('exit_underline_mode')
        ;
    }
}
