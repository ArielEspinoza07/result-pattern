<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Result;
use Mockery\MockInterface;

test('create from message contract implementation', function () {
    $message = 'Test message';
    /** @var MockInterface&CreateFromMessageContract $mockResult */
    $mockResult = mock(CreateFromMessageContract::class);
    $mockResult->shouldReceive('message')->once()->andReturn($message);
    $mockResult->shouldReceive('from')->with($message)->andReturn($mockResult);

    expect($mockResult)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->and($mockResult->message())->toBe($message);
});

test('create from message and data contract implementation', function () {
    $message = 'Test message';
    $data = ['key' => 'value'];
    /** @var MockInterface&CreateFromMessageAndDataContract $mockResult */
    $mockResult = mock(CreateFromMessageAndDataContract::class);
    $mockResult->shouldReceive('message')->once()->andReturn($message);
    $mockResult->shouldReceive('data')->once()->andReturn($data);
    $mockResult->shouldReceive('fromMessageAndData')->with($message, $data)->andReturn($mockResult);

    expect($mockResult)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class)
        ->and($mockResult->message())->toBe($message)
        ->and($mockResult->data())->toBe($data);
});

test('result class implements required contracts', function () {
    /** @var MockInterface&Result $mockResult */
    $mockResult = mock(Result::class);

    expect($mockResult)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class);
});
