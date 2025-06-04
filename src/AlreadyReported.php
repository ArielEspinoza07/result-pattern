<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessageAndData;

final readonly class AlreadyReported extends Result implements CreateFromMessageAndDataContract, CreateFromMessageContract
{
    use CreateFromMessage;
    use CreateFromMessageAndData;

    public static function from(?string $message = null, array $data = []): Result
    {
        return self::create(
            true,
            $message ?? HttpResponseStatusCode::AlreadyReported->message(),
            HttpResponseStatusCode::AlreadyReported->value,
            $data,
        );
    }
}
