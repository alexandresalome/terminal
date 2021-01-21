<?php

namespace Terminal;

use Terminal\Capability\Blink;
use Terminal\Capability\Bold;
use Terminal\Capability\ClearScreen;
use Terminal\Capability\CursorAddressing;
use Terminal\Capability\FlashScreen;
use Terminal\Capability\Italic;
use Terminal\Capability\Underline;

class Terminal
{
    use Blink;
    use Bold;
    use ClearScreen;
    use CursorAddressing;
    use FlashScreen;
    use Italic;
    use Underline;

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
