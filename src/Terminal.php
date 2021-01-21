<?php

namespace Terminal;

class Terminal
{
    use Capability\AutoMargin;
    use Capability\Blink;
    use Capability\Bold;
    use Capability\ClearScreen;
    use Capability\CursorAddressing;
    use Capability\DeleteLine;
    use Capability\FlashScreen;
    use Capability\Italic;
    use Capability\Standout;
    use Capability\Underline;

    private Configuration $configuration;
    private Output $output;

    public function __construct()
    {
        $this->configuration = (new Terminfo())->guess();
        $this->output = new Output();
    }

    public function write(string $text, bool $newline = true): void
    {
        $this->output->write($text);
        if ($newline) {
            $this->output->write("\n");
        }
    }
}
