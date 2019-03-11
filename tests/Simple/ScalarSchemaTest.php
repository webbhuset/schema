<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class ScalarSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::Scalar();

        $this->assertSame(
            true,
            $schema->cast(true)
        );

        $this->assertSame(
            false,
            $schema->cast(false)
        );

        $this->assertSame(
            2,
            $schema->cast(2)
        );

        $this->assertSame(
            1.0,
            $schema->cast(1.0)
        );

        $this->assertSame(
            0.0,
            $schema->cast(0.0)
        );

        $this->assertSame(
            'abc',
            $schema->cast('abc')
        );

        $this->assertSame(
            [],
            $schema->cast([])
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
        $schema = S::Scalar([S::NULLABLE]);

        $this->assertSame(
            null,
            $schema->cast(null)
        );
    }

    public function testArraySchema()
    {
        $schema = S::Scalar();
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            [],
            $arraySchema->validate($array)
        );
    }
}
