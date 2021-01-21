<?php

namespace Main;

use Terminal\Object\Box;
use Terminal\Terminal;
use Terminal\Vector;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();

$box = new Box(file_get_contents(__FILE__));
$terminal->write($box);

$box = new Box('Custom size', size: new Vector(3, 30));
$terminal->write($box);

foreach (['rounded', 'double', 'ascii'] as $style) {
    $box = new Box($style, Box::BORDERS[$style]);
    $terminal->writeln($box);
}
