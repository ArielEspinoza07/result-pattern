<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Results;

it('executes the callable on Success and returns the same result', function () {
    $captured = null;
    $original = Results::success(42);
    $returned = $original->onSuccess(function (int $v) use (&$captured): void {
        $captured = $v;
    });

    expect($captured)->toBe(42)
        ->and($returned)->toBe($original);
});

it('does not execute the callable on Failure', function () {
    $called = false;
    $result = Results::failure('err')
        ->onSuccess(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse()
        ->and($result->isFailure())->toBeTrue();
});

it('can be chained in a pipeline', function () {
    $log = [];
    $result = Results::success(5)
        ->map(fn (int $x) => $x * 2)
        ->onSuccess(function (int $v) use (&$log): void {
            $log[] = $v;
        })
        ->map(fn (int $x) => $x + 1)
        ->getValue();

    expect($result)->toBe(11)
        ->and($log)->toBe([10]);
});

it('accepts callbacks that return a value', function () {
    $cache = [];
    $result = Results::success('payload')
        ->onSuccess(function (string $v) use (&$cache): bool {
            $cache[] = $v;

            return true;
        });

    expect($result->getValue())->toBe('payload')
        ->and($cache)->toBe(['payload']);
});
