<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseHashmapType extends AbstractType
{
    protected $valueType;
    protected $keyType;
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

        if ($arg instanceof TypeInterface && empty($this->keyType)) {
            $this->keyType = $arg;
            return;
        }

        if ($arg instanceof TypeInterface && empty($this->valueType)) {
            $this->valueType = $arg;
            return;
        }

        parent::parseArg($arg);
    }

    protected function afterConstruct()
    {
        if (!$this->keyType instanceof TypeInterface) {
            throw new TypeException("Key type param must implement TypeInterface.");
        }

        if (!$this->keyType->isScalar()) {
            throw new TypeException("Key type param must be a scalar type.");
        }

        if (!$this->valueType instanceof TypeInterface) {
            throw new TypeException("Value type param must implement TypeInterface.");
        }
    }

    protected function _toArray()
    {
        return [
            'type'  => 'hashmap',
            'args'  => [
                'nullable'  => $this->isNullable,
                'key'       => $this->keyType->toArray(),
                'value'     => $this->valueType->toArray(),
                'min'       => $this->min,
                'max'       => $this->max,
            ]
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['hashmap']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'min'       => T::Int(T::NULLABLE),
                'max'       => T::Int(T::NULLABLE),
                'key'       => T::ArraySchema(),
                'value'     => T::ArraySchema(),
            ])
        ]);
    }

    public function cast($dataArray)
    {
        if ($dataArray === null) {
            return [];
        }

        if (!is_array($dataArray)) {
            throw new TypeException("Can only cast arrays.");
        }

        $result = [];
        foreach ($dataArray as $dataKey => $dataValue) {
            $castedKey          = $this->keyType->cast($dataKey);
            $result[$castedKey] = $this->valueType->cast($dataValue);
        }

        return $result;
    }

    public function getErrors($dataArray)
    {
        if ($error = parent::getErrors($dataArray)) {
            return $error;
        }

        if (is_null($dataArray)) {
            return false;
        }

        if (!is_array($dataArray)) {
            $string = $this->getValueString($dataArray);
            return "Not a valid array: '{$string}'.";
        }

        $size = count($dataArray);
        if (isset($this->min) && $size < $this->min) {
            return "Too few items; min amount allowed is {$this->min}: '{$size}'.";
        }

        if (isset($this->max) && $size > $this->max) {
            return "Too many items, max amount allowed is {$this->max}: '{$size}'.";
        }

        $errors = [];
        foreach ($dataArray as $dataKey => $dataValue) {
            $tmpError = $this->keyType->getErrors($dataKey);
            if ($tmpError !== false) {
                if (is_array($tmpError)) {
                    $tmpError = implode(', ', $tmpError);
                }
                $errors[] = "Hashmap key error: {$tmpError}";
            }

            $tmpError = $this->valueType->getErrors($dataValue);
            if ($tmpError !== false) {
                if (is_array($tmpError)) {
                    $tmpError = implode(', ', $tmpError);
                }
                $errors[] = "Hashmap value error for key '{$dataKey}': {$tmpError}";
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return false;
    }

    protected function _isEqual($a, $b)
    {
        $diff = array_diff_key($a, $b);
        if (!empty($diff)) {
            return false;
        }
        $diff = array_diff_key($b, $a);
        if (!empty($diff)) {
            return false;
        }

        foreach ($a as $key => $aValue) {
            if (!$this->valueType->isEqual($aValue, $b[$key])) {
                return false;
            }
        }

        return true;
    }

    public function diff($new, $old)
    {
        $result = [
            '+' => [],
            '-' => [],
        ];

        $keyDiff = array_diff_key($new, $old);
        if (!empty($keyDiff)) {
            $result['+'] = $keyDiff;
        }

        $keyDiff = array_diff_key($old, $new);
        if (!empty($keyDiff)) {
            $result['-'] = $keyDiff;
        }

        $keyIntersect = array_intersect_key($new, $old);
        foreach ($keyIntersect as $key => $newValue) {
            $diff = $this->valueType->diff($new[$key], $old[$key]);
            if (array_key_exists('+', $diff)) {
                $result['+'][$key] = $diff['+'];
            }
            if (array_key_exists('-', $diff)) {
                $result['-'][$key] = $diff['-'];
            }
        }

        if (!$result['+'] && !$result['-']) {
            return [];
        }

        return $result;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'HashmapType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'HashmapType-5.5.php';
}
