<?php

namespace Webbhuset\Data\Schema;

use Webbhuset\Data\Schema\TypeConstructor AS T;

class StringType extends AbstractType
{
    protected $maxLen           = -1;
    protected $minLen           = -1;
    protected $matches          = [];
    protected $notMatches       = [];
    protected $caseSensitive    = true;

    protected function parseArg($arg)
    {
        if (is_array($arg) && isset($arg[T::ARG_KEY_MIN])) {
            $this->minLen   = is_numeric($arg[T::ARG_KEY_MIN])
                            ? (int)$arg[T::ARG_KEY_MIN]
                            : null;
            return;
        }

        if (is_array($arg) && isset($arg[T::ARG_KEY_MAX])) {
            $this->maxLen   = is_numeric($arg[T::ARG_KEY_MAX])
                            ? (int)$arg[T::ARG_KEY_MAX]
                            : null;
            return;
        }

        if (isset($arg[T::ARG_KEY_MATCH])) {
            $this->matches = is_array($arg[T::ARG_KEY_MATCH])
                            ? $arg[T::ARG_KEY_MATCH]
                            : [];
            return;
        }

        if (isset($arg[T::ARG_KEY_NOTMATCH])) {
            $this->notMatches = is_array($arg[T::ARG_KEY_NOTMATCH])
                            ? $arg[T::ARG_KEY_NOTMATCH]
                            : [];
            return;
        }

        if ($arg == T::CASE_SENSITIVE) {
            $this->caseSensitive = true;
        }

        if ($arg == T::CASE_INSENSITIVE) {
            $this->caseSensitive = false;
        }

        parent::parseArg($arg);
    }

    protected function constructFromArray(array $array)
    {
        $this->isNullable       = $array['nullable'] ?? $this->isNullable;
        $this->min              = $array['min'] ?? $this->min;
        $this->max              = $array['max'] ?? $this->max;
        $this->matches          = $array['matches'] ?? $this->matches;
        $this->notMatches       = $array['notMatches'] ?? $this->notMatches;
        $this->caseSensitive    = $array['caseSensitive'] ?? $this->caseSensitive;
    }

    public function toArray() : array
    {
        return [
            'type'  => 'string',
            'args'  => [
                'nullable'      => $this->isNullable,
                'min'           => $this->minLen,
                'max'           => $this->maxLen,
                'matches'       => $this->matches,
                'notMatches'    => $this->notMatches,
                'caseSensitive' => $this->caseSensitive,
            ],
        ];
    }

    public static function getArraySchema() : TypeInterface
    {
        return T::Struct([
            'type' => T::Enum(['string']),
            'args' => T::Struct([
                'nullable'      => T::Bool(T::NULLABLE),
                'min'           => T::Int(T::NULLABLE),
                'max'           => T::Int(T::NULLABLE),
                'matches'       => T::Hashmap(T::String(), T::String(), T::NULLABLE),
                'notMatches'    => T::Hashmap(T::String(), T::String(), T::NULLABLE),
                'caseSensitive' => T::Bool(T::NULLABLE),
            ])
        ]);
    }

    public function getErrors($value)
    {
        if ($error = parent::getErrors($value)) {
            return $error;
        }

        if (!is_string($value)) {
            $string = $this->getValueString($value);
            return "Not a valid string: '{$string}'";
        }

        if ($this->minLen >= 0 && mb_strlen($value) < $this->minLen) {
            return "String is too short, min length allowed is {$this->minLen}: '{$value}'";
        }

        if ($this->maxLen >= 0 && mb_strlen($value) > $this->maxLen) {
            return "String is too long, max length allowed is {$this->maxLen}: '{$value}'";
        }

        foreach ($this->matches as $regex => $message) {
            if (!preg_match($regex, $value)) {
                return sprintf($message, $value);
            }
        }

        foreach ($this->notMatches as $regex => $message) {
            if (preg_match($regex, $value)) {
                return sprintf($message, $value);
            }
        }

        return false;
    }

    public function cast($value)
    {
        if (is_null($value) && $this->isNullable) {
            return $value;
        }

        return (string) $value;
    }

    public function isEqual($a, $b) : bool
    {
        if (!(is_string($a) || is_null($a))) {
            throw new TypeException("Not a string");
        }
        if (!(is_string($b) || is_null($b))) {
            throw new TypeException("Not a string");
        }

        if ($this->caseSensitive) {
            return $a===$b;
        } else {
            return mb_strtoupper($a) === mb_strtoupper($b);
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

    public function isScalar() : bool
    {
        return true;
    }
}
