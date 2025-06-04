<?php

declare(strict_types=1);

trait CreateFromMessageAndData
{
    public static function fromMessageAndData(string $message, array $data): Result
    {
        return self::from(
            message: $message,
            data: $data,
        );
    }
}
