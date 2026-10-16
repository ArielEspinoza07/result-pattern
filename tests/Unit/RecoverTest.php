<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;
use ArielEspinoza07\ResultPattern\Success;

it('converts failure to success using fallback', function () {
    $result = Results::failure('error')
        ->recover(fn (string $e): int => 0);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(0);
});

it('is a no-op on success', function () {
    $original = Results::success(42);
    $result = $original->recover(fn ($e): int => 0);

    expect($result)->toBe($original)
        ->and($result->getValue())->toBe(42);
});

it('returns a Success instance after recovering', function () {
    $result = Results::failure('any error')
        ->recover(fn (string $e): string => 'recovered');

    expect($result)->toBeInstanceOf(Success::class)
        ->and($result->getValue())->toBe('recovered');
});
