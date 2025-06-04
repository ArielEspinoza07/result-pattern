<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessageAndData;

final readonly class Failed extends Result implements Contracts\CreateFromMessageAndDataContract, Contracts\CreateFromMessageContract
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
            message: $message ?? HttpResponseStatusCode::InternalServerError->message(),
            status: $status ?? HttpResponseStatusCode::InternalServerError->value,
            data: $data,
        );
    }
}
