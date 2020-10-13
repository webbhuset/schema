<?php

namespace Webbhuset\Schema\Test;

use Webbhuset\Schema\Constructor as S;

final class AnySchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalize()
    {
        $schema = S::Any();

        $this->assertSame(
            123,
            $schema->normalize(123)
        );

        $this->assertSame(
            '123',
            $schema->normalize('123')
        );

        $this->assertSame(
            '-123',
            $schema->normalize('-123')
        );

        $this->assertSame(
            '123abc',
            $schema->normalize('123abc')
        );

        $this->assertSame(
            1.0,
            $schema->normalize(1.0)
        );

        $this->assertSame(
            '1.0',
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
            '1e3',
            $schema->normalize('1e3')
        );

        $this->assertSame(
            '1e+3',
            $schema->normalize('1e+3')
        );

        $this->assertSame(
            '-1e3',
            $schema->normalize('-1e3')
        );

        $this->assertSame(
            true,
            $schema->normalize(true)
        );

        $this->assertSame(
            false,
            $schema->normalize(false)
        );

        $this->assertSame(
            null,
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
            \Webbhuset\Schema\AnySchema::class,
            S::fromArray([
                'type' => 'any',
                'args' => [],
            ])
        );
    }

    public function testValidate()
    {
        $schema = S::Any();

        $this->assertTrue(
            $schema->validate(123)->isValid()
        );

        $this->assertTrue(
            $schema->validate('123')->isValid()
        );

        $this->assertTrue(
            $schema->validate(123.0)->isValid()
        );

        $this->assertTrue(
            $schema->validate(true)->isValid()
        );

        $this->assertTrue(
            $schema->validate([])->isValid()
        );
    }

    public function testToArray()
    {
        $schema = S::Any();

        $this->assertTrue(
            $schema::getArraySchema()->validate($schema->toArray())->isValid()
        );
    }
}
