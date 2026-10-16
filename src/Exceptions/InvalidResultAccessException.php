<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Exceptions;

use LogicException;
use Throwable;

/**
 * Thrown when reading the side of a Result that does not exist:
 * the value of a Failure, or the error of a Success.
 *
 * This is a programming error. Check isSuccess()/isFailure() first,
 * or use getValueOr(), getErrorOr() or fold().
 */
final class InvalidResultAccessException extends LogicException
{
    /**
     * When the Failure's error is a Throwable, it becomes the previous exception
     * so its message and stack trace are not lost.
     */
    public static function valueOfFailure(mixed $error): self
    {
        return new self(
            sprintf('Cannot get the value of a Failure (error type: %s).', get_debug_type($error)),
            previous: $error instanceof Throwable ? $error : null,
        );
    }

    public static function errorOfSuccess(mixed $value): self
    {
        return new self(
            sprintf('Cannot get the error of a Success (value type: %s).', get_debug_type($value)),
        );
    }
}
