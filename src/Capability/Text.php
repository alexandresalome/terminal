<?php

namespace Terminal\Capability;

trait Text
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
