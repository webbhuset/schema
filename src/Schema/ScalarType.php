<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseScalarType extends AbstractType
{
    protected function _toArray()
    {
        return [
            'type' => 'scalar',
            'args' => [
                'nullable' => $this->isNullable,
            ]
        ];
    }

    protected static function _getArraySchema()
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

            return "Not a valid scalar value: '{$string}'.";
        }

        return false;
    }

    public function cast($value)
    {
        return $value;
    }

    protected function _isEqual($a, $b)
    {
        return $a == $b;
    }

    protected function _isScalar()
    {
        return true;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'ScalarType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'ScalarType-5.5.php';
}
