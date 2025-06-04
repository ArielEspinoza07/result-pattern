<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\HttpVersionNotSupported;
use ArielEspinoza07\ResultPattern\VariantAlsoNegotiates;
use ArielEspinoza07\ResultPattern\InsufficientStorage;
use ArielEspinoza07\ResultPattern\LoopDetected;
use ArielEspinoza07\ResultPattern\NotExtended;
use ArielEspinoza07\ResultPattern\NetworkAuthenticationRequired;

test('http version not supported result', function () {
    $data = ['version' => 'HTTP/3.0'];
    $result = HttpVersionNotSupported::fromMessageAndData('HTTP version not supported', $data);
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('HTTP version not supported')
        ->and($result->status())->toBe(505)
        ->and($result->data())->toBe($data);
});

test('variant also negotiates result', function () {
    $result = VariantAlsoNegotiates::from('Variant also negotiates');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Variant also negotiates')
        ->and($result->status())->toBe(506);
});

test('insufficient storage result', function () {
    $data = ['available' => '100MB'];
    $result = InsufficientStorage::fromMessageAndData('Insufficient storage', $data);
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Insufficient storage')
        ->and($result->status())->toBe(507)
        ->and($result->data())->toBe($data);
});

test('loop detected result', function () {
    $result = LoopDetected::from('Infinite loop detected');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Infinite loop detected')
        ->and($result->status())->toBe(508);
});

test('not extended result', function () {
    $result = NotExtended::from('Not extended');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Not extended')
        ->and($result->status())->toBe(510);
});

test('network authentication required result', function () {
    $data = ['auth_url' => 'https://auth.example.com'];
    $result = NetworkAuthenticationRequired::fromMessageAndData('Network authentication required', $data);
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Network authentication required')
        ->and($result->status())->toBe(511)
        ->and($result->data())->toBe($data);
});
