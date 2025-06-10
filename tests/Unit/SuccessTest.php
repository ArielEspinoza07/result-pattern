<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Success;

it('creates success result', function () {
    $result = Result::success(42);

    expect($result)
        ->toBeInstanceOf(Success::class)
        ->and($result->isSuccess())
        ->toBeTrue()
        ->and($result->isFailure())
        ->toBeFalse()
        ->and($result->getValue())
        ->toBe(42);
});

it('throws when getting error from success', function () {
    $result = Result::success('data');

    expect(fn () => $result->getError())->toThrow(RuntimeException::class);
});

it('maps value correctly', function () {
    $result = Result::success(2)
                    ->map(fn (int $x): int => $x * 3);

    expect($result->getValue())->toBe(6);
});

it('flatMaps to new success', function () {
    $result = Result::success(2)
                    ->flatMap(fn (int $x): Result => Result::success($x * 3));

    expect($result->getValue())->toBe(6);
});

it('flatMaps to failure', function () {
    $result = Result::success(2)
                    ->flatMap(function (int $x): Result {
                        return Result::failure('Mapped error');
                    });

    expect($result->isFailure())
        ->toBeTrue()
        ->and($result->getError())
        ->toBe('Mapped error');
});

it('executes onSuccess callback', function () {
    $called = false;
    Result::success(42)
        ->onSuccess(function (int $value) use (&$called) {
            $called = true;
            expect($value)->toBe(42);
        });

    expect($called)->toBeTrue();
});

it('folds success correctly', function () {
    $value = Result::success(42)
        ->fold(
            onSuccess: fn (int $x): int => $x * 2,
            onFailure: fn ($e): int => 0
        );

    expect($value)->toBe(84);
});
