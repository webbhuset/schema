<?php

namespace Webbhuset\Schema\Utility;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class AnySchema extends AbstractSchema
{
    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['any']),
            'args' => S::Struct([
                'nullable' => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'any',
            'args' => [
                'nullable' => $this->nullable,
            ],
        ];
    }
}
