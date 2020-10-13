<?php

namespace Webbhuset\Schema\Test;

use Webbhuset\Schema\Constructor as S;

final class BoolSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testNormalize()
    {
        $schema = S::Bool();

        $this->assertSame(
            true,
            $schema->normalize(123)
        );

        $this->assertSame(
            true,
            $schema->normalize('123')
        );

        $this->assertSame(
            true,
            $schema->normalize('-123')
        );

        $this->assertSame(
            true,
            $schema->normalize('123abc')
        );

        $this->assertSame(
            true,
            $schema->normalize(1.0)
        );

        $this->assertSame(
            true,
            $schema->normalize('1.0')
        );

        $this->assertSame(
            true,
            $schema->normalize(1.1)
        );

        $this->assertSame(
            true,
            $schema->normalize('1.1')
        );

        $this->assertSame(
            true,
            $schema->normalize('abc')
        );

        $this->assertSame(
            false,
            $schema->normalize('')
        );

        $this->assertSame(
            true,
            $schema->normalize('1e3')
        );

        $this->assertSame(
            true,
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
            false,
            $schema->normalize(null)
        );

        $this->assertSame(
            true,
            $schema->normalize([1, 2, 3])
        );

        $this->assertSame(
            false,
            $schema->normalize([])
        );

        $obj = new \stdClass();
        $this->assertSame(
            true,
            $schema->normalize($obj)
        );
    }

    public function testFromArray()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\BoolSchema::class,
            S::fromArray([
                'type' => 'bool',
                'args' => [],
            ])
        );
    }

    public function testValidate()
    {
        $schema = S::Bool();

        $this->assertTrue(
            $schema->validate(true)->isValid()
        );

        $this->assertTrue(
            $schema->validate(false)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(123)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate('123')->isValid()
        );

        $this->assertNotTrue(
            $schema->validate(123.0)->isValid()
        );

        $this->assertNotTrue(
            $schema->validate([])->isValid()
        );
    }
}
