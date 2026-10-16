<?php

declare(strict_types=1);

/**
 * Static type assertions, checked by PHPStan (not executed by Pest).
 */

use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Results;

use function PHPStan\Testing\assertType;

/** @return Result<int, string> */
function findId(int $id): Result
{
    return $id > 0 ? Results::success($id) : Results::failure('not found');
}

/** @param Result<int, string> $result */
function inference(Result $result): void
{
    assertType('ArielEspinoza07\ResultPattern\Success<int>', Results::success(1));
    assertType('ArielEspinoza07\ResultPattern\Failure<string>', Results::failure('x'));
    assertType('ArielEspinoza07\ResultPattern\Result<int, Throwable>', Results::attempt(fn (): int => 1));
    assertType('ArielEspinoza07\ResultPattern\Result<int, string>', Results::fromNullable(rand(0, 1) ? 1 : null, 'x'));

    assertType('ArielEspinoza07\ResultPattern\Result<bool, string>', $result->map(fn (int $x): bool => $x > 0));
    assertType('ArielEspinoza07\ResultPattern\Result<int, LogicException>', $result->mapError(fn (string $e): LogicException => new LogicException($e)));
    assertType('ArielEspinoza07\ResultPattern\Result<bool, LogicException|string>', $result->flatMap(
        fn (int $x): Result => $x > 0 ? Results::success(true) : Results::failure(new LogicException()),
    ));
    assertType('ArielEspinoza07\ResultPattern\Success<int>', $result->recover(fn (string $e): int => 0));
    assertType('ArielEspinoza07\ResultPattern\Result<int, LogicException>', $result->recoverWith(
        fn (string $e): Result => Results::failure(new LogicException($e)),
    ));
    assertType('int|null', $result->getValueOr(null));
    assertType('string|false', $result->getErrorOr(false));
    assertType('bool', $result->fold(fn (int $x): bool => true, fn (string $e): bool => false));

    // Side-effect callbacks may return anything; the original result comes back unchanged.
    assertType('ArielEspinoza07\ResultPattern\Result<int, string>', $result->onSuccess(fn (int $x): bool => true));

    if ($result->isSuccess()) {
        assertType('ArielEspinoza07\ResultPattern\Success<int>', $result);
    } else {
        assertType('ArielEspinoza07\ResultPattern\Failure<string>', $result);
    }

    assertType('ArielEspinoza07\ResultPattern\Result<list<int|string>, never>', Results::zip(Results::success(1), Results::success('a')));
    assertType('ArielEspinoza07\ResultPattern\Result<array<int, int>, non-empty-array<int, string>>', Results::collect([findId(1), findId(2)]));
    assertType('ArielEspinoza07\ResultPattern\Result<array<string, int>, non-empty-array<string, string>>', Results::collect(['id' => findId(1), 'age' => findId(2)]));
}
