<?php

declare(strict_types=1);

use ArielEspinoza07\ResultPattern\NonAuthoritativeInformation;
use ArielEspinoza07\ResultPattern\ResetContent;
use ArielEspinoza07\ResultPattern\PartialContent;
use ArielEspinoza07\ResultPattern\MultiStatus;
use ArielEspinoza07\ResultPattern\AlreadyReported;
use ArielEspinoza07\ResultPattern\ImUsed;

test('non authoritative information result', function () {
    $result = NonAuthoritativeInformation::from('Info from cache');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Info from cache')
        ->and($result->status())->toBe(203);
});

test('reset content result', function () {
    $result = ResetContent::from('Form reset successful');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Form reset successful')
        ->and($result->status())->toBe(205);
});

test('partial content result', function () {
    $data = ['range' => 'bytes=0-1023'];
    $result = PartialContent::fromMessageAndData('Partial content delivered', $data);
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Partial content delivered')
        ->and($result->status())->toBe(206)
        ->and($result->data())->toBe($data);
});

test('multi status result', function () {
    $data = ['statuses' => [200, 404]];
    $result = MultiStatus::fromMessageAndData('Multiple status results', $data);
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Multiple status results')
        ->and($result->status())->toBe(207)
        ->and($result->data())->toBe($data);
});

test('already reported result', function () {
    $result = AlreadyReported::from('Resource already reported');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('Resource already reported')
        ->and($result->status())->toBe(208);
});

test('im used result', function () {
    $result = ImUsed::from('IM used');
    
    expect($result)
        ->toBeSuccessResult()
        ->and($result->message())->toBe('IM used')
        ->and($result->status())->toBe(226);
});
