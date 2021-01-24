<?php

namespace Main;

use Terminal\Terminal;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();

$colors = ["black", "red", "green", "yellow", "blue", "magenta", "cyan", "white"];

foreach ($colors as $foreground) {
    foreach ($colors as $background) {
        $terminal->setColor($foreground, $background);
        $terminal->write(' -- '.$foreground[0].$background[0].' -- ');
    }
    $terminal->resetColor();
    $terminal->writeln("");
}
