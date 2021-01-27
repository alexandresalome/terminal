<?php

namespace Main;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Terminal\Dev\Markdown\ExampleRenderer;

require_once __DIR__.'/../vendor/autoload.php';

$finder = Finder::create()
    ->in(__DIR__.'/../docs')
    ->name('*.md')
;

$renderer = new ExampleRenderer();

foreach ($finder as $file) {
    $renderer->render($file->getRealPath());
}
