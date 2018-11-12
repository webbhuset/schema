<?php

namespace Webbhuset\Data\Schema\FloatType;

use Webbhuset\Data\Schema\FloatType;
use Webbhuset\Data\Schema\TypeConstructor as T;

class BaseDecimalType extends FloatType
{
    protected $decimalCount = 4;


    protected function parseArg($arg)
    {
        if (is_array($arg) && isset($arg[T::ARG_KEY_DECIMALS])) {
            if (!is_numeric($arg[T::ARG_KEY_DECIMALS])) {
                throw new TypeException('Decimals parameter must be an integer.');
            }
            $this->decimalCount = (int)$arg[T::ARG_KEY_DECIMALS];

            return;
        }

        parent::parseArg($arg);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)) {
            return $error;
        }

        if (is_null($value) && $this->isNullable) {
            return false;
        }

        $rounded = round($value, $this->decimalCount);
        if (abs($rounded - $value) > 1e-9) {
            return "Too many decimals, max {$this->decimalCount} allowed: '{$value}'.";
        }

        return false;
    }

    protected function _toArray()
    {
        return [
            'type'  => 'decimal',
            'args'  => [
                'nullable'  => $this->isNullable,
                'min'       => $this->min,
                'max'       => $this->max,
                'decimals'  => $this->decimalCount,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['decimal']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'min'       => T::Float(T::NULLABLE),
                'max'       => T::Float(T::NULLABLE),
                'decimals'  => T::Int(T::NULLABLE),
            ])
        ]);
    }

    public function cast($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return round($value, $this->decimalCount);
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'DecimalType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'DecimalType-5.5.php';
}
