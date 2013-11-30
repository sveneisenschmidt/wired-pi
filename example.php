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

$board->setPorts(array($port1, $port2, $port3));
$board->refresh();

sleep(1);

$port1->on();
$board->refresh();

sleep(1);

$port1->off();
$port2->on();
$board->refresh();

sleep(1);

$port2->off();
$port3->on();
$board->refresh();

sleep(1);

$port1->off();
$port2->off();
$port3->off();
$board->refresh();
