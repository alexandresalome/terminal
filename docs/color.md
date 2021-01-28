Color
=====

```
# Terminal (20,80)
$colors = ["black", "red", "green", "yellow", "blue", "magenta", "cyan", "white"];

foreach ($colors as $foreground) {
    foreach ($colors as $background) {
        $terminal->setColor($foreground, $background);
        $terminal->write(' -- '.$foreground[0].$background[0].' -- ');
    }
    $terminal->resetColor();
    $terminal->writeln("");
}
```
![Video capture of code above](_gifs/color.0.gif)
