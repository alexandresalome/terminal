<?php

namespace Terminal\Dev\Output;

use Terminal\Output\OutputInterface;

class TestOutput implements OutputInterface
{
    private array $records = [];

    public function wait(int $milliseconds): void
    {
        $this->records[] = ['wait', $milliseconds];
    }

    public function write(string $text): void
    {
        $this->records[] = ['write', $text];
    }

    public function flush(): void
    {
        $this->records[] = ['flush'];
    }

    public function getTestRecords(bool $flush = true): array
    {
        $records = $this->records;
        if ($flush) {
            $this->records = [];
        }

        return $records;
    }
}
