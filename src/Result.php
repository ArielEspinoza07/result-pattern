<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use Throwable;

/**
 * @template TValue
 * @template TError
 */
abstract readonly class Result
{
    abstract public function isSuccess(): bool;

    abstract public function isFailure(): bool;

    /** @return TValue */
    abstract public function getValue(): mixed;

    /** @return TError */
    abstract public function getError(): mixed;

    /**
     * @template T
     *
     * @param  T  $value
     * @return self<T, never>
     */
    final public static function success(mixed $value): self
    {
        return new Success($value);
    }

    /**
     * @template E
     *
     * @param  E  $error
     * @return self<never, E>
     */
    final public static function failure(mixed $error): self
    {
        return new Failure($error);
    }

    /**
     * Executes an operation and catches exceptions as Failure.
     *
     * @template TNewValue
     *
     * @param  callable(): TNewValue  $operation
     * @return self<TNewValue, Throwable>
     */
    final public static function attempt(callable $operation): self
    {
        try {
            /** @var Success<TNewValue> */
            return self::success($operation());
        } catch (Throwable $e) {
            /** @var Failure<Throwable> */
            return self::failure($e);
        }
    }

    /**
     * @deprecated Use attempt() instead. 'try' is a PHP reserved keyword that causes IDE friction.
     *
     * @template TNewValue
     *
     * @param  callable(): TNewValue  $operation
     * @return self<TNewValue, Throwable>
     */
    final public static function try(callable $operation): self
    {
        return self::attempt($operation);
    }

    /**
     * Executes a callback if it is a Success.
     *
     * @param  callable(TValue): void  $fn
     * @return self<TValue, TError>
     */
    final public function onSuccess(callable $fn): self
    {
        if ($this->isSuccess()) {
            $fn($this->getValue());
        }

        return $this;
    }

    /**
     * Executes a callback if it is Failure.
     *
     * @param  callable(TError): void  $fn
     * @return self<TValue, TError>
     */
    final public function onFailure(callable $fn): self
    {
        if ($this->isFailure()) {
            $fn($this->getError());
        }

        return $this;
    }

    /**
     * Returns the value if Success, or the given default if Failure.
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
     * Transforms the error of a Failure. No-op on Success.
     *
     * @template TNewError
     *
     * @param  callable(TError): TNewError  $fn
     * @return self<TValue, TNewError>
     */
    final public function mapError(callable $fn): self
    {
        return $this->isFailure()
            ? new Failure($fn($this->getError()))
            : $this;
    }

    /**
     * Converts a Failure into a Success using a fallback callable. No-op on Success.
     *
     * @template TNewValue
     *
     * @param  callable(TError): TNewValue  $fn
     * @return self<TValue|TNewValue, never>
     */
    final public function recover(callable $fn): self
    {
        return $this->isFailure() // @phpstan-ignore return.type
            ? new Success($fn($this->getError()))
            : $this;
    }

    /**
     * @template TNewValue
     *
     * @param  callable(TValue): TNewValue  $fn
     * @return self<TNewValue, TError>
     */
    final public function map(callable $fn): self
    {
        return $this->isSuccess()
            ? new Success($fn($this->getValue()))
            : $this;
    }

    /**
     * @template TNewValue
     *
     * @param  callable(TValue): self<TNewValue, TError>  $fn
     * @return self<TNewValue, TError>
     */
    final public function flatMap(callable $fn): self
    {
        return $this->isSuccess() ? $fn($this->getValue()) : $this;
    }

    /**
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
