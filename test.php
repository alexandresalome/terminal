<?php

require_once __DIR__.'/vendor/autoload.php';

Symfony\Component\ErrorHandler\ErrorHandler::register();

use Terminal\Object\Box;

$terminal = new Terminal\Terminal();
$terminal->flashScreen();
$terminal->clearScreen();

$box = new Box(file_get_contents(__FILE__));

$terminal->write($box->render());
