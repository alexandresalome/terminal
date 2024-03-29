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
    size: new Vector($source->getSize()->lines(), 26)
);
$layer = new Layer($terminal, new Vector(2, 2));
$layer->add($source);
$layer->add($help);
$layer->draw();
stream_set_blocking(STDIN, false);
$size = 2;
$char = '';
$max = $source->getSize()->lines();
while ($char === '') {
    $size = ($size + 1) % $max;
    $help->setSize($help->getSize()->withLines($size));
    $terminal->clearScreen();
    $layer->draw();
    $terminal->cursorAddress([$source->getSize()->lines() + 4, 2]);
    $terminal->write($terminal->standout($terminal->blink('Press ENTER')));
    $char = fread(STDIN, 1);
    usleep(100000);
}

register_shutdown_function(function () use ($terminal) {
    $terminal->cursorAddressingMode(false);
});
