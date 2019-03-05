<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class IntSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::Int();

        $this->assertSame(
            123,
            $schema->cast(123)
        );

        $this->assertSame(
            123,
            $schema->cast('123')
        );

        $this->assertSame(
            -123,
            $schema->cast('-123')
        );

        $this->assertSame(
            '123abc',
            $schema->cast('123abc')
        );

        $this->assertSame(
            1,
            $schema->cast(1.0)
        );

        $this->assertSame(
            1,
            $schema->cast('1.0')
        );

        $this->assertSame(
            1.1,
            $schema->cast(1.1)
        );

        $this->assertSame(
            '1.1',
            $schema->cast('1.1')
        );

        $this->assertSame(
            'abc',
            $schema->cast('abc')
        );

        $this->assertSame(
            1000,
            $schema->cast('1e3')
        );

        $this->assertSame(
            1000,
            $schema->cast('1e+3')
        );

        $this->assertSame(
            -1000,
            $schema->cast('-1e3')
        );

        $this->assertSame(
            1,
            $schema->cast(true)
        );

        $this->assertSame(
            0,
            $schema->cast(false)
        );

        $this->assertSame(
            0,
            $schema->cast(null)
        );

        $this->assertSame(
            [1, 2, 3],
            $schema->cast([1, 2, 3])
        );

        $obj = new \stdClass();
        $this->assertSame(
            $obj,
            $schema->cast($obj)
        );
    }

    public function testCastNullable()
    {
        $schema = S::Int([S::NULLABLE]);

        $this->assertSame(
            null,
            $schema->cast(null)
        );
    }

    public function testArraySchema()
    {
        $schema = S::Int();
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            [],
            $arraySchema->validate($array)
        );
    }

    public function testFromArray()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\Simple\IntSchema::class,
            S::fromArray([
                'type' => 'int',
                'args' => [],
            ])
        );

        $this->assertInstanceOf(
            \Webbhuset\Schema\Simple\IntSchema::class,
            S::fromArray([
                'type' => 'int',
                'args' => [
                    'nullable' => true,
                    'min' => 0,
                    'max' => 10,
                ],
            ])
        );
    }
}
