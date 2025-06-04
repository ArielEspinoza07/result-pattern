<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Traits;

use ArielEspinoza07\ResultPattern\Result;

trait CreateFromMessage
{
    public static function fromMessage(string $message): Result
    {
        return self::from(message: $message);
    }
}
