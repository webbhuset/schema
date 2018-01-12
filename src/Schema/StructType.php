<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseStructType extends AbstractType
{
    protected $fields       = [];
    protected $skipEmpty    = false;


    protected function parseArg($arg)
    {
        if ($arg == T::SKIP_EMPTY) {
            $this->skipEmpty = true;
        }

        if (is_array($arg)) {
            foreach ($arg as $field => $type) {
                if (!$type instanceof TypeInterface) {
                    throw new TypeException("Field '{$field}' parameter value must implement TypeInterface.");
                }
                $this->fields[$field] = $type;
            }

            return;
        }

        parent::parseArg($arg);
    }

    protected function afterConstruct()
    {
        if (empty($this->fields)) {
            throw new TypeException("Struct does not have any fields.");
        }
    }

    protected function _toArray()
    {
        $fields = [];
        foreach ($this->fields as $key => $type) {
            $fields[$key] = $type->toArray();
        }

        return [
            'type'  => 'struct',
            'args'  => [
                'nullable'  => $this->isNullable,
                'fields'    => $fields,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['struct']),
            'args' => T::Struct([
                'nullable'  => T::Bool(T::NULLABLE),
                'fields'    => T::Hashmap(T::Scalar(), T::ArraySchema(), T::MIN(1)),
            ])
        ]);
    }

    public function cast($value)
    {
        $result = [];
        foreach ($this->fields as $key => $type) {
            if ($this->skipEmpty && !array_key_exists($key, $value)) {
                continue;
            }

            $result[$key] = $type->cast($value[$key]);
        }

        return $result;
    }

    public function getErrors($value)
    {
        if ($value === null && $this->isNullable) {
            return false;
        }

        if (!is_array($value)) {
            $string = $this->getValueString($value);
            return "Not a valid array: '{$string}'";
        }

        $errors = [];
        foreach ($this->fields as $key => $type) {
            if (!array_key_exists($key, $value)) {
                if ($this->skipEmpty) {
                    continue;
                } else {
                    $value[$key] = null;
                }
            }

            $tmpError = $type->getErrors($value[$key]);

            if ($tmpError !== false) {
                if (is_array($tmpError)) {
                    $tmpError = implode(', ', $tmpError);
                }
                $errors[] = "Struct error for key '{$key}': {$tmpError}";
            }

            unset($value[$key]);
        }

        if (!empty($errors)) {
            return $errors;
        }

        return false;
    }

    protected function _isEqual($a, $b)
    {
        foreach ($this->fields as $key => $type) {
            if (!isset($a[$key]) || !isset($b[$key])) {
                // TODO: Treat as null instead
                throw new TypeException("Input is missing key: " . $key);
            }

            if (!$type->isEqual($a[$key], $b[$key])) {
                return false;
            }
        }

        return true;
    }

    public function diff($new, $old)
    {
        $result = [];
        foreach ($this->fields as $key => $type) {
            if (!isset($old[$key]) && !isset($new[$key])) {
                continue;
            }
            if (!isset($old[$key])) {
                $old[$key] = null;
            }
            if (!isset($new[$key])) {
                 $new[$key] = null;
            }

            if (!$type->isEqual($old[$key], $new[$key])) {
                $result[$key]['+'] = $new[$key];
                $result[$key]['-'] = $old[$key];
            }
        }

        return $result;
    }
}

$phpVersion = phpversion();

switch (true) {
    case version_compare($phpVersion, '7.0', '>='): return require_once 'StructType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'StructType-5.5.php';
}
