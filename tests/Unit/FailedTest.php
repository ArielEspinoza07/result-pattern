<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Failed;

test('failed result', function () {
    $message = 'Resource not found';
    $data = ['resource' => 'user', 'id' => 1];

    $result = Failed::fromMessageAndData($message, HttpResponseStatusCode::NotFound, $data);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe($data);
});

test('failed result with message only', function () {
    $message = 'Resource not found';

    $result = Failed::from($message, HttpResponseStatusCode::NotFound);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe([]);
});

test('failed result to array', function () {
    $message = 'Resource not found';
    $data = ['resource' => 'user', 'id' => 1];

    $result = Failed::fromMessageAndData($message, HttpResponseStatusCode::NotFound, $data);
    $array = $result->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKeys(['success', 'message', 'status', 'data'])
        ->and($array['success'])->toBeFalse()
        ->and($array['message'])->toBe($message)
        ->and($array['status'])->toBe(404)
        ->and($array['data'])->toBe($data);
});
