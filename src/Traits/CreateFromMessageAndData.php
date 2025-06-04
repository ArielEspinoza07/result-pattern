<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Traits;

use ArielEspinoza07\ResultPattern\Result;

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
