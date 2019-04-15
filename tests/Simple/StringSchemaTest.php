<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class StringSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::String();

        $this->assertSame(
            'abc',
            $schema->cast('abc')
        );

        $this->assertSame(
            '123',
            $schema->cast(123)
        );

        $this->assertSame(
            '-123',
            $schema->cast(-123)
        );

        $this->assertSame(
            '1',
            $schema->cast(1.0)
        );

        $this->assertSame(
            '1.1',
            $schema->cast(1.1)
        );

        $this->assertSame(
            '1',
            $schema->cast(true)
        );

        $this->assertSame(
            '0',
            $schema->cast(false)
        );

        $this->assertSame(
            '',
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
        $schema = S::String();
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
            \Webbhuset\Schema\Simple\StringSchema::class,
            S::fromArray([
                'type' => 'string',
                'args' => [],
            ])
        );

        $this->assertInstanceOf(
            \Webbhuset\Schema\Simple\StringSchema::class,
            S::fromArray([
                'type' => 'string',
                'args' => [
                    'nullable' => true,
                    'min' => 1,
                    'max' => 10,
                    'case_sensitive' => false,
                ],
            ])
        );
    }
}
