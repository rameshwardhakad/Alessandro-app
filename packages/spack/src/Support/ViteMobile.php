<?php

namespace Spack\Support;

class ViteMobile
{
    public function __construct(protected string $ip, protected int $port)
    {
    }

    /**
     * Convert the object to a string.
     */
    public function __toString(): string
    {
        return '<script type="module" src="http://'.$this->ip.':'.$this->port.'/@vite/client"></script>
                <script type="module" src="http://'.$this->ip.':'.$this->port.'/js/main.ts"></script>';
    }
}
