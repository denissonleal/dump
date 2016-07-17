#!/bin/bash

FILE_DUMP=dump-$(hostname)-$(date +%Y-%m-%d-%H-%M-%S).7z
rm -r dump/ dump-$(hostname)-*.7z
mongodump
7z a $FILE_DUMP dump/
curl -F "file=@./$FILE_DUMP" http://dump.sysvale.com/dump
