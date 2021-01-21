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

$terminal->write($text);
$terminal->write((new Box($text))->render());

sleep(1);

$terminal->withCursorAddressingMode(function () use ($terminal) {
    $terminal->clearScreen();
    $terminal->write("Cursor addressing mode");
    sleep(1);
    $terminal->write((new Box('Coucou :)'))->render());
    sleep(1);
});
