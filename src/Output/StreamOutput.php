<?php

namespace Terminal\Output;

class StreamOutput implements OutputInterface
{
    private $stream;

    public function __construct($stream = null)
    {
        $this->stream = $stream ?? STDOUT;
    }

    public function write(string $text): void
    {
        fwrite($this->stream, $text);
    }

    public function flush(): void
    {
        fflush($this->stream);
    }
}
