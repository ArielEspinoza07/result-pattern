<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;

it('ok result', function () {
    $message = 'Operation successful';
    $data = ['key' => 'value'];

    $result = Ok::fromMessageAndData($message, HttpResponseStatusCode::OK, $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe($data);
});

it('ok result with message only', function () {
    $message = 'Operation successful';

    $result = Ok::from($message);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(200)
        ->and($result->data())->toBe([]);
});

it('ok result to array', function () {
    $message = 'Operation successful';
    $data = ['key' => 'value'];

    $result = Ok::fromMessageAndData($message, HttpResponseStatusCode::OK, $data);
    $array = $result->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKeys(['success', 'message', 'status', 'data'])
        ->and($array['success'])->toBeTrue()
        ->and($array['message'])->toBe($message)
        ->and($array['status'])->toBe(200)
        ->and($array['data'])->toBe($data);
});
