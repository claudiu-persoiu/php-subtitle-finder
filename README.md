# PHP Subtitle Finder
Movie subtitle finder

The finder can work in two modes, as a command line or integrated with [Transmission Torrent](https://transmissionbt.com/) client.

## Installation:

Run the commands below:
```
$ sudo apt install -y php php-xmlrpc

$ wget https://github.com/claudiu-persoiu/php-subtitle-finder/raw/storage/subfinder.phar

$ chmod +x subfinder.phar

$ sudo wget https://github.com/claudiu-persoiu/php-subtitle-finder/raw/storage/subfinder.ini -P /etc
```

#### Optional
Register at: [https://www.opensubtitles.org/en/newuser](https://www.opensubtitles.org/en/newuser)
Add the user and password to **/etc/subfinder.ini** file from above

NOTE: If you don't want to register leave the name and password fields empty

## Running

### As a command line tool
```
$ ./subfinder.phar path_to_movie
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
"script-torrent-done-filename": "/path/to/installation/subfinder.phar",
```

Start the server back:
```
$ sudo service transmission-daemon start
```

NOTE: In case you need to debug Transmission installation the output is redirected to default syslog file.
