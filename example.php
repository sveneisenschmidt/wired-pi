<?php

require_once __DIR__.'/src/SE/Component/WiredPi/Board.php';
require_once __DIR__.'/src/SE/Component/WiredPi/Port.php';
require_once __DIR__.'/src/SE/Component/WiredPi/Platform/PlatformInterface.php';
require_once __DIR__.'/src/SE/Component/WiredPi/Platform/RaspberryPi.php';


use \SE\Component\WiredPi;

$platform = new WiredPi\Platform\RaspberryPi();
$board = new WiredPi\Board($platform);

$port1 = new WiredPi\Port(18);
$port2 = new WiredPi\Port(23);
$port3 = new WiredPi\Port(24);

$board->setPorts($ports = array($port1, $port2, $port3));

$port1->on();
$port2->on();
$port3->on();

$board->refresh();



while(true) {

    foreach($ports as $port) {
        $port->on();
        $board->refresh();
        usleep(5000);
        $port->off();
     }
}
