<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessageAndData;

final readonly class Ok extends Result implements CreateFromMessageAndDataContract, CreateFromMessageContract
{
    use CreateFromMessage;
    use CreateFromMessageAndData;

    public static function from(
        ?string $message = null,
        HttpResponseStatusCode|int|null $status = null,
        ?array $data = [],
    ): Result {
        if ($status instanceof HttpResponseStatusCode) {
            return self::create(
                isSuccess: false,
                message: $message ?? $status->message(),
                status: $status->value,
                data: $data,
            );
        }

        return self::create(
            isSuccess: false,
            message: $message ?? HttpResponseStatusCode::OK->message(),
            status: $status ?? HttpResponseStatusCode::OK->value,
            data: $data,
        );
    }
}
