WiredPi
=======

[![Latest Stable Version](https://poser.pugx.org/se/wired-pi/v/stable.png)](https://packagist.org/packages/se/wired-pi)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/06a736f4-de13-455d-9d7f-3a5e865db8ea/mini.png)](https://insight.sensiolabs.com/projects/06a736f4-de13-455d-9d7f-3a5e865db8ea)

WiredPi is a library for connecting php and the Raspberry Pi GPIO via wiringPi.

#### Dev branch is master branch.

[![Build Status](https://api.travis-ci.org/sveneisenschmidt/wired-pi.png?branch=master)](https://travis-ci.org/svenseisenschmidt/wired-pi)


##### Table of Contents

1. [Installation](#installation)
2. [Usage](#usage)
    * [Basic](#basic-usage) 
    * [Read pin](#read-pin)
    * [Prototyping server](#prototyping-server)

<a name="installation"></a>
## Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```yaml
{
    "require": {
        "se/wired-pi": "dev-master"
    }
}
```

WiredPi uses internally the WiringPi library. A big thank you [@drogon](https://twitter.com/drogon). To install it follow the following steps:

```bash
$ cd /opt
$ sudo mkdir wiringpi
$ sudo chown $USER ./wiringpi
$ cd wiringpi
$ git clone git://git.drogon.net/wiringPi ./
$ git pull origin
$ ./build
```

(The package git-core is needed for git operations. Install it via *sudo apt-get install git-core*. )

<a name="usage"></a>

## Usage

### Basic usage
Require the composer autload file and create a new Board.

```php
require_once __DIR__.'/vendor/autoload.php';

use \SE\Component\WiredPi;

$platform = new WiredPi\Platform\RaspberryPi();
$board = new WiredPi\Board($platform);
```

The next step is to apply a port map to the port so it knows what pins can be controlled.

```php
$map = new WiredPi\PortMap(array(
    // number of the GPIO-pin,
    18
    // you can set default options too, STATE_ON turns the pin by default on
    23 => array(WiredPi\Port::STATE => WiredPi\Port::STATE_ON)
));
```

Now add the port map to your board instance and refresh it. The settings take effect immediately.

```php
$board->setPorts($map);
$board->refresh(); // applies the current state to the microcontroller

// Modification of ports need to be applied again
$board->getPort(18)->on();
$board->refresh();
```

### Read pin
For reading the status of your pin you can use the platform instance you passed to the board.

```php
$port = $board->getPort(18);
$status = $platform->read($port); // returns 0 or 1
```
By default the pins are set to OUT.

For receiving the status of a pin from IN set the mode to IN.

```php
$port = $board->getPort(18);
$port->setMode(WiredPi\Port::MODE_IN);

// Do something when Pin switches to 1
while(true) {
    
    if($platform->read($port) == '1') {
        print sprintf('Pin %s went to %s', $port, '1')
        break;
    }
    usleep(5000); // Let the system catch up
}
```

### Prototyping server

WiredPi includes a protyping server to control pins without the need to setup them from within a php script.
Run it by using the built in php server (Since PHP 5.4.0).

```bash
$ php -S localhost:8000 scripts/server.php
```

![](https://dl.dropboxusercontent.com/u/36028214/GitHUb/wired-pi-server.png)

For more examples have a look at *examples/*.








