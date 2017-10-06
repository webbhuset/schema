<?php
namespace Webbhuset\Data\Schema\FloatType;

use Webbhuset\Data\Schema\FloatType;
use Webbhuset\Data\Schema\TypeConstructor AS T;

class DecimalType extends FloatType
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
            return "Too many decimals, max {$this->decimalCount} allowed: {$value}";
        }

        return false;
    }

    protected function constructFromArray(array $array)
    {
        parent::constructFromArray($array);

        $this->decimalCount = isset($array['decimals']) ? $array['decimals'] : $this->decimalCount;
    }

    public function toArray()
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

    public static function getArraySchema()
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
