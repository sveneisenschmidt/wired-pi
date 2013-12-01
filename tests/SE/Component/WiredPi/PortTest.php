<?php
/**
 * This file is part of the WiredPi php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\WiredPi\Tests;

/**
 *
 * @package SE\Component\WiredPi\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class PortTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function SimpleConstruction()
    {
        $channel = rand(1,24);

        $port = new \SE\Component\WiredPi\Port($channel);
        $this->assertSame($channel, $port->getChannel());

        new \SE\Component\WiredPi\Port('abc');
    }

    /**
     *
     * @test
     */
    public function FullConstruction()
    {
        $channel1 = rand(1,24);
        $mode1 = \SE\Component\WiredPi\Port::MODE_IN;
        $state1 = \SE\Component\WiredPi\Port::STATE_OFF;

        $port1 = new \SE\Component\WiredPi\Port($channel1, $mode1, $state1);
        $this->assertSame($channel1, $port1->getChannel());
        $this->assertSame($mode1, $port1->getMode());
        $this->assertSame($state1, $port1->getState());

        $channel2 = rand(1,24);
        $mode2 = \SE\Component\WiredPi\Port::MODE_OUT;
        $state2 = \SE\Component\WiredPi\Port::STATE_ON;

        $port2 = new \SE\Component\WiredPi\Port($channel2, $mode2, $state2);
        $this->assertSame($channel2, $port2->getChannel());
        $this->assertSame($mode2, $port2->getMode());
        $this->assertSame($state2, $port2->getState());
    }

    /**
     *
     * @test
     */
    public function StateOn()
    {
        $port = new \SE\Component\WiredPi\Port(rand(1,24));
        $port->on();

        $this->assertSame(\SE\Component\WiredPi\Port::STATE_ON, $port->getState());
    }

    /**
     *
     * @test
     */
    public function StateOff()
    {
        $port = new \SE\Component\WiredPi\Port(rand(1,24));
        $port->off();

        $this->assertSame(\SE\Component\WiredPi\Port::STATE_OFF, $port->getState());
    }

    /**
     *
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedException \InvalidArgumentException
     */
    public function InvalidArguments()
    {
        $port = new \SE\Component\WiredPi\Port(rand(1,24));
        $port->setMode('x');
        $port->setState('y');

    }
}