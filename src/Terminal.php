<?php

namespace Terminal;

class Terminal
{
    use Capability\AutoMargin;
    use Capability\ClearScreen;
    use Capability\CursorAddressing;
    use Capability\DeleteLine;
    use Capability\FlashScreen;
    use Capability\Text;

    private Configuration $configuration;
    private Output $output;

    public function __construct()
    {
        $this->configuration = (new Terminfo())->guess();
        $this->output = new Output();
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
