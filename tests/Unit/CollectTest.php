<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;

it('returns Success with array of values when all results succeed', function () {
    $result = Results::collect([
        Results::success('a'),
        Results::success('b'),
        Results::success('c'),
    ]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(['a', 'b', 'c']);
});

it('returns Failure with ALL errors when multiple results fail', function () {
    $result = Results::collect([
        Results::success('a'),
        Results::failure('fail1'),
        Results::failure('fail2'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe([1 => 'fail1', 2 => 'fail2']);
});

it('returns Failure with single error when one result fails', function () {
    $result = Results::collect([
        Results::success('a'),
        Results::failure('fail'),
        Results::success('c'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe([1 => 'fail']);
});

it('returns Success with empty array for empty input', function () {
    $result = Results::collect([]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe([]);
});

it('keeps each error at the index of the result that produced it', function () {
    $result = Results::collect([
        Results::success(1),
        Results::failure('e1'),
        Results::success(2),
        Results::failure('e2'),
    ]);

    expect($result->isFailure())->toBeTrue()
        ->and($result->getError())->toBe([1 => 'e1', 3 => 'e2']);
});

it('preserves string keys of successful values', function () {
    $result = Results::collect([
        'a' => Results::success(1),
        'b' => Results::success(2),
    ]);

    expect($result->isSuccess())->toBeTrue()
        ->and($result->getValue())->toBe(['a' => 1, 'b' => 2]);
});

it('traces each validation error back to its field', function () {
    $result = Results::collect([
        'name' => Results::success('Ariel'),
        'email' => Results::failure('must be a valid email'),
        'age' => Results::failure('must be at least 18'),
    ]);

    expect($result->getError())->toBe([
        'email' => 'must be a valid email',
        'age' => 'must be at least 18',
    ]);
});
