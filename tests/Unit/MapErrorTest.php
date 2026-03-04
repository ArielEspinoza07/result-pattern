<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('transforms error on failure', function () {
    $result = Result::failure('raw error')
        ->mapError(fn (string $e): string => mb_strtoupper($e));

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('RAW ERROR');
});

it('is a no-op on success', function () {
    $original = Result::success(42);
    $result = $original->mapError(fn ($e): string => 'transformed');

    expect($result)->toBe($original)
        ->and($result->getValue())->toBe(42);
});

it('can change error type', function () {
    $exception = new RuntimeException('fail');
    $result = Result::failure($exception)
        ->mapError(fn (RuntimeException $e): string => $e->getMessage());

    expect($result->getError())->toBe('fail');
});
