<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class BoolType extends AbstractType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = $array['nullable'] ?? $this->isNullable;
    }

    public function toArray() : array
    {
        return [
            'type'  => 'bool',
            'args'  => [
                'nullable'      => $this->isNullable,
            ],
        ];
    }

    public static function getArraySchema() : TypeInterface
    {
        return T::Struct([
            'type' => T::Enum(['bool']),
            'args' => T::Struct([
                'nullable' => T::Bool(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)){
            return $error;
        }

        if (is_null($value)) {
            return false;
        }

        if (!is_bool($value)) {
            $string = $this->getValueString($value);

            return "Not a valid boolean: '{$string}'";
        }

        return false;
    }

    public function cast($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (bool) $value;
    }

    public function isEqual($a, $b) : bool
    {
        if (!is_bool($a) || !is_bool($b)) {
            throw new TypeException("Not a boolean");
        }

        return $a===$b;
    }

    public function diff($a, $b)
    {
        if ($this->isEqual($a, $b)) {
            return [];
        } else {
            return [
                '+' => $a,
                '-' => $b,
            ];
        }
    }

    public function isScalar() : bool
    {
        return true;
    }
}
