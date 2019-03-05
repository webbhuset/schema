<?php

namespace Webbhuset\Schema\Test\Simple;

use Webbhuset\Schema\Constructor as S;

final class EnumSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testCast()
    {
        $schema = S::Enum([1, 2, 3]);

    }

    public function testCastNullable()
    {
        $schema = S::Enum([1, 2, 3], [S::NULLABLE]);

        $this->assertSame(
            null,
            $schema->cast(null)
        );
    }

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
}
