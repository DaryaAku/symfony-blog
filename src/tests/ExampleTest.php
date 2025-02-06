<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @group dummy
 */
class ExampleTest extends TestCase
{
    public function testTrueIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testFalseIsNotTrue()
    {
        $this->assertNotTrue(false);
    }

    public function testArrayHasKey()
    {
        $array = ['name' => 'John', 'age' => 30];
        $this->assertArrayHasKey('name', $array);
    }

    public function testStringContains()
    {
        $string = "Symfony is great!";
        $this->assertStringContainsString('great', $string);
    }

    public function testCountElements()
    {
        $array = [1, 2, 3, 4, 5];
        $this->assertCount(5, $array);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(\stdClass::class, new \stdClass());
    }

    public function testJsonDecode()
    {
        $json = '{"name": "Alice", "age": 25}';
        $data = json_decode($json, true);
        $this->assertIsArray($data);
    }

    public function testMatchesRegularExpression()
    {
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}/', '2025-02-06');
    }

    public function testIsEmpty()
    {
        $this->assertEmpty([]);
    }

    public function testIsNotEmpty()
    {
        $this->assertNotEmpty(['data']);
    }
}
