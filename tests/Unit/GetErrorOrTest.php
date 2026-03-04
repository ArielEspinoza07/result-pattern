<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns error when failure', function () {
    $result = Result::failure('something went wrong');

    expect($result->getErrorOr(null))->toBe('something went wrong');
});

it('returns default when success', function () {
    $result = Result::success(42);

    expect($result->getErrorOr('no error'))->toBe('no error');
});

it('returns null default when success', function () {
    $result = Result::success('data');

    expect($result->getErrorOr(null))->toBeNull();
});
