<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Failed;

it('failed result', function () {
    $message = 'Resource not found';
    $data = ['resource' => 'user', 'id' => 1];

    $result = Failed::fromMessageAndData($message, HttpResponseStatusCode::NotFound, $data);

    expect($result->isSuccess())->toBeFalse()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe($data);
});

it('failed result with message only', function () {
    $message = 'Resource not found';

    $result = Failed::from($message, HttpResponseStatusCode::NotFound);

    expect($result->isSuccess())->toBeFalse()
        ->and($result->message())->toBe($message)
        ->and($result->status())->toBe(404)
        ->and($result->data())->toBe([]);
});

it('failed result to array', function () {
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
