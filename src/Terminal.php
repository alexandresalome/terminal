<?php

namespace Terminal;

use Terminal\Output\OutputInterface;
use Terminal\Output\StreamOutput;
use Terminal\Terminfo\Capabilities;
use Terminal\Terminfo\Capability\Color;
use Terminal\Terminfo\Capability\Cursor;
use Terminal\Terminfo\Capability\Screen;
use Terminal\Terminfo\Capability\Text;
use Terminal\Terminfo\Finder;

class Terminal
{
    use Color, Cursor, Screen, Text;

    private OutputInterface $output;
    private Capabilities $capabilities;
    private Vector $size;

    public function __construct(?Capabilities $capabilities = null, ?OutputInterface $output = null)
    {
        $this->capabilities = $capabilities ?? $this->guessCapabilities();
        $this->output = $output = $output ?? new StreamOutput();

        pcntl_signal(SIGWINCH, function () {
            $this->updateSize();
        });

        $this->updateSize();
    }

    public function write(string $text): void
    {
        $this->output->write($text);
        $this->output->flush();
    }

    public function writeln(string $text = ''): void
    {
        $this->output->write($text);
        $this->output->write("\n");
        $this->output->flush();
    }

    public function getSize(): Vector
    {
        return $this->size;
    }

    public function wait(int $milliseconds): void
    {
        $this->output->wait($milliseconds);
    }

    private function updateSize(): void
    {
        $lines = exec('tput lines');
        $cols = exec('tput cols');

        $this->size =  new Vector((int) $lines, (int) $cols);
    }

    private function guessCapabilities(): Capabilities
    {
        $finder = new Finder();

        return $finder->guess();
    }
}
