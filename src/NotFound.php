<?php

declare(strict_types=1);


final readonly class NotFound extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(string|null $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::NotFound;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
