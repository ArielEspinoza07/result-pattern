<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use RuntimeException;

/**
 * @template TValue
 * @extends Result<TValue, never>
 */
final readonly class Success extends Result
{
    /** @param TValue $value */
    public function __construct(private mixed $value)
    {
    }

    public function isSuccess(): bool
    {
        return true;
    }

    public function isFailure(): bool
    {
        return false;
    }

    /** @return TValue */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /** @throws RuntimeException */
    public function getError(): mixed
    {
        throw new RuntimeException('No error in Success');
    }
}
