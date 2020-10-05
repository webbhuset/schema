<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class BoolSchema implements \Webbhuset\Schema\SchemaInterface
{
    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self();

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/bool/'),
            'args' => S::Struct([]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'bool',
            'args' => [],
        ];
    }

    public function normalize($value)
    {
        if (is_bool($value)) {
            return $value;
        } else {
            return (bool)$value;
        }
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        if (!is_bool($value)) {
            return new \Webbhuset\Schema\ValidationResult(['Value must be a bool.']);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
