<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class ArraySchemaSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $valueSchema;


    public function __construct()
    {
        $this->valueSchema = S::Struct([
            'type' => S::OneOf([
                S::String()->regex('/any/'),
                S::String()->regex('/array_schema/'),
                S::String()->regex('/bool/'),
                S::String()->regex('/dict/'),
                S::String()->regex('/float/'),
                S::String()->regex('/int/'),
                S::String()->regex('/nullable/'),
                S::String()->regex('/one_of/'),
                S::String()->regex('/string/'),
                S::String()->regex('/struct/'),
            ]),
            'args' => S::Dict(S::String(), S::Any()),
        ]);
    }

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

    public function cast($value)
    {
        return $this->valueSchema->cast($value);
    }

    public function validate2($value): \Webbhuset\Schema\ValidationResult
    {
        $result = $this->valueSchema->validate($value, $strict);

        if (!$result->isValid()) {
            return $result;
        }

        try {
            return S::getArraySchema($value['type'])->validate($value);
        } catch (\InvalidArgumentException $e) {
            return new \Webbhuset\Schema\ValidationResult([$e->getMessage()]);
        }
    }
}
