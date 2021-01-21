<?php

require_once __DIR__.'/vendor/autoload.php';

Symfony\Component\ErrorHandler\ErrorHandler::register();

use Terminal\Object\Box;

$terminal = new Terminal\Terminal();
$terminal->flashScreen();

$text =
    'This is a rich text with usual features: '.
    $terminal->italic('italic').
    ', '.
    $terminal->bold('bold').
    ', '.
    $terminal->underline('underline').
    ', '.
    $terminal->blink('blink').
    ', and many more soon!'
;

$terminal->withCursorAddressingMode(function () use ($terminal, $text) {
    $terminal->deleteLine();
    $terminal->clearScreen();
    $terminal->write("Cursor addressing mode");
    $terminal->write((new Box($text))->render());
    sleep(5);
});
