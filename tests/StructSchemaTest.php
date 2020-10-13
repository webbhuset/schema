<?php

namespace Webbhuset\Schema\Test;

use Webbhuset\Schema\Constructor as S;

final class StructSchemaTest extends \PHPUnit\Framework\TestCase
{
    protected function schema()
    {
        return new \Webbhuset\Schema\StructSchema([
            'int' => S::Int(),
            'string' => S::String(),
        ]);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\StructSchema::class,
            $this->schema()
        );
    }

    public function testConstructInvalidArgs()
    {
        $this->expectException(\InvalidArgumentException::class);

        S::Struct(['qwer']);
    }

    public function testNormalize()
    {
        $schema = $this->schema();

        $this->assertSame(
            [
                'int' => 1,
                'string' => '1',
            ],
            $schema->normalize([
                'int' => '1',
                'string' => 1,
                'missing' => true,
            ]),
            'Arrays should match after normalization.'
        );
    }

    public function testFromArray()
    {
        $this->assertInstanceOf(
            null,
            \Webbhuset\Schema\IntSchema::fromArray([
                'type' => 'struct',
                'args' => [
                    'fields' => [
                        'int' => [
                            'type' => 'int',
                            'args' => [
                                'max' => null,
                                'min' => null,
                            ],
                        ],
                    ],
                ],
            ])
        );
    }
}
