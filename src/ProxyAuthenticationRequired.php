<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;

final readonly class ProxyAuthenticationRequired extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(string|null $message = null, array $data = []): Result
    {
        return self::create(
            false,
            $message ?? HttpResponseStatusCode::ProxyAuthenticationRequired->message(),
            HttpResponseStatusCode::ProxyAuthenticationRequired->value,
            $data
        );
    }
}
