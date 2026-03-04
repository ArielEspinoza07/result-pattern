<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns the value for Success', function () {
    $result = Result::success(42);

    expect($result->toNullable())->toBe(42);
});

it('returns null for Failure', function () {
    $result = Result::failure('error');

    expect($result->toNullable())->toBeNull();
});

it('returns false for Success(false)', function () {
    $result = Result::success(false);

    expect($result->toNullable())->toBeFalse();
});

it('returns zero for Success(0)', function () {
    $result = Result::success(0);

    expect($result->toNullable())->toBe(0);
});

it('returns empty string for Success empty string', function () {
    $result = Result::success('');

    expect($result->toNullable())->toBe('');
});
