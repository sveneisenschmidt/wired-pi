<?php

require_once __DIR__.'/../vendor/autoload.php';

use \SE\Component\WiredPi;

$platform = new WiredPi\Platform\RaspberryPi();

$ports = require_once __DIR__.'/map.php';
$board = new WiredPi\Board($platform);
$board->setPorts($ports);

foreach($board->getPorts() as $port) {
    $port->off();
}

$board->refresh();