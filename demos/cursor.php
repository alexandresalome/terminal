<?php

namespace Main;

use Terminal\Terminal;
use Terminal\Vector;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();

$terminal->withCursorAddressingMode(function () use ($terminal) {
    $terminal->write("This is addressing mode. Press ENTER to exit");

    $terminal->cursorAddress(new Vector(10, 4));
    $terminal->write('TEXT IN THE MIDDLE');

    $terminal->cursorAddress(new Vector(3, 4));
    $terminal->write('Type any key: ');

    fread(STDIN, 1);
});
