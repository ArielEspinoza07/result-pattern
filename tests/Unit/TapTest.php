<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Result;

it('executes the callable on Success and returns the same result', function () {
    $captured = null;
    $original = Result::success(42);
    $returned = $original->tap(function (int $v) use (&$captured): void {
        $captured = $v;
    });

    expect($captured)->toBe(42)
        ->and($returned)->toBe($original);
});

it('does not execute the callable on Failure', function () {
    $called = false;
    $result = Result::failure('err')
        ->tap(function () use (&$called): void {
            $called = true;
        });

    expect($called)->toBeFalse()
        ->and($result->isFailure())->toBeTrue();
});

it('can be chained in a pipeline', function () {
    $log = [];
    $result = Result::success(5)
        ->map(fn (int $x) => $x * 2)
        ->tap(function (int $v) use (&$log): void {
            $log[] = $v;
        })
        ->map(fn (int $x) => $x + 1)
        ->getValue();

    expect($result)->toBe(11)
        ->and($log)->toBe([10]);
});
