<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class IntType extends AbstractType
{
    protected $max;
    protected $min;

    protected function parseArg($arg)
    {
        if (is_array($arg) && isset($arg[T::ARG_KEY_MIN])) {
            $this->min  = is_int($arg[T::ARG_KEY_MIN])
                        ? $arg[T::ARG_KEY_MIN]
                        : null;
            return;
        }
        if (is_array($arg) && isset($arg[T::ARG_KEY_MAX])) {
            $this->max  = is_int($arg[T::ARG_KEY_MAX])
                        ? $arg[T::ARG_KEY_MAX]
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
            'type'  => 'int',
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
            'type' => T::Enum(['int']),
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

        if (!is_integer($value)) {
            $string = $this->getValueString($value);
            return "Not a valid integer: '{$string}'";
        }

        if (isset($this->min) && $value < $this->min) {
            return "Integer value is too small, min value allowed is {$this->min}: '{$value}'";
        }

        if (isset($this->max) && $value > $this->max) {
            return "Integer value is too big, max value allowed is {$this->max}: '{$value}'";
        }

        return false;
    }

    public function cast($value)
    {
        if (is_null($value) && $this->isNullable) {
            return $value;
        }

        return (int) $value;
    }

    public function isEqual($a, $b) : bool
    {
        if (!(is_int($a) || is_null($a))) {
            throw new TypeException("Not a integer");
        }
        if (!(is_int($b) || is_null($b))) {
            throw new TypeException("Not a integer");
        }

        return $a===$b;
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
