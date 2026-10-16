<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Exceptions\InvalidResultAccessException;

/**
 * @template-covariant TError
 * @extends Result<never, TError>
 */
final readonly class Failure extends Result
{
    /** @param TError $error */
    public function __construct(private mixed $error) {}

    public function isSuccess(): bool
    {
        return false;
    }

    public function isFailure(): bool
    {
        return true;
    }

    /** @throws InvalidResultAccessException */
    public function getValue(): never
    {
        throw InvalidResultAccessException::valueOfFailure($this->error);
    }

    /** @return TError */
    public function getError(): mixed
    {
        return $this->error;
    }
}
