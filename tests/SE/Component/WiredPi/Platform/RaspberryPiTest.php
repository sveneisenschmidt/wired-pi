<?php
/**
 * This file is part of the WiredPi php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\WiredPi\Tests\Platform;

/**
 *
 * @package SE\Component\WiredPi\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class RaspberryPiTest  extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * Setup
     */
    public function setUp()
    {
        $this->gpio = sprintf('sh %s/Fixtures/gpio.sh', __DIR__);
    }

    /**
     *
     * @test
     */
    public function SimpleConstruction()
    {
        $port = new \SE\Component\WiredPi\Port($channel = rand(1,12));
        $port->setMode(\SE\Component\WiredPi\Port::MODE_OUT);
        $port->setState(\SE\Component\WiredPi\Port::STATE_ON);

        $platform = new \SE\Component\WiredPi\Platform\RaspberryPi($this->gpio);
    }

    /**
     *
     * @test
     */
    public function Refresh()
    {
        $port = new \SE\Component\WiredPi\Port($channel = rand(1,12));
        $port->setMode(\SE\Component\WiredPi\Port::MODE_OUT);
        $port->setState(\SE\Component\WiredPi\Port::STATE_ON);

        $platform = new \SE\Component\WiredPi\Platform\RaspberryPi($this->gpio);
        $platform->refresh($port);

        $this->assertEquals(
            $this->getActualOutput(),
            sprintf("-g mode %s out\n-g write %s %s\n", $channel, $channel, \SE\Component\WiredPi\Port::STATE_ON)
        );
    }

    /**
     *
     * @test
     */
    public function Write()
    {
        $port = new \SE\Component\WiredPi\Port($channel = rand(1,12));
        $port->setMode(\SE\Component\WiredPi\Port::MODE_OUT);
        $port->setState(\SE\Component\WiredPi\Port::STATE_ON);

        $platform = new \SE\Component\WiredPi\Platform\RaspberryPi($this->gpio);
        $platform->write($port);

        $this->assertEquals(
            $this->getActualOutput(),
            sprintf("-g mode %s out\n-g write %s %s\n", $channel, $channel, \SE\Component\WiredPi\Port::STATE_ON)
        );
    }

    /**
     *
     * @test
     */
    public function Read()
    {
        $port = new \SE\Component\WiredPi\Port($channel = rand(1,12));
        $port->setMode(\SE\Component\WiredPi\Port::MODE_OUT);
        $port->setState(\SE\Component\WiredPi\Port::STATE_ON);

        $platform = new \SE\Component\WiredPi\Platform\RaspberryPi($this->gpio);
        $platform->read($port);

        $this->assertEquals(
            $this->getActualOutput(),
            sprintf("-g mode %s out\n-g read %s\n", $channel, $channel)
        );
    }
}