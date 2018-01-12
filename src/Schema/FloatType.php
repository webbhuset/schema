<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseFloatType extends AbstractType
{
    protected $max;
    protected $min;
    protected $tolerance = 1e-5;


    protected function parseArg($arg)
    {
        if (is_array($arg) && isset($arg[T::ARG_KEY_MIN])) {
            $this->min  = is_numeric($arg[T::ARG_KEY_MIN])
                        ? (float)$arg[T::ARG_KEY_MIN]
                        : null;
            return;
        }
        if (is_array($arg) && isset($arg[T::ARG_KEY_MAX])) {
            $this->max  = is_numeric($arg[T::ARG_KEY_MAX])
                        ? (float)$arg[T::ARG_KEY_MAX]
                        : null;
            return;
        }

        parent::parseArg($arg);
    }

    protected function _toArray()
    {
        return [
            'type'  => 'float',
            'args'  => [
                'nullable'  => $this->isNullable,
                'min'       => $this->min,
                'max'       => $this->max,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['float']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'min'       => T::Float(T::NULLABLE),
                'max'       => T::Float(T::NULLABLE),
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

        if (!is_float($value)) {
            $string = $this->getValueString($value);
            return "Not a valid float: '{$string}'";
        }

        if (isset($this->min) && $value <= $this->min) {
            return "Float value is too small, min value allowed is {$this->min}: '{$value}'";
        }

        if (isset($this->max) && $value >= $this->max) {
            return "Float value is too big, max value allowed is {$this->max}: '{$value}'";
        }

        return false;
    }

    protected function _isEqual($a, $b)
    {
        if (!(is_float($a) || is_null($a))) {
            throw new TypeException("Not a float");
        }
        if (!(is_float($b) || is_null($b))) {
            throw new TypeException("Not a float");
        }

        if ($a === null && $b === null) {
            return true;
        } elseif ($a === null || $b === null) {
            return false;
        }

        return abs($a - $b) < $this->tolerance;
    }

    public function cast($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (float) $value;
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
    case version_compare($phpVersion, '7.0', '>='): return require_once 'FloatType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'FloatType-5.5.php';
}
