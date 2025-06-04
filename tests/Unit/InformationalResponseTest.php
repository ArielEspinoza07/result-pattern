<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\ContinueResult;
use ArielEspinoza07\ResultPattern\EarlyHints;
use ArielEspinoza07\ResultPattern\Processing;
use ArielEspinoza07\ResultPattern\SwitchingProtocols;

test('continue response result', function() {
    $result = ContinueResult::from('Continue with request');

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Continue with request')
        ->and($result->status())->toBe(100);
});

test('switching protocols result', function() {
    $result = SwitchingProtocols::from('Switching to WebSocket');

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Switching to WebSocket')
        ->and($result->status())->toBe(101);
});

test('processing result', function() {
    $result = Processing::from('Processing request');

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Processing request')
        ->and($result->status())->toBe(102);
});

test('early hints result', function() {
    $result = EarlyHints::from('Early hints available');

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Early hints available')
        ->and($result->status())->toBe(103);
});
