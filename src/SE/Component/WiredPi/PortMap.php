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
use \SE\Component\WiredPi\Port;

class PortMap implements \Iterator
{
    /**
     *
     * @var array
     */
    protected $items = array();

    /**
     *
     * @var integer
     */
    protected $key = 0;

    /**
     *
     * @param array $ports
     */
    public function __construct(array $ports)
    {
        foreach($ports as $channel => $options) {
            if(is_integer($options) === true) {
                $channel = $options;
                $options = array();
            }

            $port = new Port((int)$channel);
            if(array_key_exists(Port::MODE, $options)) {
                $port->setMode($options[Port::MODE]);
            }

            if(array_key_exists(Port::STATE, $options)) {
                $port->setState($options[Port::STATE]);
            }

            $this->items []= $port;
        }
    }

    /**
     *
     * @return \SE\Component\WiredPi\Port
     */
    public function current()
    {
        return $this->items[$this->key];
    }

    /**
     *
     * @return void
     */
    public function next()
    {
        $this->key++;
    }

    /**
     *
     * @return integer
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     *
     * @return boolean
     */
    public function valid()
    {
        return array_key_exists($this->key, $this->items);
    }

    /**
     *
     * @return void
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     *
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }
}
