<?php

namespace SE\Component\WiredPi;

use \SE\Component\WiredPi\Port;
use \SE\Component\WiredPi\Platform\PlatformInterface;

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
		$this->ports[$channel]= $port;
    }
    
	/**
	 *
	 * @param array|\SE\Component\WiredPi\Port $ports
	 */
	public function setPorts(array $ports)
	{
	    foreach($ports as $port)
	    {
	        $this->addPort($port);
	    }
	}

    /**
     *
     * @return void
     */
	public function refresh()
	{
        foreach($this->ports as $port) {
            $this->platform->refresh($port);
        }
	}
}
