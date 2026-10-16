<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern;

use Throwable;

/**
 * Named constructors and combinators for {@see Result}.
 */
final class Results
{
    private function __construct() {}

    /**
     * @template T
     *
     * @param  T  $value
     * @return Success<T>
     */
    public static function success(mixed $value): Success
    {
        return new Success($value);
    }

    /**
     * @template E
     *
     * @param  E  $error
     * @return Failure<E>
     */
    public static function failure(mixed $error): Failure
    {
        return new Failure($error);
    }

    /**
     * Runs an operation and turns a thrown exception into a Failure.
     *
     * Exceptions not listed in $only are re-thrown. An empty list catches every Throwable.
     *
     * @template T
     *
     * @param  callable(): T  $operation
     * @param  list<class-string<Throwable>>  $only
     * @return Result<T, Throwable>
     */
    public static function attempt(callable $operation, array $only = []): Result
    {
        try {
            return new Success($operation());
        } catch (Throwable $e) {
            if ($only === [] || self::isInstanceOfAny($e, $only)) {
                return new Failure($e);
            }

            throw $e;
        }
    }

    /**
     * Turns null into Failure($error) and any other value into Success($value).
     *
     * @template T
     * @template E
     *
     * @param  T|null  $value
     * @param  E  $error
     * @return Result<T, E>
     */
    public static function fromNullable(mixed $value, mixed $error): Result
    {
        return $value !== null ? new Success($value) : new Failure($error);
    }

    /**
     * Combines results, failing fast: returns the first Failure, or a Success with every value in order.
     *
     * Use collect() to gather every error instead.
     *
     * @template T = mixed
     * @template E = mixed
     *
     * @param  Result<T, E>  ...$results
     * @return Result<list<T>, E>
     */
    public static function zip(Result ...$results): Result
    {
        $values = [];

        foreach ($results as $result) {
            if ($result->isFailure()) {
                return $result;
            }

            $values[] = $result->getValue();
        }

        return new Success($values);
    }

    /**
     * Combines results, processing all of them: returns a Failure with every error,
     * or a Success with every value. Keys are preserved on both sides, so each error
     * can be traced back to the input that produced it.
     *
     * Use zip() to stop at the first failure instead.
     *
     * @template K of array-key = array-key
     * @template T = mixed
     * @template E = mixed
     *
     * @param  array<K, Result<T, E>>  $results
     * @return Result<array<K, T>, non-empty-array<K, E>>
     */
    public static function collect(array $results): Result
    {
        $values = [];
        $errors = [];

        foreach ($results as $key => $result) {
            if ($result->isSuccess()) {
                $values[$key] = $result->getValue();
            } else {
                $errors[$key] = $result->getError();
            }
        }

        return $errors !== []
            ? new Failure($errors)
            : new Success($values);
    }

    /** @param list<class-string<Throwable>> $classes */
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
