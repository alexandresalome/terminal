<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$terminal->withCursorAddressingMode(function () use ($terminal) {
    $terminal->write("This is addressing mode. Press ENTER to exit");

    fread(STDIN, 1);
});
