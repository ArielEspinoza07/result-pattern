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

it('returns first Failure when any result fails', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        Result::success('a'),
        Result::failure('fail'),
        Result::success('c'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe('fail');
});

it('returns Success with empty array for empty input', function () {
    $result = Result::collect([]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([]);
});

it('preserves values in order regardless of key', function () {
    $result = Result::collect([ // @phpstan-ignore argument.type
        'a' => Result::success(1),
        'b' => Result::success(2),
    ]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([1, 2]);
});
