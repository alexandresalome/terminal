How it works
============

Terminfo
--------

There are a lot of terminals existing out there, and most of them share common
capabilities: color, text formatting (blinking, underline, bold, ...).

**Terminfo** is a database about all those terminals. Many dozens of metadata
exist for every terminal, giving instructions on how to use those features.

You can know the current terminal by reading the `TERM` environment variable:

```
echo $TERM
```

Hopefully, the mostly used are now common:

- [Xterm](https://en.wikipedia.org/wiki/Xterm) for X Window System
- [VT100](https://en.wikipedia.org/wiki/VT100) for Telnet

By reading this database, and with little knowledge about it, you can start
using terminal's capabilities: color, cursor move, screen manipulation, etc.
