<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseBoolType extends AbstractType
{
    protected function _toArray()
    {
        return [
            'type'  => 'bool',
            'args'  => [
                'nullable'      => $this->isNullable,
            ],
        ];
    }

    protected static function _getArraySchema()
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
        if ($error = parent::getErrors($value)) {
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

    protected function _isEqual($a, $b)
    {
        if (!is_bool($a) || !is_bool($b)) {
            throw new TypeException("Not a boolean");
        }

        return $a === $b;
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

    protected function _isScalar()
    {
        return true;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'BoolType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'AbstractType-5.5.php';
}
