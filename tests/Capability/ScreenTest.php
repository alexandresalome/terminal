<?php

namespace Terminal\Tests\Capability;

use PHPUnit\Framework\TestCase;
use Terminal\Configuration;
use Terminal\Output\TestOutput;
use Terminal\Terminal;

class ScreenTest extends TestCase
{
    /**
     * @covers Screen::canFlashScreen
     * @covers Screen::flashScreen
     */
    public function testFlashScreen(): void
    {
        $output = new TestOutput();
        $config = new Configuration([
            'flash_screen' => '[flash]',
        ]);
        $terminal = new Terminal($config, $output);

        self::assertTrue($terminal->canFlashScreen());
        $terminal->flashScreen();
        self::assertEquals([
            ['write', '[flash]'],
            ['flush'],
        ], $output->getTestRecords());
    }

    /**
     * @covers Screen::canFlashScreen
     * @covers Screen::flashScreen
     */
    public function testFlashScreenUnavailable(): void
    {
        $output = new TestOutput();
        $config = new Configuration([]);
        $terminal = new Terminal($config, $output);
        self::assertFalse($terminal->canFlashScreen());

        $terminal->flashScreen();
        self::assertEmpty($output->getTestRecords());
    }
}
