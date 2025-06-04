<?php

declare(strict_types=1);

namespace ArielEspinoza07\ResultPattern\Tests\Unit;

use ArielEspinoza07\ResultPattern\Ok;
use ArielEspinoza07\ResultPattern\NotFound;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testOkResultCreation(): void
    {
        $result = Ok::from('Success');
        
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('Success', $result->message());
        $this->assertEquals(200, $result->status());
        $this->assertEquals([], $result->data());
    }

    public function testOkResultWithData(): void
    {
        $data = ['id' => 1];
        $result = Ok::fromMessageAndData('Success', $data);
        
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('Success', $result->message());
        $this->assertEquals(200, $result->status());
        $this->assertEquals($data, $result->data());
    }

    public function testNotFoundResult(): void
    {
        $result = NotFound::from('Resource not found');
        
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('Resource not found', $result->message());
        $this->assertEquals(404, $result->status());
        $this->assertEquals([], $result->data());
    }

    public function testResultToArray(): void
    {
        $data = ['key' => 'value'];
        $result = Ok::fromMessageAndData('Success', $data);
        
        $expected = [
            'message' => 'Success',
            'data' => $data,
        ];
        
        $this->assertEquals($expected, $result->toArray());
    }
}
