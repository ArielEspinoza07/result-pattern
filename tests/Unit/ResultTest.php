<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\NotFound;

test('ok result creation', function () {
    $result = Ok::from('Success');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Success')
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe([]);
});

test('ok result with data', function () {
    $data = ['id' => 1];
    $result = Ok::fromMessageAndData('Success', $data);
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Success')
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe($data);
});

test('not found result', function () {
    $result = NotFound::from('Resource not found');
    
    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Resource not found')
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe([]);
});

test('result to array', function () {
    $data = ['key' => 'value'];
    $result = Ok::fromMessageAndData('Success', $data);
    
    $expected = [
        'message' => 'Success',
        'data' => $data,
    ];
    
    expect($result->toArray())->toBe($expected);
});
