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

it('re-throws exception not in $only list', function () {
    expect(fn () => Result::attempt(
        fn () => throw new RuntimeException('oops'),
        [InvalidArgumentException::class]
    ))->toThrow(RuntimeException::class);
});

it('catches exception that matches $only exactly', function () {
    $e = new RuntimeException('boom');
    $result = Result::attempt(fn () => throw $e, [RuntimeException::class]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($e);
});

it('catches subclass of exception in $only', function () {
    // InvalidArgumentException extends LogicException
    $e = new InvalidArgumentException('bad arg');
    $result = Result::attempt(fn () => throw $e, [LogicException::class]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($e);
});

it('catches any of multiple classes in $only', function () {
    $e = new OverflowException('overflow');
    $result = Result::attempt(
        fn () => throw $e,
        [InvalidArgumentException::class, OverflowException::class]
    );

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($e);
});

it('empty $only catches everything (backward compat)', function () {
    $e = new TypeError('type error');
    $result = Result::attempt(fn () => throw $e);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($e);
});
