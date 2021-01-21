<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();


$terminal->cursorVisible(false);
$terminal->writeln("Text cursor is now invisible.");
sleep(3);
$terminal->writeln("Cursor is visible again");
$terminal->cursorVisible();
sleep(2);
