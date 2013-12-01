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
class BoardTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function SimpleConstruction()
    {
        $platform = $this->getMockForAbstractClass('SE\Component\WiredPi\Platform\PlatformInterface');
        $board = new \SE\Component\WiredPi\Board($platform);

        $this->assertEmpty($board->getPorts());
        $this->assertNull($board->getPort(1));
    }

    /**
     *
     * @test
     */
    public function AddPort()
    {
        $platform = $this->getMockForAbstractClass('SE\Component\WiredPi\Platform\PlatformInterface');
        $board = new \SE\Component\WiredPi\Board($platform);

        $port = new \SE\Component\WiredPi\Port($channel = rand(1,24));
        $board->addPort($port);
        $this->assertSame($board->getPort($channel), $port);
        $this->assertCount(1, $board->getPorts());
    }

    /**
     *
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function setPorts()
    {
        $platform = $this->getMockForAbstractClass('SE\Component\WiredPi\Platform\PlatformInterface');
        $board = new \SE\Component\WiredPi\Board($platform);

        $ports = array(
            $port1 = new \SE\Component\WiredPi\Port($channel = rand(1,12)),
            $port2 = new \SE\Component\WiredPi\Port($channel = rand(13,24)),
            $port3 = new \SE\Component\WiredPi\Port($channel = rand(25,36)),
        );

        $board->setPorts($ports);
        $this->assertCount(3, $board->getPorts());

        $board->setPorts(new \stdClass());
    }

    /**
     *
     * @test
     */
    public function setPortMap()
    {
        $platform = $this->getMockForAbstractClass('SE\Component\WiredPi\Platform\PlatformInterface');
        $board = new \SE\Component\WiredPi\Board($platform);
        $map = new \SE\Component\WiredPi\PortMap(range(1,12));

        $board->setPorts($map);
        $this->assertCount(12, $board->getPorts());
    }

    /**
     *
     * @test
     */
    public function RefreshPort()
    {
        $platform = $this->getMockForAbstractClass('SE\Component\WiredPi\Platform\PlatformInterface');
        $platform->expects($this->exactly(4))
            ->method('refresh');

        $board = new \SE\Component\WiredPi\Board($platform);
        $map = new \SE\Component\WiredPi\PortMap(range(1,4));
        $board->setPorts($map);
        $board->refresh();
    }
}