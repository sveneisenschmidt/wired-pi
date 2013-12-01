<?php
/**
 * This file is part of the WiredPi php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\WiredPi\Platform;

use \SE\Component\WiredPi\Port;
use \SE\Component\WiredPi\Platform\PlatformInterface;

/**
 *
 * @package SE\Component\WiredPi
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
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
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     */
    public function refresh(Port $port)
    {
        $this->write($port);
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     * @return void
     */
    public function write(Port $port)
    {
        $init = $this->getModeCommand($port);
        $write = $this->getWriteCommand($port);

        $command = sprintf('%s && %s', $init, $write);
        passthru($command, $output);

        if ($output != 0) {
            throw new \RuntimeException(sprintf('The shell returned an error: %s', $output));
        }
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     * @return mixed
     */
    public function read(Port $port)
    {
        $init = $this->getModeCommand($port);
        $read = $this->getReadCommand($port);

        $command = sprintf('%s && %s', $init, $read);
        passthru($command, $output);;

        return trim((string)$output);
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     * @return string
     */
    public function getModeCommand(Port $port)
    {
        switch ($port->getMode()) {
            case Port::MODE_IN:
                $mode = 'in';
                break;
            case Port::MODE_OUT:
                $mode = 'out';
                break;
            default:
                throw new \RuntimeException(sprintf('Invalid direction: %s', $port->getMode()));
        }

        return sprintf('%s -g mode %s %s', $this->path, $port->getChannel(), $mode);
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     * @return string
     */
    public function getWriteCommand(Port $port)
    {
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

        return sprintf('%s -g write %s %s', $this->path, $port->getChannel(), $state);
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     * @throws \RuntimeException
     * @return string
     */
    public function getReadCommand(Port $port)
    {
        return sprintf('%s -g read %s', $this->path, $port->getChannel());
    }
}
