<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->write("Text");
sleep(1);
$terminal->clearBeginningOfLine();
$terminal->writeln('Beginning of line cleared');
sleep(1);
$terminal->write("Other text");
sleep(1);
$terminal->deleteLine();
$terminal->write('Line deleted');
