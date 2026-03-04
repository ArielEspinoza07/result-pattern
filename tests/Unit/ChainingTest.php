<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('chains map, flatMap, onSuccess, fold correctly', function () {
    $result = Result::success(2)
        ->map(fn (int $x): int => $x * 10)
        ->flatMap(fn (int $x): Result => Result::success($x + 5))
        ->onSuccess(fn (int $x) => expect($x)->toBe(25)) // @phpstan-ignore argument.type
        ->fold(
            onSuccess: fn (int $x): string => "value:{$x}",
            onFailure: fn ($e): string => 'error'
        );

    expect($result)->toBe('value:25');
});

it('short-circuits on first failure in chain', function () {
    $mapCalled = false;
    $result = Result::failure('initial error')
        ->map(function (mixed $x) use (&$mapCalled): mixed {
            $mapCalled = true;

            return $x; // @phpstan-ignore return.never
        })
        ->flatMap(function (mixed $x): Result {
            return Result::success($x);
        })
        ->fold(
            onSuccess: fn ($x): string => 'success',
            onFailure: fn (string $e): string => "failed:{$e}"
        );

    expect($mapCalled)->toBeFalse()
        ->and($result)->toBe('failed:initial error');
});

it('onSuccess is not called on failure', function () {
    $called = false;
    Result::failure('error')
        ->onSuccess(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse();
});

it('onFailure is not called on success', function () {
    $called = false;
    Result::success(42)
        ->onFailure(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse();
});

it('onSuccess and onFailure can be chained on the same result', function () {
    $successCalled = false;
    $failureCalled = false;

    Result::success(42)
        ->onSuccess(function () use (&$successCalled): void {
            $successCalled = true;
        })
        ->onFailure(function () use (&$failureCalled): void {
            $failureCalled = true;
        });

    expect($successCalled)->toBeTrue()
        ->and($failureCalled)->toBeFalse();
});

it('recover then map produces expected value', function () {
    $result = Result::failure('oops')
        ->recover(fn (string $e): int => 0)
        ->map(fn (int $x): int => $x + 100)
        ->getValueOr(-1);

    expect($result)->toBe(100);
});
