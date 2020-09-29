<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class BoolSchema implements \Webbhuset\Schema\SchemaInterface
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

    public function validate($value, bool $strict = true): bool
    {
        if (!is_bool($value)) {
            if ($strict) {
                throw new \Webbhuset\Schema\ValidationException(['Value must be a bool.']);
            } else {
                $value = (bool)$value;
            }
        }

        return $value;
    }
}
