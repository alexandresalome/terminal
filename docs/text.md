Text manipulation
=================

Auto-margin
-----------

The **auto-margin** feature of terminals is about their behaviors when text
reaches the end of terminal.

When auto-margin is **enabled**, it will automatically scroll to the next line.

When auto-margin is **disabled**, the text is discarded until the cursor goes to
the next line.

```
# Terminal (20,50)
$terminal->writeln(new Terminal\Object\Box('Auto-margin'));

$terminal->autoMargin();
$terminal->writeln('This line as auto-magin enabled. At the end of the screen, it goes to next line automatically.');
$terminal->writeln();

$terminal->autoMargin(false);
$terminal->writeln('Disabled: The line continues on the right of the screen');
$terminal->writeln();

$terminal->autoMargin();
$terminal->writeln('The paragraph above is partially displayed because auto-margin has been disabled.');
$terminal->writeln();
```
![Video capture of code above](_gifs/text.0.gif)
