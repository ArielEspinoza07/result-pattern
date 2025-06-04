<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\Found;
use ArielEspinoza07\ResultPattern\MovedPermanently;
use ArielEspinoza07\ResultPattern\MultipleChoices;
use ArielEspinoza07\ResultPattern\NotModified;
use ArielEspinoza07\ResultPattern\PermanentRedirect;
use ArielEspinoza07\ResultPattern\SeeOther;
use ArielEspinoza07\ResultPattern\TemporaryRedirect;
use ArielEspinoza07\ResultPattern\UseProxy;

test('multiple choices result', function () {
    $data = ['choices' => ['/path1', '/path2']];
    $result = MultipleChoices::fromMessageAndData('Multiple choices available', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Multiple choices available')
        ->and($result->status())->toBe(300)
        ->and($result->data())->toBe($data);
});

test('moved permanently result', function () {
    $data = ['location' => '/new-path'];
    $result = MovedPermanently::fromMessageAndData('Resource moved permanently', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Resource moved permanently')
        ->and($result->status())->toBe(301)
        ->and($result->data())->toBe($data);
});

test('found result', function () {
    $data = ['location' => '/temp-path'];
    $result = Found::fromMessageAndData('Resource found at temporary location', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Resource found at temporary location')
        ->and($result->status())->toBe(302)
        ->and($result->data())->toBe($data);
});

test('see other result', function () {
    $data = ['location' => '/other-resource'];
    $result = SeeOther::fromMessageAndData('See other resource', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('See other resource')
        ->and($result->status())->toBe(303)
        ->and($result->data())->toBe($data);
});

test('not modified result', function () {
    $result = NotModified::from('Resource not modified');

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Resource not modified')
        ->and($result->status())->toBe(304);
});

test('use proxy result', function () {
    $data = ['proxy' => 'http://proxy.example.com'];
    $result = UseProxy::fromMessageAndData('Use proxy for this request', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Use proxy for this request')
        ->and($result->status())->toBe(305)
        ->and($result->data())->toBe($data);
});

test('temporary redirect result', function () {
    $data = ['location' => '/temp-redirect'];
    $result = TemporaryRedirect::fromMessageAndData('Temporary redirect', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Temporary redirect')
        ->and($result->status())->toBe(307)
        ->and($result->data())->toBe($data);
});

test('permanent redirect result', function () {
    $data = ['location' => '/permanent-redirect'];
    $result = PermanentRedirect::fromMessageAndData('Permanent redirect', $data);

    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Permanent redirect')
        ->and($result->status())->toBe(308)
        ->and($result->data())->toBe($data);
});
