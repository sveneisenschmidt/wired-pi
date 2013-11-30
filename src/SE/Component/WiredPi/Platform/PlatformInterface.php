<?php

namespace SE\Component\WiredPi\Platform;

use \SE\Component\WiredPi\Port;

interface PlatformInterface
{
    /**
     *
     * @param \SE\Component\WiredPi\Port
     */
    public function refresh(Port $port);
}
