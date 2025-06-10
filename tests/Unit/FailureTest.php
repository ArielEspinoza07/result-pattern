<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Failure;
use ArielEspinoza07\ResultPattern\Result;

it('creates failure result', function () {
    $result = Result::failure('error message');

    expect($result)
        ->toBeInstanceOf(Failure::class)
        ->and($result->isSuccess())
        ->toBeFalse()
        ->and($result->isFailure())
        ->toBeTrue()
        ->and($result->getError())
        ->toBe('error message');
});

it('throws when getting value from failure', function () {
    $result = Result::failure('error');

    expect(fn () => $result->getValue())->toThrow(RuntimeException::class);
});

it('ignores map', function () {
    $original = Result::failure('original error');
    $result = $original->map(fn ($x) => $x * 3);

    expect($result)->toBe($original);
});

it('ignores flatMap', function () {
    $original = Result::failure('original error');
    $result = $original->flatMap(fn ($x) => Result::success(42));

    expect($result)->toBe($original);
});

it('executes onFailure callback', function () {
    $called = false;
    Result::failure('test error')
        ->onFailure(function (string $error) use (&$called) {
            $called = true;
            expect($error)->toBe('test error');
        });

    expect($called)->toBeTrue();
});

it('folds failure correctly', function () {
    $value = Result::failure('error')
        ->fold(
            onSuccess: fn ($x) => $x * 2,
            onFailure: fn (string $e): int => 0
        );

    expect($value)->toBe(0);
});
