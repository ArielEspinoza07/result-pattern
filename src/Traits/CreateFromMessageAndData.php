<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Traits;

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;

trait CreateFromMessageAndData
{
    public static function fromMessageAndData(
        string $message,
        HttpResponseStatusCode|int $status,
        array $data,
    ): Result {
        return self::from(
            message: $message,
            status: $status,
            data: $data,
        );
    }
}
