<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;

it('returns Success for non-null value', function () {
    $result = Results::fromNullable(42, 'error');

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(42);
});

it('returns Failure for null value', function () {
    $result = Results::fromNullable(null, 'not found');

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('not found');
});

it('returns Success for false (not null)', function () {
    $result = Results::fromNullable(false, 'error');

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBeFalse();
});

it('returns Success for empty string (not null)', function () {
    $result = Results::fromNullable('', 'error');

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe('');
});

it('returns Success for zero (not null)', function () {
    $result = Results::fromNullable(0, 'error');

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(0);
});

it('accepts object as error', function () {
    $error = new RuntimeException('not found');
    $result = Results::fromNullable(null, $error);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe($error);
});
