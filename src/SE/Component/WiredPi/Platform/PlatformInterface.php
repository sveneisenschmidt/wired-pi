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

/**
 *
 * @package SE\Component\WiredPi
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
interface PlatformInterface
{
    /**
     *
     * @param \SE\Component\WiredPi\Port
     */
    public function refresh(Port $port);

    /**
     *
     * @param \SE\Component\WiredPi\Port
     * @return mixed
     */
    public function read(Port $port);

    /**
     *
     * @param \SE\Component\WiredPi\Port
     */
    public function write(Port $port);
}
