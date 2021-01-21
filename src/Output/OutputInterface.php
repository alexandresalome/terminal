<?php

namespace Terminal\Output;

interface OutputInterface
{
    public function write(string $text): void;
    public function flush(): void;
}
