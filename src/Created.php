<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessageAndData;

final readonly class Created extends Result implements CreateFromMessageAndDataContract, CreateFromMessageContract
{
    use CreateFromMessage;
    use CreateFromMessageAndData;

    public static function from(string|null $message = null, array $data = []): Result
    {
        $httpResponseStatus = HttpResponseStatusCode::Created;

        return self::create(
            isSuccess: false,
            message: $message ?? $httpResponseStatus->message(),
            status: $httpResponseStatus->value,
            data: $data,
        );
    }
}
