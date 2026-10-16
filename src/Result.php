<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use ArielEspinoza07\ResultPattern\Exceptions\InvalidResultAccessException;

/**
 * The outcome of an operation: either a Success holding a value or a Failure holding an error.
 *
 * Create instances through {@see Results}.
 *
 * @template-covariant TValue
 * @template-covariant TError
 *
 * @phpstan-sealed Success|Failure
 */
abstract readonly class Result
{
    /**
     * @phpstan-assert-if-true Success<TValue> $this
     * @phpstan-assert-if-false Failure<TError> $this
     */
    abstract public function isSuccess(): bool;

    /**
     * @phpstan-assert-if-true Failure<TError> $this
     * @phpstan-assert-if-false Success<TValue> $this
     */
    abstract public function isFailure(): bool;

    /**
     * Returns the value. Prefer getValueOr() or fold() unless the result is known to be a Success.
     *
     * @return TValue
     *
     * @throws InvalidResultAccessException when called on a Failure
     */
    abstract public function getValue(): mixed;

    /**
     * Returns the error. Prefer getErrorOr() or fold() unless the result is known to be a Failure.
     *
     * @return TError
     *
     * @throws InvalidResultAccessException when called on a Success
     */
    abstract public function getError(): mixed;

    /**
     * Returns the value if Success, or the given default if Failure.
     *
     * The default is evaluated before the call. For a default that is costly to compute,
     * use recover(fn ($error) => ...)->getValue() so it only runs on Failure.
     *
     * @template TDefault
     *
     * @param  TDefault  $default
     * @return TValue|TDefault
     */
    final public function getValueOr(mixed $default): mixed
    {
        return $this->isSuccess() ? $this->getValue() : $default;
    }

    /**
     * Returns the error if Failure, or the given default if Success.
     *
     * @template TDefault
     *
     * @param  TDefault  $default
     * @return TError|TDefault
     */
    final public function getErrorOr(mixed $default): mixed
    {
        return $this->isFailure() ? $this->getError() : $default;
    }

    /**
     * Runs a side effect with the value if Success. The callback's return value is ignored.
     *
     * @param  callable(TValue): mixed  $fn
     * @return static
     */
    final public function onSuccess(callable $fn): static
    {
        if ($this->isSuccess()) {
            $fn($this->getValue());
        }

        return $this;
    }

    /**
     * Runs a side effect with the error if Failure. The callback's return value is ignored.
     *
     * @param  callable(TError): mixed  $fn
     * @return static
     */
    final public function onFailure(callable $fn): static
    {
        if ($this->isFailure()) {
            $fn($this->getError());
        }

        return $this;
    }

    /**
     * Transforms the value of a Success. No-op on Failure.
     *
     * @template TNewValue
     *
     * @param  callable(TValue): TNewValue  $fn
     * @return Result<TNewValue, TError>
     */
    final public function map(callable $fn): self
    {
        return $this->isSuccess()
            ? new Success($fn($this->getValue()))
            : $this;
    }

    /**
     * Transforms the error of a Failure. No-op on Success.
     *
     * @template TNewError
     *
     * @param  callable(TError): TNewError  $fn
     * @return Result<TValue, TNewError>
     */
    final public function mapError(callable $fn): self
    {
        return $this->isFailure()
            ? new Failure($fn($this->getError()))
            : $this;
    }

    /**
     * Chains an operation that can fail. No-op on Failure.
     *
     * The error type widens to include the errors the next step can produce.
     *
     * @template TNewValue
     * @template TNewError
     *
     * @param  callable(TValue): Result<TNewValue, TNewError>  $fn
     * @return Result<TNewValue, TError|TNewError>
     */
    final public function flatMap(callable $fn): self
    {
        return $this->isSuccess()
            ? $fn($this->getValue())
            : $this;
    }

    /**
     * Converts a Failure into a Success using a fallback. No-op on Success.
     *
     * @template TNewValue
     *
     * @param  callable(TError): TNewValue  $fn
     * @return Success<TValue|TNewValue>
     */
    final public function recover(callable $fn): Success
    {
        return $this->isFailure()
            ? new Success($fn($this->getError()))
            : $this;
    }

    /**
     * Attempts to recover from a Failure with an operation that can itself fail. No-op on Success.
     *
     * @template TNewValue
     * @template TNewError
     *
     * @param  callable(TError): Result<TNewValue, TNewError>  $fn
     * @return Result<TValue|TNewValue, TNewError>
     */
    final public function recoverWith(callable $fn): self
    {
        return $this->isFailure()
            ? $fn($this->getError())
            : $this;
    }

    /**
     * Collapses both branches into a single value.
     *
     * @template TOutput
     *
     * @param  callable(TValue): TOutput  $onSuccess
     * @param  callable(TError): TOutput  $onFailure
     * @return TOutput
     */
    final public function fold(callable $onSuccess, callable $onFailure): mixed
    {
        return $this->isSuccess()
            ? $onSuccess($this->getValue())
            : $onFailure($this->getError());
    }
}
