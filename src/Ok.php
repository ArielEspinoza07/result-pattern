<?php

declare(strict_types=1);

final readonly class Ok extends Result implements CreateFromMessageAndDataContract, CreateFromMessageContract
{
    use CreateFromMessage;
    use CreateFromMessageAndData;

    public static function from(string|null $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::OK;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
