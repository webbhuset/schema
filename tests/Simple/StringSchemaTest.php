<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class StringSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::String();

        $this->assertSame(
            $schema->cast('abc'),
            'abc'
        );

        $this->assertSame(
            $schema->cast(123),
            '123'
        );

        $this->assertSame(
            $schema->cast(-123),
            '-123'
        );

        $this->assertSame(
            $schema->cast(1.0),
            '1'
        );

        $this->assertSame(
            $schema->cast(1.1),
            '1.1'
        );

        $this->assertSame(
            $schema->cast(true),
            '1'
        );

        $this->assertSame(
            $schema->cast(false),
            ''
        );

        $this->assertSame(
            $schema->cast(null),
            ''
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
        $schema = S::String();
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            $arraySchema->validate($array),
            []
        );
    }
}
