<?php

namespace App\Tool\User;

class TokenGenerator
{
    /**
     * @return string
     *
     * @throws \Exception
     */
    public function generate(): string
    {
        return bin2hex(random_bytes(32));
    }
}