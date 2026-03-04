<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use RuntimeException;

/**
 * @template TError
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

    /** @throws RuntimeException */
    public function getValue(): mixed
    {
        throw new RuntimeException('No value in Failure');
    }

    /** @return TError */
    public function getError(): mixed
    {
        return $this->error;
    }
}
