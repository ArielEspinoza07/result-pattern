<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Failed;
use ArielEspinoza07\ResultPattern\Ok;

test('create from message contract', function () {
    $message = 'Test message';
    $result = Ok::from($message);

    expect($result)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->and($result->message())->toBe($message);
});

test('create from message and data contract', function () {
    $message = 'Test message';
    $data = ['key' => 'value'];
    $result = Ok::fromMessageAndData($message, $data);

    expect($result)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class)
        ->and($result->message())->toBe($message)
        ->and($result->data())->toBe($data);
});

test('contracts implementation in success result', function () {
    $result = Ok::from('Success');

    expect($result)
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class);
});

test('contracts implementation in error result', function () {
    $result = Failed::from('Not found');

    expect($result)
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class);
});
