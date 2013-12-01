<?php

require_once __DIR__.'/../vendor/autoload.php';

use \SE\Component\WiredPi;
use \Symfony\Component\HttpFoundation;

$request = HttpFoundation\Request::createFromGlobals();
$response = HttpFoundation\RedirectResponse::create('/');

// init cookie
$value = $request->cookies->get('wiredpi_ports', '[]');
$cookie = new HttpFoundation\Cookie('wiredpi_ports', $value);

if($request->isMethod('POST') === true) {
    $data = $request->request;

    // ADD PORT
    if($data->get('action') !== null && $data->get('action') === 'port-add') {
        $channel = $data->get('channel', null);
        $mode = $data->get('mode', null);
        $state = $data->get('state', null);

        if(($channel !== null && empty($channel) !== true) && $mode !== null && $state !== null) {
            $values = json_decode($cookie->getValue(), true);
            $values[$channel] = array( WiredPi\Port::MODE => $mode, WiredPi\Port::STATE => $state);
            $cookie = new HttpFoundation\Cookie('wiredpi_ports', json_encode($values));
        }
    }

    // DELETE PORT
    if($data->get('action') !== null && $data->get('action') === 'port-delete') {
        $channel = $data->get('channel', null);
        if($channel !== null && empty($channel) !== true) {
            $values = json_decode($cookie->getValue(), true);
            unset($values[$channel]);
            $cookie = new HttpFoundation\Cookie('wiredpi_ports', json_encode($values));
        }
    }

    $response->headers->setCookie($cookie);
    $response->send();
}

$platform = new WiredPi\Platform\RaspberryPi();
$board = new WiredPi\Board($platform);
$ports = json_decode($request->cookies->get('wiredpi_ports', '[]'), false);

foreach($ports as $key => $data) {
    $port = new WiredPi\Port((int)$key);
    $options = (array)$data;
    if(array_key_exists(WiredPi\Port::MODE, $options)) {
        $port->setMode($options[WiredPi\Port::MODE]);
    }
    if(array_key_exists(WiredPi\Port::STATE, $options)) {
        $port->setState($options[WiredPi\Port::STATE]);
    }
    $board->addPort($port);
}

$board->refresh();

$labels = array(
    WiredPi\Port::MODE => array(
        WiredPi\Port::MODE_IN => 'IN',
        WiredPi\Port::MODE_OUT => 'OUT',
    ),
    WiredPi\Port::STATE => array(
        WiredPi\Port::STATE_ON => 'ON',
        WiredPi\Port::STATE_OFF => 'OFF',
    )
);


?>
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        table th {
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>wiredPi prototyping server</h1>

    <form action="/" method="POST">
        <fieldset>
            <legend>Add/update Port</legend>
            <label for="channel">GPIO</label> <input name="channel" type="text" size="4" maxlength="2" />
            <select name="mode">
                <option value="<?php print WiredPi\Port::MODE_IN; ?>"><?php print $labels[WiredPi\Port::MODE][WiredPi\Port::MODE_IN]; ?></option>
                <option selected value="<?php print WiredPi\Port::MODE_OUT; ?>"><?php print $labels[WiredPi\Port::MODE][WiredPi\Port::MODE_OUT]; ?></option>
            </select>
            <select name="state">
                <option value="<?php print WiredPi\Port::STATE_ON; ?>"><?php print $labels[WiredPi\Port::STATE][WiredPi\Port::STATE_ON]; ?></option>
                <option selected value="<?php print WiredPi\Port::STATE_OFF; ?>"><?php print $labels[WiredPi\Port::STATE][WiredPi\Port::STATE_OFF]; ?></option>
            </select>
            <button type="submit" name="action" value="port-add">+</button>
        </fieldset>
    </form>

    <?php if(count($ports) > 0): ?>
        <h3>GPIOs</h3>
        <table width="50%"
            <thead>
                <tr>
                    <th>GPIO</th>
                    <th>Mode</th>
                    <th>State</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($ports as $channel => $port): ?>
                <tr>
                    <td><?php print $channel; ?></td>
                    <td><?php print $labels[WiredPi\Port::MODE][(int)$port->mode]; ?></td>
                    <td><?php print $labels[WiredPi\Port::STATE][(int)$port->state]; ?></td>
                    <td width="10%">
                        <form action="/" method="POST">
                            <input type="hidden" name="channel" value="<?php print $channel; ?>" />
                            <button type="submit" name="action" value="port-delete">-</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>



