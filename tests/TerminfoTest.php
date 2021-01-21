<?php

namespace Terminal\Tests;

use PHPUnit\Framework\TestCase;
use Terminal\Terminfo;

class TerminfoTest extends TestCase
{
    /**
     * @covers Terminfo::readFile
     */
    public function testReadFile(): void
    {
        $terminfo = new Terminfo();
        $config = $terminfo->readFile($this->getTerminfoFile('xterm-256color'));

        self::assertTrue($config->hasAll([
            'flash_screen',
            'clear_screen',
            'delete_line',
        ]));
    }

    private function getTerminfoFile(string $name): string
    {
        return dirname(__DIR__).'/data/terminfo/'.$name;
    }
}
