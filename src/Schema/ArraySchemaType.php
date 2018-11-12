<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseArraySchemaType extends AbstractType
{
    protected function _toArray()
    {
        return [
            'type' => 'arrayschema',
            'args' => [
                'nullable' => $this->isNullable,
            ],
        ];
    }

    protected static function _getArraySchema()
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
        if ($error = parent::getErrors($value)) {
            return $error;
        }

        if ($value === null && $this->isNullable) {
            return false;
        }

        $valueSchema = T::Struct([
            'type' => T::String(),
            'args' => T::Hashmap(T::String(), T::Any()),
        ]);
        if ($errors = $valueSchema->getErrors($value)) {
            return $errors;
        }

        try {
            $arraySchema = T::getArraySchema($value['type']);
        } catch (TypeException $e) {
            return "Unknown type '{$value['type']}'.";
        }

        return $arraySchema->getErrors($value);
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'ArraySchemaType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'ArraySchemaType-5.5.php';
}
