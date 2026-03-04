<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns Success with array of values when all results succeed', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        Result::success('a'),
        Result::success('b'),
        Result::success('c'),
    ]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(['a', 'b', 'c']);
});

it('returns Failure with ALL errors when multiple results fail', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        Result::success('a'),
        Result::failure('fail1'),
        Result::failure('fail2'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe(['fail1', 'fail2']);
});

it('returns Failure with single error when one result fails', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        Result::success('a'),
        Result::failure('fail'),
        Result::success('c'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe(['fail']);
});

it('returns Success with empty array for empty input', function () {
    $result = Result::collect([]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([]);
});

it('preserves order of values and errors', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        Result::success(1),
        Result::failure('e1'),
        Result::success(2),
        Result::failure('e2'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe(['e1', 'e2']);
});

it('preserves values in order regardless of key', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        'a' => Result::success(1),
        'b' => Result::success(2),
    ]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([1, 2]);
});
