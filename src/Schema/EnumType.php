<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor as T;

abstract class BaseEnumType extends AbstractType
{
    protected $values           = [];
    protected $caseSensitive    = true;


    protected function parseArg($arg)
    {
        if (is_array($arg)) {
            $this->values = $arg;

            return;
        }

        if ($arg == T::CASE_INSENSITIVE) {
            $this->caseSensitive = false;
        }

        parent::parseArg($arg);
    }

    protected function afterConstruct()
    {
        if (empty($this->values)) {
            throw new TypeException("No values in enumerated type.");
        }
    }

    protected function _toArray()
    {
        return [
            'type'  => 'enum',
            'args'  => [
                'nullable'      => $this->isNullable,
                'values'        => $this->values,
                'caseSensitive' => $this->caseSensitive,
            ],
        ];
    }

    protected static function _getArraySchema()
    {
        return T::Struct([
            'type' => T::Enum(['enum']),
            'args' => T::Struct([
                'nullable'      => T::Bool(T::NULLABLE),
                'values'        => T::Set(T::Any()),
                'caseSensitive' => T::Bool(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)) {
            return $error;
        }

        if (is_null($value) && $this->isNullable) {
            return false;
        }

        $inArray = in_array($value, $this->values, true);
        $inArrayCaseInsensitive = $this->caseSensitive === false
            && in_array(mb_strtoupper($value), $this->values, true);

        if (!$inArray && !$inArrayCaseInsensitive) {
            $string = $this->getValueString($value);

            return "Value '{$string}' is not among the enumerated values.";
        }

        return false;
    }

    protected function _isEqual($a, $b)
    {
        if ($this->caseSensitive === false) {
            return mb_strtoupper($a) === mb_strtoupper($b);
        } else {
            return $a === $b;
        }
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
    case version_compare($phpVersion, '7.0', '>='): return require_once 'EnumType-7.0.php';
    case version_compare($phpVersion, '5.5', '>='): return require_once 'EnumType-5.5.php';
}
