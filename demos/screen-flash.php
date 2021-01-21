<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->flashScreen();
$terminal->writeln("Screen flashed");
