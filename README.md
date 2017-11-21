# Vote system

## Requirements

* PHP 7+ (May be ok on 5.6)
* MySQL

## Quick Start

### Install composer

See: https://getcomposer.org/download/

### Extract source codes

```
$ cd /var/www/
$ git clone xxxxxx vote
$ cd vote
$ ls
bin  composer.json  composer.lock  config  index.php  logs  phpunit.xml.dist  plugins  README.md  src  tests  tmp  vendor  webroot
$ cd webroot
$ ln -s ../tmp/files .
```

### Setup

```
$ composer install
$ vi config/app.php
(Edit database configuration in 'Datasources' key and SNS tokens in 'App.twitter' key. You can find it by 'your-xxxx'.)
$ bin/cake migrations migrate
$ vendor/bin/phpunit
(Runs unit test)
```

## Run

Open 'http://fqdn/admin/' and login with builderscon / beaconkun .  
Want to create new user? Try:

```
$ bin/cake add_admin username password admin
```

