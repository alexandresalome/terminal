<?php

use Terminal\Terminal;

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal();

$terminal->writeln(
    'This is a rich text with usual features: '.
    $terminal->italic('italic').
    ', '.
    $terminal->bold('bold').
    ', '.
    $terminal->underline('underline').
    ', '.
    $terminal->blink('blink').
    ', '.
    $terminal->standout('standout').
    ', and many more soon!'
);

$terminal->writeln();

function renderOne(Terminal $terminal, array $choices): void {
    $text = 'x';

    foreach ($choices as $choice) {
        $text = sprintf('%s < %s', $text, $choice);
        $text = $terminal->$choice($text);
    }
    $terminal->writeln($text);
}

function getAllOrders(array $choices): iterable {
    $count = count($choices);

    if ($count === 0) {
        return;
    }

    if ($count === 1) {
        yield $choices;

        return;
    }

    foreach ($choices as $selected => $choice) {
        $others = array_merge(
            array_slice($choices, 0, $selected),
            $selected === $count - 1 ? [] : array_slice($choices, $selected + 1)
        );

        foreach (getAllOrders($others) as $other) {
            yield array_merge([$choice], $other);
        }
    }
}

$choices = [
    'bold',
    'italic',
    'underline',
    'blink',
    'standout',
];

$count = count($choices);
$total = 2 ** $count; // ** = pow()
for ($i = 1; $i < $total; $i++) {
    $selected = [];
    foreach ($choices as $position => $choice) {
        $active = ($i >> $position) % 2;
        if ($active) {
            $selected[] = $choice;
        }
    }

    foreach (getAllOrders($selected) as $choice) {
        renderOne($terminal, $choice);
    }
}
