<?php

namespace AppBundle\Generator\API;

class UniqueTokenGenerator
{
    public function generate()
    {
        $bytes = random_bytes(24);
        return base64_encode(uniqid($bytes));
    }
}