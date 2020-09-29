<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class ArraySchemaSchema implements \Webbhuset\Schema\SchemaInterface
{
    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        static::getArraySchema()->validate($array);

        $schema = new self();

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/array_schema/'),
            'args' => S::Struct([]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'array_schema',
            'args' => [],
        ];
    }

    public function validate($value, bool $strict = true): array
    {
        $valueSchema = S::Struct([
            'type' => S::String(),
            'args' => S::Dict(S::String(), S::Any()),
        ]);

        $valueSchema->validate($value, $strict);

        try {
            $arraySchema = S::getArraySchema($value['type']);
        } catch (\InvalidArgumentException $e) {
            throw new \Webbhuset\Schema\ValidationException([$e->getMessage()]);
        }

        return $arraySchema->validate($value, $strict);
    }
}
