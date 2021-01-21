<?php

require_once __DIR__.'/../vendor/autoload.php';

$terminal = new Terminal\Terminal();

$paragraph = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum feugiat orci ac ante sollicitudin, quis bibendum justo commodo. Sed non mauris erat. Ut nisi elit, varius at interdum quis, tincidunt vel neque. In hac habitasse platea dictumst. Nulla at laoreet elit, at commodo est. Proin aliquet volutpat ante nec ullamcorper. Vivamus aliquam nulla in condimentum ultricies. Sed vitae porta urna. Aliquam fermentum at nibh malesuada lobortis. Morbi sodales risus eget nisl vehicula, sed sollicitudin ante pulvinar. Mauris nulla arcu, commodo in mauris vel, tempor volutpat tellus. Etiam sed malesuada quam. Ut sed bibendum neque. Nulla consequat lectus pharetra rutrum convallis.';

$terminal->writeln("Comparison with the same paragraph in two modes:\n");
$terminal->autoMargin(false);
$terminal->writeln("DISABLED = ".$paragraph);
$terminal->autoMargin();
$terminal->writeln("ENABLED = ". $paragraph);
$terminal->writeln("");
$terminal->writeln("When using auto margin, the text will automatically be wrapped.");
$terminal->writeln("You can also resize your terminal to see how it behaves.");
