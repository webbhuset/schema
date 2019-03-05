<?php

namespace Webbhuset\Schema\Test\Utility;

use Webbhuset\Schema\Constructor as S;

final class AnySchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testFromArray()
    {
        $this->assertInstanceOf(
            \Webbhuset\Schema\Utility\AnySchema::class,
            S::fromArray([
                'type' => 'any',
                'args' => [],
            ])
        );

        $this->assertInstanceOf(
            \Webbhuset\Schema\Utility\AnySchema::class,
            S::fromArray([
                'type' => 'any',
                'args' => [
                    'nullable' => true,
                ],
            ])
        );
    }
}
