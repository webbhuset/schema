<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseAbstractType implements TypeInterface
{
    protected $isNullable = false;


    abstract protected function constructFromArray(array $array);
    abstract protected function _toArray();

    protected function afterConstruct()
    {
        // Deliberately empty.
    }

    protected function parseArg($arg)
    {
        if ($arg == T::NULLABLE) {
            $this->isNullable = true;
        }
    }

    public function getErrors($value)
    {
        if (is_null($value) && !$this->isNullable) {
            return "Value is required.";
        }

        return false;
    }

    protected function _isEqual($a, $b)
    {
        return $a == $b;
    }

    public function cast($value)
    {
        return $value;
    }

    public function isNullable()
    {
        return $this->isNullable;
    }

    /**
     * Returns the string representation of a value.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function _getValueString($value)
    {
        if (is_object($value)) {
            return '<Object>';
        }
        if (is_array($value)) {
            return '<Array>';
        }
        if (is_null($value)) {
            return '<NULL>';
        }
        if ($value === true) {
            return '<TRUE>';
        }
        if ($value === false) {
            return '<FALSE>';
        }

        return (string)$value;
    }

    public function diff($a, $b)
    {
        throw new TypeException("Diff method not implemented for this type.");
    }

    protected function _isScalar()
    {
        return false;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'AbstractType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'AbstractType-5.5.php';
}
