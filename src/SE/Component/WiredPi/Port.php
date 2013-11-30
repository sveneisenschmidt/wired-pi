<?php

namespace SE\Component\WiredPi;

class Port
{
	/**
	 *
	 * @const
	 */
	const DIRECTION_IN = 1;
	const DIRECTION_OUT = 2;
	const STATE_ON = 1;
	const STATE_OFF = 0;

	/**
     *
	 * @var integer
     */
	protected $state = 0;

    /**
     *
     * @var integer
     */
    protected $direction = 2;

    /**
     *
     * @var integer
     */
    protected $channel;

    /**
     *
     * @param integer $channel
     * @paran integer $direction
     * @param inetger $state
     */
    public function __construct($channel, $direction = self::DIRECTION_OUT, $state = self::STATE_OFF)
    {
        if(is_integer($channel) === false)
        {
            throw new \InvalidArgumentException('First argument must be of type integer');
        }

        $this->channel = $channel;
        $this->setDirection($direction);
        $this->setState($state);
    }

	/**
     *
	 * @return void
     */
	public function on()
	{
		$this->setState(self::STATE_ON);
	}

	/**
	 *
	 * @return void
	 */
	public function off()
	{
		$this->setState(self::STATE_OFF);
	}

    /**
     *
     * @param integer $direction
     */
    public function setDirection($direction)
    {
        if(in_array($direction, array(self::DIRECTION_IN, self::DIRECTION_OUT)) === false) {
            throw new \InvalidArgumentException(sprintf('Unknown direction: %s', $direction));
        }
        $this->direction = (int)$direction;
    }

    /**
     *
     * @return integer
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     *
     * @param integer $state
     */
     public function setState($state)
     {
        if(in_array($state, array(self::STATE_ON, self::STATE_OFF)) === false) {
            throw new \InvalidArgumentException(sprintf('Unknown state: %s', $state));
        }
        $this->state = (int)$state;
     }

    /**
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @return integer
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
