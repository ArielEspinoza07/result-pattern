<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns Success with array of values when all results succeed', function () {
    $result = Result::zip(
        Result::success(1), // @phpstan-ignore argument.type
        Result::success(2), // @phpstan-ignore argument.type
        Result::success(3), // @phpstan-ignore argument.type
    );

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([1, 2, 3]);
});

it('returns first Failure when any result fails', function () {
    $result = Result::zip(
        Result::success(1), // @phpstan-ignore argument.type
        Result::failure('oops'), // @phpstan-ignore argument.type
        Result::success(3), // @phpstan-ignore argument.type
    );

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('oops');
});

it('returns first Failure when multiple results fail', function () {
    $result = Result::zip(
        Result::failure('first error'), // @phpstan-ignore argument.type
        Result::failure('second error'), // @phpstan-ignore argument.type
    );

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('first error');
});

it('returns Success with empty array when no arguments given', function () {
    $result = Result::zip();

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([]);
});
