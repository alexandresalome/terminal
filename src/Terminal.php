<?php

namespace Terminal;

use Terminal\Output\OutputInterface;
use Terminal\Output\StreamOutput;

class Terminal
{
    use Capability\Color;
    use Capability\Cursor;
    use Capability\Screen;
    use Capability\Text;

    private Configuration $configuration;
    private OutputInterface $output;
    private Vector $size;

    public function __construct(?Configuration $configuration = null, ?OutputInterface $output = null)
    {
        $this->configuration = $configuration ?? (new Terminfo())->guess();
        $this->output = $output ?? new StreamOutput();

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

    public function writeln(string $text): void
    {
        $this->output->write($text);
        $this->output->write("\n");
        $this->output->flush();
    }

    private function updateSize(): void
    {
        $lines = exec('tput lines');
        $cols = exec('tput cols');

        $this->size =  new Vector((int) $lines, (int) $cols);
    }
}
