<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$content = file_get_contents(__FILE__);
$box = new Terminal\Object\Box($content);

$terminal->write($box);
