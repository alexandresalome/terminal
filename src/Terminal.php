<?php

namespace Terminal;

use Terminal\Capabilities\Terminfo;

class Terminal
{
    private Capabilities $cap;
    private array $windows = [];

    public function __construct()
    {
        $terminfo = new Terminfo();
        $this->cap = $terminfo->guess();
    }

    public function getCapabilities(): Capabilities
    {
        return $this->cap;
    }

    public function write(string $text): void
    {
        fwrite(STDOUT, $text);
    }

    public function writeln(string $text): void
    {
        fwrite(STDOUT, $text."\n");
    }

    public function flush(): void
    {
        fflush(STDOUT);
    }

    public function canFlashScreen(): bool
    {
        return $this->cap->hasAny(['bell', 'flash_screen']);
    }

    public function flashScreen(): void
    {
        $cap = $this->cap;

        if ($cap->has('bell')) {
            $this->write($cap->get('bell'));
            $this->flush();

            return;
        }

        if ($cap->has('flash_screen')) {
            $this->write($cap->get('flash_screen'));
            $this->flush();

            return;
        }

        throw new \RuntimeException('No capability to flash the screen.');
    }

    public function canClearScreen(): bool
    {
        return $this->cap->has('clear_screen');
    }

    public function clearScreen(): void
    {
        $cap = $this->cap;
        if ($cap->has('clear_screen')) {
            $this->write($cap->get('clear_screen'));
            $this->flush();

            return;
        }

        throw new \RuntimeException('No capability to clear the screen.');
    }

    public function hasItalic(): bool
    {
        return $this->cap->hasAll(['enter_italics_mode', 'exit_italics_mode']);
    }

    public function italic(string $text): string
    {
        if (!$this->hasItalic()) {
            return $text;
        }

        return
            $this->cap->get('enter_italics_mode').
            $text.
            $this->cap->get('exit_italics_mode')
        ;
    }

    public function hasUnderline(): bool
    {
        return $this->cap->hasAll(['enter_underline_mode', 'exit_underline_mode']);
    }

    public function underline(string $text): string
    {
        if (!$this->hasUnderline()) {
            return $text;
        }

        return
            $this->cap->get('enter_underline_mode').
            $text.
            $this->cap->get('exit_underline_mode')
            ;
    }

    public function hasBold(): bool
    {
        return $this->cap->hasAll(['enter_bold_mode', 'exit_attribute_mode']);
    }

    public function bold(string $text): string
    {
        if (!$this->hasBold()) {
            return $text;
        }

        return
            $this->cap->get('enter_bold_mode').
            $text.
            $this->cap->get('exit_attribute_mode')
            ;
    }

    public function hasBlink(): bool
    {
        return $this->cap->hasAll(['enter_blink_mode', 'exit_attribute_mode']);
    }

    public function blink(string $text): string
    {
        if (!$this->hasBlink()) {
            return $text;
        }

        return
            $this->cap->get('enter_blink_mode').
            $text.
            $this->cap->get('exit_attribute_mode')
            ;
    }

    public function hasCursorAddressing(): bool
    {
        return $this->cap->hasAll(['enter_ca_mode', 'exit_ca_mode']);
    }

    public function enterCursorAddressingMode(): void
    {
        if (!$this->hasCursorAddressing()) {
            return;
        }

        $this->write($this->cap->get('enter_ca_mode'));
    }

    public function exitCursorAddressingMode(): void
    {
        if (!$this->hasCursorAddressing()) {
            return;
        }

        $this->write($this->cap->get('exit_ca_mode'));
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
