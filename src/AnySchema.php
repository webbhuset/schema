<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class AnySchema implements \Webbhuset\Schema\SchemaInterface
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
            'type' => S::String()->regex('/any/'),
            'args' => S::Struct([]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'any',
            'args' => [],
        ];
    }

    public function validate($value, bool $strict = true)
    {
        return $value;
    }

    public function cast($value)
    {
        return $value;
    }

    public function validate2($value): \Webbhuset\Schema\ValidationResult
    {
        return new \Webbhuset\Schema\ValidationResult();
    }
}
