<?php

require_once __DIR__.'/../vendor/autoload.php';

use \SE\Component\WiredPi;

return new WiredPi\PortMap(array(
    18 => array(WiredPi\Port::STATE => WiredPi\Port::STATE_ON),
    23,
    24
));
