# Store dump databases

### Dependencies

1. 7z
```shell-session
$ sudo apt-get install p7zip-full
```

## Configure server

1. Download script
```shell-session
$ wget https://raw.githubusercontent.com/denissonleal/dump/master/scripts/dump-split-mongo.sh
```

2. Change url in `dump-split-mongo.sh`

3. Configure cron
```cron
0 2 * * * sh /path/to/file/dump-split-mongo.sh > /tmp/dump-mongo.log 2>&1
```

4. Take hostname
```shell-session
$ hostname
```

## Configure local dump

1. Configure project

2. Insert hostname in list

```shell-session
$ php artisan tinker
\App\Hostname::create(['name' => 'hostname-of-your-server'])
```

## Test dump

run it
```shell-session
$ sh dump-split-mongo.sh
```
