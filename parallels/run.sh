#!/bin/sh
PHPSCRIPT=run.php
OUTFILE='../var/log/parallels.log'
touch "$OUTFILE"
PHP_BIN=`which php`
#PHP_BIN='/Applications/XAMPP/xamppfiles/bin/php'
INSTALLDIR=`echo $0 | sed 's/run\.sh//g'`
$PHP_BIN "$INSTALLDIR""$PHPSCRIPT" "$@" > "$INSTALLDIR""$OUTFILE" 2>&1 &
