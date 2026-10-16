<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;

it('returns Success with array of values when all results succeed', function () {
    $result = Results::zip(
        Results::success(1),
        Results::success(2),
        Results::success(3),
    );

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([1, 2, 3]);
});

it('returns first Failure when any result fails', function () {
    $result = Results::zip(
        Results::success(1),
        Results::failure('oops'),
        Results::success(3),
    );

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('oops');
});

it('returns first Failure when multiple results fail', function () {
    $result = Results::zip(
        Results::failure('first error'),
        Results::failure('second error'),
    );

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('first error');
});

it('returns Success with empty array when no arguments given', function () {
    $result = Results::zip();

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([]);
});
