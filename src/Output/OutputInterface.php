<?php

namespace Terminal\Output;

interface OutputInterface
{
    public function wait(int $milliseconds): void;
    public function write(string $text): void;
    public function flush(): void;
}
