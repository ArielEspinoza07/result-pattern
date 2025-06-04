<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessageAndData;

final readonly class NetworkAuthenticationRequired extends Result implements CreateFromMessageContract, CreateFromMessageAndDataContract
{
    use CreateFromMessage;
    use CreateFromMessageAndData;

    public static function from(string|null $message = null, array $data = []): Result
    {
        return self::create(
            false,
            $message ?? HttpResponseStatusCode::NetworkAuthenticationRequired->message(),
            HttpResponseStatusCode::NetworkAuthenticationRequired->value,
            $data
        );
    }
}
