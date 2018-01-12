<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseFunctionType extends AbstractType
{
    protected function _toArray()
    {
        return [
            'type'  => 'function',
            'args'  => [
                'nullable' => $this->isNullable,
            ]
        ];
    }

    protected static function _getArraySchema()
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

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'FunctionType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'FunctionType-5.5.php';
}
