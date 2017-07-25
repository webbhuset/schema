<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class SetType extends AbstractType
{
    protected $max;
    protected $min;
    protected $type;

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

        if ($arg instanceof TypeInterface) {
            $this->type = $arg;
            return;
        }

        parent::parseArg($arg);
    }

    protected function constructFromArray(array $array)
    {
        $this->isNullable   = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->min          = isset($array['min']) ? $array['min'] : $this->min;
        $this->max          = isset($array['max']) ? $array['max'] : $this->max;
        $this->type         = T::constructFromArray($array['type']);
    }

    protected function afterConstruct()
    {
        if (!$this->type instanceof TypeInterface) {
            throw new TypeException("Type param is missing for set.");
        }

    }

    public function toArray()
    {
        return [
            'type'  => 'set',
            'args'  => [
                'nullable'  => $this->isNullable,
                'type'      => $this->type->toArray(),
                'min'       => $this->min,
                'max'       => $this->max,
            ],
        ];
    }

    public static function getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['set']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'min'       => T::Int(T::NULLABLE),
                'max'       => T::Int(T::NULLABLE),
                'type'      => T::ArraySchema(),
            ])
        ]);
    }

    public function cast($valueArray)
    {
        if ($valueArray === null) {
            return [];
        }

        if (!is_array($valueArray)) {
            throw new TypeException("Can only cast arrays.");
        }

        $result = [];
        foreach ($valueArray as $value) {
            $result[] = $this->type->cast($value);
        }

        return $result;
    }

    public function getErrors($valueArray)
    {
        if ($error = parent::getErrors($valueArray)) {
            return $error;
        }

        if (is_null($valueArray) && $this->isNullable) {
            return false;
        }

        if (!is_array($valueArray)) {
            $string = $this->getValueString($valueArray);
            return "Not a valid array: '{$string}'";
        }

        $size = count($valueArray);
        if ($size !== count(array_unique($valueArray))) {
            $string = $this->getValueString($valueArray);
            return "Values must be unique";
        }

        if (isset($this->min) && $size < $this->min) {
            return "Set size is too small, min size allowed is {$this->min}: '{$size}'";
        }

        if (isset($this->max) && $size > $this->max) {
            return "Set size is too big, max size allowed is {$this->max}: '{$size}'";
        }

        $errors     = [];
        foreach ($valueArray as $value) {
            $tmpError = $this->type->getErrors($value);

            if ($tmpError !== false) {
                $errors[] = $tmpError;
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return false;
    }

    public function isEqual($a, $b)
    {
        if (!is_array($a) || !is_array($b)) {
            throw new TypeException("Values must be arrays to be compared.");
        }

        if (count($a) != count($b)) {
            return false;
        }

        sort($a);
        sort($b);

        for ($i=0; $i < count($a); $i++) {
            if (!$this->type->isEqual($a[$i], $b[$i])) {
                return false;
            }
        }

        return true;
    }

    public function diff($new, $old)
    {
        if (is_null($new)) {
            $new = [];
        }
        if (is_null($old)) {
            $old = [];
        }

        if (!is_array($old) || !is_array($new)) {
            throw new TypeException("Values must be arrays to be compared.");
        }

        $result = [
            '+' => [],
            '-' => [],
        ];

        foreach ($old as $oldElement) {
            foreach ($new as $newElement) {
                if ($this->type->isEqual($newElement, $oldElement)) {
                    continue 2;
                }
            }
            $result['-'][] = $oldElement;
        }

        foreach ($new as $newElement) {
            foreach ($old as $oldElement) {
                if ($this->type->isEqual($newElement, $oldElement)) {
                    continue 2;
                }
            }
            $result['+'][] = $newElement;
        }

        if (!$result['+'] && !$result['-']) {
            return [];
        }

        return $result;
    }
}
