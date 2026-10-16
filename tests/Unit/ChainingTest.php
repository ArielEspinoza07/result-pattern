<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Results;

it('chains map, flatMap, onSuccess, fold correctly', function () {
    $result = Results::success(2)
        ->map(fn (int $x): int => $x * 10)
        ->flatMap(fn (int $x): Result => Results::success($x + 5))
        ->onSuccess(fn (int $x) => expect($x)->toBe(25))
        ->fold(
            onSuccess: fn (int $x): string => "value:{$x}",
            onFailure: fn ($e): string => 'error'
        );

    expect($result)->toBe('value:25');
});

it('short-circuits on first failure in chain', function () {
    $result = Results::failure('initial error')
        ->map(fn (): never => throw new LogicException('map must not run on a Failure'))
        ->flatMap(fn (int $x): Result => Results::success($x + 1))
        ->fold(
            onSuccess: fn (): string => 'success',
            onFailure: fn (string $e): string => "failed:{$e}"
        );

    expect($result)->toBe('failed:initial error');
});

it('onSuccess is not called on failure', function () {
    $called = false;
    Results::failure('error')
        ->onSuccess(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse();
});

it('onFailure is not called on success', function () {
    $called = false;
    Results::success(42)
        ->onFailure(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse();
});

it('onSuccess and onFailure can be chained on the same result', function () {
    $successCalled = false;
    $failureCalled = false;

    Results::success(42)
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
    $result = Results::failure('oops')
        ->recover(fn (string $e): int => 0)
        ->map(fn (int $x): int => $x + 100)
        ->getValueOr(-1);

    expect($result)->toBe(100);
});
