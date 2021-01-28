Cursor
======

Show and hide cursor
--------------------

### `cursorVisible(bool $enabled = true): void`

Changes the visibility of the text cursor.

#### Examples

Without any argument, you ensure the cursor is visible:

```
# Terminal (1,30,1)
$terminal->cursorVisible();
$terminal->write("Visible cursor ");
```
![Video capture of code above](_gifs/cursor.0.gif)

If you pass `false` as first argument, the cursor becomes invisible: 

```
# Terminal (1,30,1)
$terminal->cursorVisible(false);
$terminal->write("Invisible cursor ");
```
![Video capture of code above](_gifs/cursor.1.gif)
