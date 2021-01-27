<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->writeln(new Terminal\Object\Box('Auto-margin'));

$terminal->autoMargin();
$terminal->writeln('This line as auto-magin enabled. At the end of the screen, it goes to next line automatically.');
$terminal->writeln();

$terminal->autoMargin(false);
$terminal->writeln('Disabled: The line continues on the right of the screen');
$terminal->writeln();

$terminal->autoMargin();
$terminal->writeln('The paragraph above is partially displayed because auto-margin has been disabled.');
$terminal->writeln();
