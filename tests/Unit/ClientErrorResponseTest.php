<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\ExpectationFailed;
use ArielEspinoza07\ResultPattern\ImATeapot;
use ArielEspinoza07\ResultPattern\LengthRequired;
use ArielEspinoza07\ResultPattern\MisdirectedRequest;
use ArielEspinoza07\ResultPattern\PaymentRequired;
use ArielEspinoza07\ResultPattern\PreconditionRequired;
use ArielEspinoza07\ResultPattern\ProxyAuthenticationRequired;
use ArielEspinoza07\ResultPattern\RangeNotSatisfiable;
use ArielEspinoza07\ResultPattern\RequestHeaderFieldsTooLarge;
use ArielEspinoza07\ResultPattern\TooEarly;
use ArielEspinoza07\ResultPattern\UnavailableForLegalReasons;
use ArielEspinoza07\ResultPattern\UpgradeRequired;
use ArielEspinoza07\ResultPattern\UriTooLong;

test('payment required result', function() {
    $data = ['amount' => 100];
    $result = PaymentRequired::fromMessageAndData('Payment required to continue', $data);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Payment required to continue')
        ->and($result->status())->toBe(402)
        ->and($result->data())->toBe($data);
});

test('proxy authentication required result', function() {
    $result = ProxyAuthenticationRequired::from('Proxy authentication required');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Proxy authentication required')
        ->and($result->status())->toBe(407);
});

test('length required result', function() {
    $result = LengthRequired::from('Content-Length header required');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Content-Length header required')
        ->and($result->status())->toBe(411);
});

test('uri too long result', function() {
    $result = UriTooLong::from('URI too long');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('URI too long')
        ->and($result->status())->toBe(414);
});

test('range not satisfiable result', function() {
    $result = RangeNotSatisfiable::from('Range not satisfiable');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Range not satisfiable')
        ->and($result->status())->toBe(416);
});

test('expectation failed result', function() {
    $result = ExpectationFailed::from('Expectation header failed');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Expectation header failed')
        ->and($result->status())->toBe(417);
});

test('im a teapot result', function() {
    $result = ImATeapot::from('I\'m a teapot');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('I\'m a teapot')
        ->and($result->status())->toBe(418);
});

test('misdirected request result', function() {
    $result = MisdirectedRequest::from('Request misdirected');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Request misdirected')
        ->and($result->status())->toBe(421);
});

test('too early result', function() {
    $result = TooEarly::from('Request too early');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Request too early')
        ->and($result->status())->toBe(425);
});

test('upgrade required result', function() {
    $data = ['upgrade' => 'HTTP/2.0'];
    $result = UpgradeRequired::fromMessageAndData('Upgrade required', $data);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Upgrade required')
        ->and($result->status())->toBe(426)
        ->and($result->data())->toBe($data);
});

test('precondition required result', function() {
    $result = PreconditionRequired::from('Precondition required');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Precondition required')
        ->and($result->status())->toBe(428);
});

test('request header fields too large result', function() {
    $result = RequestHeaderFieldsTooLarge::from('Header fields too large');

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Header fields too large')
        ->and($result->status())->toBe(431);
});

test('unavailable for legal reasons result', function() {
    $data = ['reason' => 'DMCA takedown'];
    $result = UnavailableForLegalReasons::fromMessageAndData('Content unavailable for legal reasons', $data);

    expect($result)
        ->toBeErrorResult()
        ->and($result->message())->toBe('Content unavailable for legal reasons')
        ->and($result->status())->toBe(451)
        ->and($result->data())->toBe($data);
});
