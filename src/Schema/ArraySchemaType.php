<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class ArraySchemaType extends AbstractType
{
    protected function constructFromArray(array $array)
    {
        $this->isNullable = $array['nullable'] ?? $this->isNullable;
    }

    public function toArray() : array
    {
        return [
            'type' => 'arrayschema',
            'args' => [
                'nullable' => $this->isNullable,
            ],
        ];
    }

    public static function getArraySchema() : TypeInterface
    {
        return T::Struct([
            'type' => T::Enum(['arrayschema']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
            ]),
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)){
            return $error;
        }

        if ($value === null && $this->isNullable) {
            return false;
        }

        $valueSchema = T::Struct([
            'type' => T::String(),
            'args' => T::Hashmap(T::String(), T::Any()),
        ]);
        if ($error = $valueSchema->getErrors($value)) {
            return $error;
        }

        try {
            $arraySchema = T::getArraySchema($value['type']);
        } catch (TypeException $e) {
            return "Unknown type '{$value['type']}'";
        }

        return $arraySchema->getErrors($value);
    }
}
