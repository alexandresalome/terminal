<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->clearScreen();
$terminal->writeln("Screen cleared");
sleep(1);
$terminal->write("Some text, moving cursor back\r");
sleep(1);
$terminal->clearEndOfScreen();
$terminal->writeln("End of screen cleared, too");
