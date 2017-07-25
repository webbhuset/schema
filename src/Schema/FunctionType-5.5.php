<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class FunctionType extends AbstractType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
    }

    public function toArray()
    {
        return [
            'type'  => 'function',
            'args'  => [
                'nullable' => $this->isNullable,
            ]
        ];
    }

    public static function getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['function']),
            'args' => T::Struct([
                'nullable' => T::Bool(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($errors = parent::getErrors($value)) {
            return $errors;
        }

        if (!is_callable($value)) {
            return "Value is not callable function";
        }

        return false;
    }
}
