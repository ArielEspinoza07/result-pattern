<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

// These tests cover the deprecated Result::try() method for backwards-compatibility.
// The canonical method is Result::attempt() — see AttemptTest.php.

it('returns success for successful operation', function () {
    /** @phpstan-ignore staticMethod.deprecated */
    $result = Result::try(fn (): int => 42);

    expect($result->isSuccess())
        ->toBeTrue()
        ->and($result->getValue())
        ->toBe(42);
});

it('returns failure for throwing operation', function () {
    $exception = new RuntimeException('Test error');
    /** @phpstan-ignore staticMethod.deprecated */
    $result = Result::try(function () use ($exception): int {
        throw $exception;
    });

    expect($result->isFailure())
        ->toBeTrue()
        ->and($result->getError())
        ->toBe($exception);
});

it('captures any throwable', function () {
    $error = new Error('Fatal error');
    /** @phpstan-ignore staticMethod.deprecated */
    $result = Result::try(function () use ($error): void {
        throw $error;
    });

    expect($result->isFailure())
        ->toBeTrue()
        ->and($result->getError())
        ->toBe($error);
});
