#!/bin/bash

date +%Y-%m-%d\ %H:%M:%S

FILE_DUMP=dump-$(hostname)-$(date +%Y-%m-%d-%H-%M-%S).7z
URL=http://dump.sysvale.com/dump?hostname=$(hostname)

mongodump
7z a $FILE_DUMP dump/
rm -r dump/
curl -F "file=@./$FILE_DUMP" $URL
rm FILE_DUMP

date +%Y-%m-%d\ %H:%M:%S
# curl -F "file=@./dump-esus-cidadesaudavel-2016-07-17-12-26-12.7z" http://dump.sysvale.com/dump
