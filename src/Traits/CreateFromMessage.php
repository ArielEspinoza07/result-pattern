<?php

declare(strict_types=1);


trait CreateFromMessage
{
    public static function fromMessage(string $message): Result
    {
        return self::from(message: $message);
    }
}
