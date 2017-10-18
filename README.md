# PHP Subtitle Finder
Movie subtitle finder

The finder can work in two modes, as a command line or integrated with [Transmission Torrent](https://transmissionbt.com/) client.

## Installation:

Run the commands below:
```
$ git clone https://github.com/claudiu-persoiu/php-subtitle-finder.git

$ composer install --no-dev
```

Rename **config.ini.sample** to **config.ini**.

#### Optional
Register at: [https://www.opensubtitles.org/en/newuser](https://www.opensubtitles.org/en/newuser)
Add the user and password to **config.ini** file from above

## Running

### As a command line tool
```
$ ./command path_to_movie
```

### Integrate with Transmission Torrent

After completing the steps above, stop transmission process:
```
$ sudo service transmission-daemon stop
```

Edit the config file located at: **/etc/transmission-daemon/settings.json**

NOTE: Path to config may be different for your setup, for Ubuntu desktop the path is **~/.config/transmission/settings.json**


Find the lines with:
```
"script-torrent-done-enabled": false,
"script-torrent-done-filename": "",
```
and replace with:
```
"script-torrent-done-enabled": true,
"script-torrent-done-filename": "/path/to/installation/console.php",
```

Start the server back:
```
$ sudo service transmission-daemon start
```

NOTE: In case you need to debug Transmission installation the output is redirected to default syslog file.