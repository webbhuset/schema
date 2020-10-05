<?php

namespace Webbhuset\Schema\Test;

use Webbhuset\Schema\Constructor as S;

final class IntSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalize()
    {
        $schema = S::Int();

        $this->assertSame(
            123,
            $schema->normalize(123)
        );

        $this->assertSame(
            123,
            $schema->normalize('123')
        );

        $this->assertSame(
            -123,
            $schema->normalize('-123')
        );

        $this->assertSame(
            '123abc',
            $schema->normalize('123abc')
        );

        $this->assertSame(
            1,
            $schema->normalize(1.0)
        );

        $this->assertSame(
            1,
            $schema->normalize('1.0')
        );

        $this->assertSame(
            1.1,
            $schema->normalize(1.1)
        );

        $this->assertSame(
            '1.1',
            $schema->normalize('1.1')
        );

        $this->assertSame(
            'abc',
            $schema->normalize('abc')
        );

        $this->assertSame(
            1000,
            $schema->normalize('1e3')
        );

        $this->assertSame(
            1000,
            $schema->normalize('1e+3')
        );

        $this->assertSame(
            -1000,
            $schema->normalize('-1e3')
        );

        $this->assertSame(
            1,
            $schema->normalize(true)
        );

        $this->assertSame(
            0,
            $schema->normalize(false)
        );

        $this->assertSame(
            0,
            $schema->normalize(null)
        );

        $this->assertSame(
            [1, 2, 3],
            $schema->normalize([1, 2, 3])
        );

        $obj = new \stdClass();
        $this->assertSame(
            $obj,
            $schema->normalize($obj)
        );
    }

    public function testFromArray()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\IntSchema::class,
            S::fromArray([
                'type' => 'int',
                'args' => [
                    'max' => null,
                    'min' => null,
                ],
            ])
        );

        $this->assertInstanceOf(
            \Webbhuset\Schema\IntSchema::class,
            S::fromArray([
                'type' => 'int',
                'args' => [
                    'max' => 10,
                    'min' => 0,
                ],
            ])
        );
    }

    public function testValidate()
    {
        $schema = S::Int();

        $this->assertTrue(
            $schema->validate(123)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate('123')->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(123.0)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(true)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate([])->isValid()
        );
    }

    public function testMin()
    {
        $schema = S::Int()->min(10);

        $this->assertTrue(
            $schema->validate(123)->isValid()
        );

        $this->assertTrue(
            $schema->validate(10)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(5)->isValid()
        );
    }

    public function testMax()
    {
        $schema = S::Int()->max(10);

        $this->assertTrue(
            $schema->validate(5)->isValid()
        );

        $this->assertTrue(
            $schema->validate(10)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(123)->isValid()
        );
    }

    public function testToArray()
    {
        $schema = S::Int();

        $this->assertTrue(
            $schema::getArraySchema()->validate($schema->toArray())->isValid()
        );
    }
}
