<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;

final readonly class Unauthorized extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(?string $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::Unauthorized;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
