<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\NotFound;

test('failed result', function () {
    $message = 'Resource not found';
    $data = ['resource' => 'user', 'id' => 1];

    $result = NotFound::fromMessageAndData($message, $data);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe($data);
});

test('failed result with message only', function () {
    $message = 'Resource not found';

    $result = NotFound::from($message);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe([]);
});

test('failed result to array', function () {
    $message = 'Resource not found';
    $data = ['resource' => 'user', 'id' => 1];

    $result = NotFound::fromMessageAndData($message, $data);
    $array = $result->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKeys(['isSuccess', 'message', 'status', 'data'])
        ->and($array['isSuccess'])->toBeFalse()
        ->and($array['message'])->toBe($message)
        ->and($array['status'])->toBe(404)
        ->and($array['data'])->toBe($data);
});
