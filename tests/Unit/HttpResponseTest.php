<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Accepted;
use ArielEspinoza07\ResultPattern\BadGateway;
use ArielEspinoza07\ResultPattern\MethodNotAllowed;
use ArielEspinoza07\ResultPattern\NotAcceptable;
use ArielEspinoza07\ResultPattern\PayloadTooLarge;
use ArielEspinoza07\ResultPattern\ServiceUnavailable;
use ArielEspinoza07\ResultPattern\UnprocessableEntity;

test('accepted result', function () {
    $result = Accepted::from('Request accepted');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Request accepted')
        ->and($result->status())->toBe(202);
});

test('method not allowed result', function () {
    $result = MethodNotAllowed::from('POST method not allowed');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('POST method not allowed')
        ->and($result->status())->toBe(405);
});

test('not acceptable result', function () {
    $result = NotAcceptable::from('Content type not acceptable');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Content type not acceptable')
        ->and($result->status())->toBe(406);
});

test('payload too large result', function () {
    $result = PayloadTooLarge::from('File size exceeds limit');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('File size exceeds limit')
        ->and($result->status())->toBe(413);
});

test('unprocessable entity result', function () {
    $data = ['errors' => ['name' => 'Required']];
    $result = UnprocessableEntity::fromMessageAndData('Validation failed', $data);
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Validation failed')
        ->and($result->status())->toBe(422)
        ->and($result->data())->toBe($data);
});

test('bad gateway result', function () {
    $result = BadGateway::from('External service unavailable');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('External service unavailable')
        ->and($result->status())->toBe(502);
});

test('service unavailable result', function () {
    $result = ServiceUnavailable::from('System maintenance');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('System maintenance')
        ->and($result->status())->toBe(503);
});
