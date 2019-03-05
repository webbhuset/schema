<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class IntSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::Int();

        $this->assertSame(
            $schema->cast(123),
            123
        );

        $this->assertSame(
            $schema->cast('123'),
            123
        );

        $this->assertSame(
            $schema->cast('-123'),
            -123
        );

        $this->assertSame(
            $schema->cast('123abc'),
            '123abc'
        );

        $this->assertSame(
            $schema->cast(1.0),
            1
        );

        $this->assertSame(
            $schema->cast('1.0'),
            1
        );

        $this->assertSame(
            $schema->cast(1.1),
            1.1
        );

        $this->assertSame(
            $schema->cast('1.1'),
            '1.1'
        );

        $this->assertSame(
            $schema->cast('abc'),
            'abc'
        );

        $this->assertSame(
            $schema->cast(1e3),
            1000
        );

        $this->assertSame(
            $schema->cast(1e+3),
            1000
        );

        $this->assertSame(
            $schema->cast('1e3'),
            1000
        );

        $this->assertSame(
            $schema->cast('1e+3'),
            1000
        );

        $this->assertSame(
            $schema->cast('-1e3'),
            -1000
        );

        $this->assertSame(
            $schema->cast(true),
            1
        );

        $this->assertSame(
            $schema->cast(false),
            0
        );

        $this->assertSame(
            $schema->cast(null),
            0
        );

        $this->assertSame(
            $schema->cast([1, 2, 3]),
            [1, 2, 3]
        );

        $obj = new \stdClass();
        $this->assertSame(
            $schema->cast($obj),
            $obj
        );
    }

    public function testCastNullable()
    {
        $schema = S::Int([S::NULLABLE]);

        $this->assertSame(
            $schema->cast(null),
            null
        );
    }

    public function testArraySchema()
    {
        $schema = S::Int();
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            $arraySchema->validate($array),
            []
        );
    }
}
