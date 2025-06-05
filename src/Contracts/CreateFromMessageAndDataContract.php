<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Contracts;

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;

interface CreateFromMessageAndDataContract
{
    /**
     * @param array<empty>|array<string, mixed> $data
     */
    public static function fromMessageAndData(
        string $message,
        HttpResponseStatusCode|int $status,
        array $data,
    ): Result;
}
