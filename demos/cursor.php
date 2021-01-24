<?php

namespace Main;

use Terminal\Terminal;
use Terminal\Vector;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();

$terminal->withCursorAddressingMode(function () use ($terminal) {
    foreach([0, 1, 2, 3] as $x) {
        $terminal->cursorAddress([$x, $x]);
        $terminal->write("$x. Press ENTER to exit");
    }

    $terminal->cursorAddress(new Vector(10, 4));
    $terminal->write('TEXT IN THE MIDDLE');

    $terminal->cursorAddress(new Vector(5, 4));
    $terminal->write('Type any key: ');

    fread(STDIN, 1);
});
