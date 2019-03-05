<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class BoolSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::Bool();

        $this->assertSame(
            $schema->cast(true),
            true
        );

        $this->assertSame(
            $schema->cast(false),
            false
        );

        $this->assertSame(
            $schema->cast(1),
            true
        );

        $this->assertSame(
            $schema->cast(0),
            false
        );

        $this->assertSame(
            $schema->cast(2),
            2
        );

        $this->assertSame(
            $schema->cast('1'),
            true
        );

        $this->assertSame(
            $schema->cast('0'),
            false
        );

        $this->assertSame(
            $schema->cast('2'),
            '2'
        );

        $this->assertSame(
            $schema->cast('-0'),
            '-0'
        );

        $this->assertSame(
            $schema->cast('true'),
            'true'
        );

        $this->assertSame(
            $schema->cast('false'),
            'false'
        );

        $this->assertSame(
            $schema->cast('abc'),
            'abc'
        );

        $this->assertSame(
            $schema->cast(null),
            false
        );

        $this->assertSame(
            $schema->cast([]),
            []
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
        $schema = S::Bool([S::NULLABLE]);

        $this->assertSame(
            $schema->cast(null),
            null
        );
    }

    public function testArraySchema()
    {
        $schema = S::Bool();
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            $arraySchema->validate($array),
            []
        );
    }
}
