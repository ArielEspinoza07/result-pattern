<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('returns value when success', function () {
    $result = Result::success(42);

    expect($result->getValueOr(0))->toBe(42);
});

it('returns default when failure', function () {
    $result = Result::failure('error');

    expect($result->getValueOr(0))->toBe(0);
});

it('returns null default when failure', function () {
    $result = Result::failure('error');

    expect($result->getValueOr(null))->toBeNull();
});
