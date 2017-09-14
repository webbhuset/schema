<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class AnyType extends AbstractType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
    }

    public function toArray()
    {
        return [
            'type'  => 'any',
            'args'  => [
                'nullable'      => $this->isNullable,
            ],
        ];
    }

    public static function getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['any']),
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

        return false;
    }

    public function cast($value)
    {
        return $value;
    }

    public function isEqual($a, $b)
    {
        return $a == $b;
    }
}