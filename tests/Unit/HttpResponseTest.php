<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Tests\Unit;

use ArielEspinoza07\ResultPattern\Accepted;
use ArielEspinoza07\ResultPattern\BadGateway;
use ArielEspinoza07\ResultPattern\MethodNotAllowed;
use ArielEspinoza07\ResultPattern\NotAcceptable;
use ArielEspinoza07\ResultPattern\PayloadTooLarge;
use ArielEspinoza07\ResultPattern\ServiceUnavailable;
use ArielEspinoza07\ResultPattern\UnprocessableEntity;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{
    public function testAcceptedResult(): void
    {
        $result = Accepted::from('Request accepted');
        
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('Request accepted', $result->message());
        $this->assertEquals(202, $result->status());
    }

    public function testMethodNotAllowedResult(): void
    {
        $result = MethodNotAllowed::from('POST method not allowed');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('POST method not allowed', $result->message());
        $this->assertEquals(405, $result->status());
    }

    public function testNotAcceptableResult(): void
    {
        $result = NotAcceptable::from('Content type not acceptable');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('Content type not acceptable', $result->message());
        $this->assertEquals(406, $result->status());
    }

    public function testPayloadTooLargeResult(): void
    {
        $result = PayloadTooLarge::from('File size exceeds limit');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('File size exceeds limit', $result->message());
        $this->assertEquals(413, $result->status());
    }

    public function testUnprocessableEntityResult(): void
    {
        $data = ['errors' => ['name' => 'Required']];
        $result = UnprocessableEntity::fromMessageAndData('Validation failed', $data);
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('Validation failed', $result->message());
        $this->assertEquals(422, $result->status());
        $this->assertEquals($data, $result->data());
    }

    public function testBadGatewayResult(): void
    {
        $result = BadGateway::from('External service unavailable');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('External service unavailable', $result->message());
        $this->assertEquals(502, $result->status());
    }

    public function testServiceUnavailableResult(): void
    {
        $result = ServiceUnavailable::from('System maintenance');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('System maintenance', $result->message());
        $this->assertEquals(503, $result->status());
    }
}
