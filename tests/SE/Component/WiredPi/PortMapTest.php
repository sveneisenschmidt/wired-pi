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
class PortMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function SimpleConstruction()
    {
        $ports = range(1,10);
        $map = new \SE\Component\WiredPi\PortMap($ports);

        $this->assertEquals(count($ports), $map->count());
    }
    /**
     *
     * @test
     */
    public function FullConstruction()
    {
        $ports = array(
            3 => array(
                \SE\Component\WiredPi\Port::MODE => \SE\Component\WiredPi\Port::MODE_IN,
                \SE\Component\WiredPi\Port::STATE => \SE\Component\WiredPi\Port::STATE_ON
            ),
            4,
            5
        );
        $map = new \SE\Component\WiredPi\PortMap($ports);

        foreach($map as $item) {
            $this->assertInstanceOf('SE\Component\WiredPi\Port', $item);
        }

        $map->rewind();
        $this->assertEquals(0, $map->key());

        $item = $map->current();
        $this->assertInstanceOf('SE\Component\WiredPi\Port', $item);
        $this->assertEquals(\SE\Component\WiredPi\Port::STATE_ON, $item->getState());
        $this->assertEquals(\SE\Component\WiredPi\Port::MODE_IN, $item->getMode());

        $map->rewind();
        $map->next();
        $this->assertEquals(1, $map->key());
    }


}