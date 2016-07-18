#!/bin/bash

date +%Y-%m-%d\ %H:%M:%S

FILE_DUMP=dump-$(hostname)-$(date +%Y-%m-%d-%H-%M-%S)
URL=http://dump.sysvale.com/dump?hostname=$(hostname)
USER=
PASSWORD=
TABLE=

mysqldump --databases $TABLE -u $USER -p$PASSWORD --compact --lock-tables > $FILE_DUMP.sql
7z a $FILE_DUMP.7z $FILE_DUMP.sql
rm $FILE_DUMP.sql
curl -F "file=@./$FILE_DUMP.7z" $URL
rm $FILE_DUMP.7z

date +%Y-%m-%d\ %H:%M:%S
# curl -F "file=@./dump-esus-cidadesaudavel-2016-07-17-12-26-12.7z" http://dump.sysvale.com/dump
