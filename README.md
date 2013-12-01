WiredPi
=======

[![Latest Stable Version](https://poser.pugx.org/se/wired-pi/v/stable.png)](https://packagist.org/packages/se/wired-pi)

WiredPi is a library for connecting php and the Raspberry Pi GPIO via wiringPi.

#### Dev branch is master branch.

[![Build Status](https://api.travis-ci.org/sveneisenschmidt/wired-pi.png?branch=master)](https://travis-ci.org/svenseisenschmidt/wired-pi)


##### Table of Contents

1. [Installation](#installation)
2. [Usage](#usage)

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

<a name="usage"></a>

## Usage

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

Now add the port map to your board instance and refresh it. The settings take effect immediately 

```php
$board->setPorts($map);
$board->refresh(); // applies the current state to the microcontroller

// Modification of ports need to be applied again
$board->getPort(18)->on();
$board->refresh();
```

For reading the status of your pin you can use the platform instance you passed to the board.

```php
$port = $board->getPort(18);
$status = $platform->read($port); // returns 0 or 1
```


For more examples have a look at *examples/*.








