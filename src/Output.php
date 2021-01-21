<?php

namespace Terminal;

class Output
{
    public function write(string $text): void
    {
        fwrite(STDOUT, $text);
    }

    public function flush(): void
    {
        fflush(STDOUT);
    }
}
