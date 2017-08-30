<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class FloatType extends AbstractType
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

    protected function constructFromArray(array $array)
    {
        $this->isNullable   = $array['nullable'] ?? $this->isNullable;
        $this->min          = $array['min'] ?? $this->min;
        $this->max          = $array['max'] ?? $this->max;
    }

    public function toArray() : array
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

    public static function getArraySchema() : TypeInterface
    {
        return T::Struct([
            'type' => T::Enum(['float']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'min'       => T::Int(T::NULLABLE),
                'max'       => T::Int(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)){
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

    public function isEqual($a, $b) : bool
    {
        if (!(is_float($a) || is_null($a))) {
            throw new TypeException("Not a float");
        }
        if (!(is_float($b) || is_null($b))) {
            throw new TypeException("Not a float");
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

    public function isScalar() : bool
    {
        return true;
    }
}
