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
            throw new \RuntimeException('Blink is unavailable.');
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
            throw new \RuntimeException('Bold is unavailable.');
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
            throw new \RuntimeException('Italic is unavailable.');
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
            throw new \RuntimeException('Standout is unavailable.');
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
            throw new \RuntimeException('Underline is unavailable.');
        }

        return
            $this->configuration->get('enter_underline_mode').
            $text.
            $this->configuration->get('exit_underline_mode')
            ;
    }

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
            throw new \RuntimeException('Auto margin is unavailable.');
        }

        if ($enable) {
            $this->output->write($this->configuration->get('enter_am_mode'));
        } else {
            $this->output->write($this->configuration->get('exit_am_mode'));
        }
    }
}
