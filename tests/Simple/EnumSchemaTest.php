<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class EnumSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testArraySchema()
    {
        $schema = S::Enum([1, 2, 3]);
        $array = $schema->toArray();
        $arraySchema = $schema::getArraySchema();

        $this->assertSame(
            [],
            $arraySchema->validate($array)
        );
    }

    public function testValidate()
    {
        $schema = S::Enum(['abc', 1, true, 10.0, []]);

        $this->assertSame(
            [],
            $schema->validate('abc')
        );

        $this->assertSame(
            [],
            $schema->validate([])
        );

        $this->assertNotSame(
            [],
            $schema->validate(false)
        );
    }

    public function testValidateCaseInsensitive()
    {
        $schema = S::Enum(['hello', 'world'], [S::CASE_INSENSITIVE]);

        $this->assertSame(
            [],
            $schema->validate('hello')
        );

        $this->assertSame(
            [],
            $schema->validate('HeLlO')
        );

        $this->assertSame(
            [],
            $schema->validate('WORLD')
        );

        $this->assertNotSame(
            [],
            $schema->validate('error')
        );

        $this->assertNotSame(
            [],
            $schema->validate(123)
        );
    }
}
