<?php

declare(strict_types=1);


final readonly class InternalServerError extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(string|null $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::InternalServerError;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
