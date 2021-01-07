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

    public function color(string $color, string $content, ?string $backgroundColor = null): string
    {
        dd('color');
    }
}
