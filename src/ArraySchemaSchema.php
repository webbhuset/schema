<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class ArraySchemaSchema extends \Webbhuset\Schema\StructSchema
{
    public function __construct()
    {
        parent::__construct([
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
        S::validateArray(static::getArraySchema(), $array);

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

    public function normalize($value)
    {
        return parent::normalize($value);
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        $result = parent::validate($value);

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
