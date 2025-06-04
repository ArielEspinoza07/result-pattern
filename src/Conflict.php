<?php

declare(strict_types=1);

final readonly class Conflict extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(string|null $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::Conflict;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
