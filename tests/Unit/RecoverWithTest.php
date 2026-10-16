<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;
use ArielEspinoza07\ResultPattern\Results;

it('converts Failure to Success when recovery succeeds', function () {
    $result = Results::failure('db_error')
        ->recoverWith(fn (string $e) => Results::success('fallback value'));

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe('fallback value');
});

it('propagates Failure when recovery also fails', function () {
    $result = Results::failure('original')
        ->recoverWith(fn (string $e) => Results::failure("recovery failed: {$e}"));

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('recovery failed: original');
});

it('is a no-op on Success', function () {
    $called = false;
    $result = Results::success(42)
        ->recoverWith(function () use (&$called): Result {
            $called = true;

            return Results::success(0);
        });

    expect($called)->toBeFalse()
        ->and($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(42);
});

it('passes the error value to the recovery callable', function () {
    $capturedError = null;
    Results::failure('the error')
        ->recoverWith(function (string $e) use (&$capturedError): Result {
            $capturedError = $e;

            return Results::success('ok');
        });

    expect($capturedError)->toBe('the error');
});

it('chains after recoverWith', function () {
    $result = Results::failure('err')
        ->recoverWith(fn ($e) => Results::success(0))
        ->map(fn (int $x) => $x + 100)
        ->getValueOr(-1);

    expect($result)->toBe(100);
});
