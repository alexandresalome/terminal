<?php

require_once __DIR__.'/vendor/autoload.php';

Symfony\Component\ErrorHandler\ErrorHandler::register();

$terminal = new Terminal\Terminal();
$terminal->flashScreen();
$terminal->clearScreen();
