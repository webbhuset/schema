<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class EnumType extends AbstractType
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

    protected function constructFromArray(array $array)
    {
        $this->isNullable       = isset($array['nullable']) ? $array['nullable'] : $this->isNullable;
        $this->values           = $array['values'];
        $this->caseSensitive    = isset($array['caseSensitive']) ? $array['caseSensitive'] : $this->caseSensitive;
    }

    protected function afterConstruct()
    {
        if (empty($this->values)) {
            throw new TypeException("No values in enumerated type.");
        }
    }

    public function toArray()
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

    public static function getArraySchema()
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
        if ($error = parent::getErrors($value)){
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

            return "Value '{$string}' is not among the enumerated values";
        }

        return false;
    }

    public function isEqual($a, $b)
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

    public function isScalar()
    {
        return true;
    }
}
