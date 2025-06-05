<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageContract;
use ArielEspinoza07\ResultPattern\Contracts\CreateFromMessageAndDataContract;
use ArielEspinoza07\ResultPattern\Enums\HttpResponseStatusCode;
use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\Failed;

it('create from message contract implementation', function () {
    $message = 'Test message';
    $status = HttpResponseStatusCode::OK;

    /** @var Mockery\ExpectationInterface|Mockery\MockInterface $mock */
    $mock = Mockery::mock(CreateFromMessageContract::class);
    $mock->shouldReceive('fromMessage')
         ->with($message, $status)
         ->andReturn(
             Ok::from(
                 message: $message,
                 status: $status,
             ),
         );

    $result = Ok::fromMessage(
        message: $message,
        status: $status,
    );

    expect($result)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->and($result->message())
        ->toBe($message);
});

it('create from message and data contract implementation', function () {
    $message = 'Test message';
    $status = HttpResponseStatusCode::OK;
    $data    = ['key' => 'value'];

    /** @var Mockery\ExpectationInterface|Mockery\MockInterface $mock */
    $mock = Mockery::mock(CreateFromMessageAndDataContract::class);
    $mock->shouldReceive('fromMessageAndData')
        ->with($message, $status, $data)
        ->andReturn(
            Ok::from(
                message: $message,
                status: $status,
                data: $data,
            ),
        );

    $result = Ok::fromMessageAndData(
        message: $message,
        status: $status,
        data: $data,
    );

    expect($result)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class)
        ->and($result->message())
        ->toBe($message)
        ->and($result->data())
        ->toBe($data);
});

it('result implementations implement required contracts', function () {
    $okResult     = Ok::from(message:'Success');
    $failedResult = Failed::from(message:'Error');

    expect($okResult)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class)
        ->and($failedResult)
        ->toBeObject()
        ->toBeInstanceOf(CreateFromMessageContract::class)
        ->toBeInstanceOf(CreateFromMessageAndDataContract::class);
});
