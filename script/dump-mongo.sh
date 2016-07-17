#!/bin/bash

rm -r dump/ dump-$(hostname)-*.7z
mongodump
FILE_DUMP=dump-$(hostname)-$(date +%Y-%m-%d-%H-%M-%S).7z
7z a $FILE_DUMP dump/
curl -F "file=@./$FILE_DUMP" http://localhost:8000/dump
