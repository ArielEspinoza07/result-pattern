<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Contracts;

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;

interface CreateFromMessageContract
{
    public static function fromMessage(
        string $message,
        HttpResponseStatusCode|int $status,
    ): Result;
}
