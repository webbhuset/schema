<?php

namespace Webbhuset\Schema\Test;

use Webbhuset\Schema\Constructor as S;

final class ConstructorTest extends \PHPUnit\Framework\TestCase
{
    public function testAny()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\AnySchema::class,
            S::Any()
        );
    }

    public function testArraySchema()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\ArraySchemaSchema::class,
            S::ArraySchema()
        );
    }

    public function testBool()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\BoolSchema::class,
            S::Bool()
        );
    }

    public function testDict()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\DictSchema::class,
            S::Dict(S::Int(), S::Int())
        );
    }

    public function testFloat()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\FloatSchema::class,
            S::Float()
        );
    }

    public function testInt()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\IntSchema::class,
            S::Int()
        );
    }

    public function testNullable()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\NullableSchema::class,
            S::Nullable(S::Int())
        );
    }

    public function testOneOf()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\OneOfSchema::class,
            S::OneOf([S::Int(), S::String()])
        );
    }

    public function testString()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\StringSchema::class,
            S::String()
        );
    }

    public function testStruct()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\StructSchema::class,
            S::Struct([
                'string' => S::String(),
                'int' => S::Int(),
            ])
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

    public function testGetArraySchema()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\StructSchema::class,
            S::getArraySchema('any')
        );
    }
}
