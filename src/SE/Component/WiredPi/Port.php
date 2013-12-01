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

/**
 *
 * @package SE\Component\WiredPi
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class Port
{
    /**
     *
     * @const
     */
    const MODE = 'mode';
    const MODE_IN = 1;
    const MODE_OUT = 2;

    const STATE = 'state';
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
    protected $mode = self::MODE_OUT;

    /**
     *
     * @var integer
     */
    protected $channel;

    /**
     *
     * @param integer $channel
     * @param integer $mode
     * @param integer $state
     * @throws \InvalidArgumentException
     */
    public function __construct($channel, $mode = self::MODE_OUT, $state = self::STATE_OFF)
    {
        if (is_integer($channel) === false) {
            throw new \InvalidArgumentException('First argument must be of type integer');
        }

        $this->channel = $channel;
        $this->setMode($mode);
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
     * @param integer $mode
     * @throws \InvalidArgumentException
     */
    public function setMode($mode)
    {
        if (in_array($mode, array(self::MODE_IN, self::MODE_OUT)) === false) {
            throw new \InvalidArgumentException(sprintf('Unknown mode: %s', $mode));
        }
        $this->mode = (int)$mode;
    }

    /**
     *
     * @return integer
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     *
     * @param integer $state
     * @throws \InvalidArgumentException
     */
    public function setState($state)
    {
        if (in_array($state, array(self::STATE_ON, self::STATE_OFF)) === false) {
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
