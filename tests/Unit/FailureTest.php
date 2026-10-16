<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Exceptions\InvalidResultAccessException;
use ArielEspinoza07\ResultPattern\Failure;
use ArielEspinoza07\ResultPattern\Results;

it('creates failure result', function () {
    $result = Results::failure('error message');

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
    $result = Results::failure('error');

    expect(fn () => $result->getValue())->toThrow(InvalidResultAccessException::class);
});

it('ignores map', function () {
    $original = Results::failure('original error');
    $result = $original->map(fn ($x) => $x * 3);

    expect($result)->toBe($original);
});

it('ignores flatMap', function () {
    $original = Results::failure('original error');
    $result = $original->flatMap(fn ($x) => Results::success(42));

    expect($result)->toBe($original);
});

it('executes onFailure callback', function () {
    $called = false;
    Results::failure('test error')
        ->onFailure(function (string $error) use (&$called) {
            $called = true;
            expect($error)->toBe('test error');
        });

    expect($called)->toBeTrue();
});

it('folds failure correctly', function () {
    $value = Results::failure('error')
        ->fold(
            onSuccess: fn ($x) => $x * 2,
            onFailure: fn (string $e): int => 0
        );

    expect($value)->toBe(0);
});

it('names the error type when getting the value', function () {
    expect(fn () => Results::failure('boom')->getValue())
        ->toThrow(InvalidResultAccessException::class, 'Cannot get the value of a Failure (error type: string).');
});

it('chains a Throwable error as the previous exception', function () {
    $cause = new RuntimeException('database is down');

    $thrown = null;

    try {
        Results::failure($cause)->getValue();
    } catch (InvalidResultAccessException $e) {
        $thrown = $e;
    }

    expect($thrown)->toBeInstanceOf(InvalidResultAccessException::class)
        ->and($thrown->getPrevious())->toBe($cause);
});

it('has no previous exception when the error is not a Throwable', function () {
    $thrown = null;

    try {
        Results::failure('boom')->getValue();
    } catch (InvalidResultAccessException $e) {
        $thrown = $e;
    }

    expect($thrown)->toBeInstanceOf(InvalidResultAccessException::class)
        ->and($thrown->getPrevious())->toBeNull();
});
