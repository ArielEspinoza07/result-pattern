<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns success for successful operation', function () {
    $result = Result::attempt(fn (): int => 42);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(42);
});

it('returns failure for throwing operation', function () {
    $exception = new RuntimeException('attempt error');
    $result = Result::attempt(function () use ($exception): void {
        throw $exception;
    });

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($exception);
});

it('captures TypeError', function () {
    $result = Result::attempt(function (): int {
        throw new TypeError('type mismatch');
    });

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBeInstanceOf(TypeError::class);
});

it('captures ValueError', function () {
    $result = Result::attempt(function (): int {
        throw new ValueError('value error');
    });

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBeInstanceOf(ValueError::class);
});
