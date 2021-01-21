<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->write("Text");
sleep(1);
$terminal->clearBeginningOfLine();
$terminal->writeln('Beginning of line cleared');
sleep(1);
$terminal->write("Other text\n");
$terminal->clearEndOfLine();
$terminal->writeln('End of line cleared');
sleep(1);
sleep(1);
$terminal->deleteLine();
$terminal->write('Line deleted');
