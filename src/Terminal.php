<?php

namespace Terminal;

use Terminal\Output\OutputInterface;
use Terminal\Output\StreamOutput;

class Terminal
{
    use Capability\AutoMargin;
    use Capability\Cursor;
    use Capability\CursorVisibility;
    use Capability\LineManipulation;
    use Capability\Screen;
    use Capability\Text;

    private Configuration $configuration;
    private OutputInterface $output;

    public function __construct(?Configuration $configuration = null, ?OutputInterface $output = null)
    {
        $this->configuration = $configuration ?? (new Terminfo())->guess();
        $this->output = $output ?? new StreamOutput();
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
}
