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
     * @param  callable(): TNewValue              $operation
     * @param  array<class-string<Throwable>>     $only       Classes to catch. Empty = catch all Throwable.
     * @return self<TNewValue, Throwable>
     */
    final public static function attempt(callable $operation, array $only = []): self
    {
        try {
            /** @var Success<TNewValue> */
            return self::success($operation());
        } catch (Throwable $e) {
            if ($only === [] || self::isInstanceOfAny($e, $only)) {
                /** @var Failure<Throwable> */
                return self::failure($e);
            }
            throw $e;
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
     * Converts a nullable value to a Result. null becomes Failure($error), anything else becomes Success($value).
     *
     * @template T
     * @template E
     *
     * @param  T|null  $value
     * @param  E  $error
     * @return self<T, E>
     */
    final public static function fromNullable(mixed $value, mixed $error): self
    {
        return $value !== null ? new Success($value) : new Failure($error);
    }

    /**
     * Combines multiple Results into one. If all are Success, returns Success with an array of their values.
     * If any is Failure, returns the first Failure encountered.
     *
     * @param  self<mixed, mixed>  ...$results
     * @return self<array<int, mixed>, mixed>
     */
    final public static function zip(self ...$results): self
    {
        $values = [];
        foreach ($results as $result) {
            if ($result->isFailure()) {
                return $result; // @phpstan-ignore return.type
            }
            $values[] = $result->getValue();
        }

        return new Success($values); // @phpstan-ignore return.type
    }

    /**
     * Processes all results and collects outcomes.
     * All succeed  → Success<array<int, mixed>> with all values.
     * Any fail     → Failure<array<int, mixed>> with ALL errors (not just the first).
     *
     * Use zip() instead if you want fail-fast (short-circuit on first failure).
     *
     * @param  array<array-key, self<mixed, mixed>>  $results
     * @return self<array<int, mixed>, array<int, mixed>>
     */
    final public static function collect(array $results): self
    {
        $values = [];
        $errors = [];

        foreach (array_values($results) as $result) {
            if ($result->isSuccess()) {
                $values[] = $result->getValue();
            } else {
                $errors[] = $result->getError();
            }
        }

        return $errors !== [] // @phpstan-ignore return.type
            ? new Failure($errors)
            : new Success($values);
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
     * Like flatMap() but operates on the error side. Transforms a Failure by returning a new Result.
     * No-op on Success.
     *
     * @template TNewValue
     * @template TNewError
     *
     * @param  callable(TError): self<TNewValue, TNewError>  $fn
     * @return self<TValue|TNewValue, TNewError>
     */
    final public function flatMapError(callable $fn): self
    {
        return $this->isFailure() ? $fn($this->getError()) : $this; // @phpstan-ignore return.type
    }

    /**
     * Like recover() but the recovery callable may itself return a Result (which can be Failure).
     * No-op on Success.
     *
     * @template TNewValue
     * @template TNewError
     *
     * @param  callable(TError): self<TNewValue, TNewError>  $fn
     * @return self<TValue|TNewValue, TNewError>
     */
    final public function recoverWith(callable $fn): self
    {
        return $this->isFailure() ? $fn($this->getError()) : $this; // @phpstan-ignore return.type
    }

    /**
     * Runs a side-effect callable on the value if Success, then returns $this unchanged.
     * Alias of onSuccess() with a pipeline-friendly name.
     *
     * @param  callable(TValue): void  $fn
     * @return self<TValue, TError>
     */
    final public function tap(callable $fn): self
    {
        return $this->onSuccess($fn);
    }

    /**
     * Returns the value if Success, or null if Failure.
     *
     * @return TValue|null
     */
    final public function toNullable(): mixed
    {
        return $this->isSuccess() ? $this->getValue() : null;
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

    /** @param array<class-string<Throwable>> $classes */
    private static function isInstanceOfAny(Throwable $e, array $classes): bool
    {
        foreach ($classes as $class) {
            if ($e instanceof $class) {
                return true;
            }
        }
        return false;
    }
}
