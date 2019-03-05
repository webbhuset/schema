<?php

namespace Webbhuset\Schema\Test\Composite;

use Webbhuset\Schema\Constructor as S;

final class HashmapSchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testFromArray()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\Composite\HashmapSchema::class,
            S::fromArray([
                'type' => 'hashmap',
                'args' => [
                    'key' => [
                        'type' => 'string',
                        'args' => [],
                    ],
                    'value' => [
                        'type' => 'string',
                        'args' => [],
                    ],
                ],
            ])
        );

        $this->assertInstanceOf(
            \Webbhuset\Schema\Composite\HashmapSchema::class,
            S::fromArray([
                'type' => 'hashmap',
                'args' => [
                    'key' => [
                        'type' => 'string',
                        'args' => [],
                    ],
                    'value' => [
                        'type' => 'string',
                        'args' => [],
                    ],
                    'nullable' => true,
                    'min' => 0,
                    'max' => 5,
                ],
            ])
        );
    }
}
