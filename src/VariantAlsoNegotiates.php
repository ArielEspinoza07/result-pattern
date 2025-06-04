<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Traits\CreateFromMessage;

final readonly class VariantAlsoNegotiates extends Result implements CreateFromMessageContract
{
    use CreateFromMessage;

    public static function from(?string $message = null, array $data = []): Result
    {
        return self::create(
            false,
            $message ?? HttpResponseStatusCode::VariantAlsoNegotiates->message(),
            HttpResponseStatusCode::VariantAlsoNegotiates->value,
            $data,
        );
    }
}
