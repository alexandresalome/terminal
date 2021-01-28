<?php

namespace Main;

use Symfony\Component\Finder\Finder;
use Terminal\Dev\Documentation\GifMaker;

require_once __DIR__.'/../vendor/autoload.php';

$finder = Finder::create()
    ->in(__DIR__.'/../docs')
    ->name('*.md')
;

$renderer = new GifMaker(
    dirname(__DIR__).'/docs',
    '_gifs',
);

foreach ($finder as $file) {
    $renderer->makeGifs($file->getRealPath());
}
