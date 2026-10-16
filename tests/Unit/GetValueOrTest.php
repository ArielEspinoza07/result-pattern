<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;

it('returns value when success', function () {
    $result = Results::success(42);

    expect($result->getValueOr(0))->toBe(42);
});

it('returns default when failure', function () {
    $result = Results::failure('error');

    expect($result->getValueOr(0))->toBe(0);
});

it('returns null default when failure', function () {
    $result = Results::failure('error');

    expect($result->getValueOr(null))->toBeNull();
});

it('returns falsy values of a Success instead of the default', function (mixed $value) {
    expect(Results::success($value)->getValueOr('default'))->toBe($value);
})->with([
    'false' => [false],
    'zero' => [0],
    'empty string' => [''],
    'empty array' => [[]],
]);
