#!/bin/bash

date +%Y-%m-%d\ %H:%M:%S
NAME=$(date +%Y-%m-%d-%H-%M-%S)
URL=http://localhost:8000

mongodump

7z a dump.7z dump/
rm -r dump/

mkdir split-files
split --bytes=10M dump.7z split-files/
rm dump.7z
for i in split-files/*; do
	echo $i;
	while [ "$(curl -F "file=@./$i" $URL/dump/split/?hostname=$(hostname)\&name=$NAME)" != "#" ]
	do
		echo 'error';
		sleep 10;
	done
done
rm -r split-files
curl $URL/dump/join/?hostname=$(hostname)\&name=$NAME

date +%Y-%m-%d\ %H:%M:%S
