<?php
/**
 * This file is part of the WiredPi php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\WiredPi;

use \SE\Component\WiredPi\Port;
use \SE\Component\WiredPi\Platform\PlatformInterface;

/**
 *
 * @package SE\Component\WiredPi
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class Board
{
    /**
     *
     * @var array
     */
    protected $ports = array();

    /**
     *
     * @var \SE\Component\WiredPi\Platform\PlatformInterface
     */
    protected $platform;

    /**
     *
     * @var \SE\Component\WiredPi\Platform\PlatformInterface
     */
    public function __construct(PlatformInterface $platform)
    {
        $this->platform = $platform;
    }

    /**
     *
     * @param \SE\Component\WiredPi\Port $port
     */
    public function addPort(Port $port)
    {
        $channel = $port->getChannel();
        $this->ports[$channel] = $port;
    }

    /**
     *
     * @param integer $channel
     * @return \SE\Component\WiredPi\Port
     */
    public function getPort($channel)
    {
        if(isset($this->ports[$channel]) === true) {
            return $this->ports[$channel];
        }

        return null;
    }

    /**
     *
     * @param array|\SE\Component\WiredPi\Port $ports
     * @throws \InvalidArgumentException
     */
    public function setPorts($ports)
    {
        if(is_array($ports) === false && $ports instanceof \Iterator === false ) {
            throw new \InvalidArgumentException(sprintf(
                '%s::setPorts($ports): Invalid argument $ports of type `%s`.'
                ,get_class($this)
                ,gettype($ports)
            ));
        }

        foreach ($ports as $port) {
            $this->addPort($port);
        }
    }


    /**
     *
     * @return array|\SE\Component\WiredPi\Port
     */
    public function getPorts()
    {
        return $this->ports;
    }

    /**
     *
     * @return void
     */
    public function refresh()
    {
        foreach ($this->ports as $port) {
            $this->platform->refresh($port);
        }
    }
}
