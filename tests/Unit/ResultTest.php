<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Ok;

test('ok result', function () {
    $message = 'Operation successful';
    $data = ['key' => 'value'];

    $result = Ok::fromMessageAndData($message, $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe($data);
});

test('ok result with message only', function () {
    $message = 'Operation successful';

    $result = Ok::from($message);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe([]);
});

test('ok result to array', function () {
    $message = 'Operation successful';
    $data = ['key' => 'value'];

    $result = Ok::fromMessageAndData($message, $data);
    $array = $result->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKeys(['isSuccess', 'message', 'status', 'data'])
        ->and($array['isSuccess'])->toBeTrue()
        ->and($array['message'])->toBe($message)
        ->and($array['status'])->toBe(200)
        ->and($array['data'])->toBe($data);
});
