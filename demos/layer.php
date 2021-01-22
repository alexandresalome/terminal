<?php

namespace Main;

use Terminal\Layer;
use Terminal\Object\Box;
use Terminal\Terminal;
use Terminal\Vector;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();
$source = new Box(file_get_contents(__FILE__), position: new Vector(0, 30));
$message = 'Layer demo!';
$help = new Box(
    $message,
    position: new Vector(0, 0),
    size: new Vector($source->getSize()->x(), 26)
);
$layer = new Layer($terminal, new Vector(2, 2));
$layer->add($source);
$layer->add($help);
$layer->draw();
$terminal->cursorAddress([$help->getSize()->x() + 4, 2]);
$terminal->write($terminal->standout($terminal->blink('Press ENTER')));
fread(STDIN, 1);

register_shutdown_function(function () use ($terminal) {
    $terminal->cursorAddressingMode(false);
});
