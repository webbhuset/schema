<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class ScalarType extends AbstractType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = $array['nullable'] ?? $this->isNullable;
    }

    public function toArray() : array
    {
        return [
            'type' => 'scalar',
            'args' => [
                'nullable' => $this->isNullable,
            ]
        ];
    }

    public static function getArraySchema() : TypeInterface
    {
        return T::Struct([
            'type' => T::Enum(['scalar']),
            'args' => T::Struct([
                'nullable' => T::Bool(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)) {
            return $error;
        }

        if (is_null($value)) {
            return false;
        }

        if (!is_scalar($value)) {
            $string = $this->getValueString($value);

            return "Not a valid scalar value: '{$string}'";
        }

        return false;
    }

    public function cast($value)
    {
        return $value;
    }

    public function isEqual($a, $b) : bool
    {
        return $a == $b;
    }

    public function isScalar() : bool
    {
        return true;
    }
}
