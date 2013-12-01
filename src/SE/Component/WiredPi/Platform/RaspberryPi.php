<?php

namespace SE\Component\WiredPi\Platform;

use \SE\Component\WiredPi\Port;
use \SE\Component\WiredPi\Platform\PlatformInterface;

class RaspberryPi implements PlatformInterface
{
    /**
     *
     * @var string
     */
    protected $path;

    /**
     *
     * @var string $path
     */
    public function __construct($path = '/usr/local/bin/gpio')
    {
        $this->path = trim($path);
    }

    /**
     *
     * @param \SE\Component\WiredPi\POrt
     */
    public function refresh(Port $port)
    {
        $command = $this->getCommand($port);
        $output = shell_exec($command);

        if ($output !== null) {
            throw new \RuntimeException(sprintf('The shell returned an error: %s', $output));
        }
    }

    public function getCommand(Port $port)
    {
        $channel = $port->getChannel();
        $state = null;
        $direction = null;

        switch ($port->getState()) {
            case Port::STATE_ON:
                $state = 1;
                break;
            case Port::STATE_OFF:
                $state = 0;
                break;
            default:
                throw new \RuntimeException(sprintf('Invalid state: %s', $port->getState()));
        }

        switch ($port->getDirection()) {
            case Port::DIRECTION_IN:
                $direction = 'in';
                break;
            case Port::DIRECTION_OUT:
                $direction = 'out';
                break;
            default:
                throw new \RuntimeException(sprintf('Invalid direction: %s', $port->getDirection()));
        }

        $mode = sprintf('%s -g mode %s %s', $this->path, $channel, $direction);
        $state = sprintf('%s -g write %s %s', $this->path, $channel, $state);

        return sprintf('%s && %s', $mode, $state);
    }
}
