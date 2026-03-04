<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('transforms Failure into a new Success via flatMapError', function () {
    $result = Result::failure('db_error')
        ->flatMapError(fn (string $e) => Result::success("recovered from: {$e}"));

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe('recovered from: db_error');
});

it('transforms Failure into a new Failure via flatMapError', function () {
    $result = Result::failure('original')
        ->flatMapError(fn (string $e) => Result::failure("wrapped: {$e}"));

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('wrapped: original');
});

it('is a no-op on Success', function () {
    $called = false;
    $result = Result::success(42)
        ->flatMapError(function () use (&$called): Result {
            $called = true;

            return Result::failure('should not run'); // @phpstan-ignore return.never
        });

    expect($called)->toBeFalse()
        ->and($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(42);
});
