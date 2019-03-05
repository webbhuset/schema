<?php

namespace Webbhuset\Schema\Utility;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class ArraySchemaSchema extends AbstractSchema
{
    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['array_schema']),
            'args' => S::Struct([
                'nullable' => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'array_schema',
            'args' => [
                'nullable' => $this->nullable,
            ],
        ];
    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }

        if ($value === null) {
            return [];
        }

        $valueSchema = S::Struct([
            'type' => S::String(),
            'args' => S::Hashmap(S::String(), S::Any()),
        ]);

        if ($errors = $valueSchema->validate($value)) {
            return $errors;
        }

        try {
            $arraySchema = S::getArraySchema($value['type']);
        } catch (\InvalidArgumentException $e) {
            return ['Error'];
        }

        return $arraySchema->validate($value);
    }
}
