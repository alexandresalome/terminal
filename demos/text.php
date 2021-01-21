<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->writeln(
    'This is a rich text with usual features: '.
    $terminal->italic('italic').
    ', '.
    $terminal->bold('bold').
    ', '.
    $terminal->underline('underline').
    ', '.
    $terminal->blink('blink').
    ', '.
    $terminal->standout('standout').
    ', and many more soon!'
);
