<?php

namespace app\components;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    /**
     * Generates a UUID v7 string.
     * @return string
     */
    public static function generate()
    {
        return Uuid::uuid7()->toString();
    }
}
