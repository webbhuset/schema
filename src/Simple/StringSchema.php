<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;

class StringSchema extends AbstractSchema
{
    const DEFAULT_MIN               = null;
    const DEFAULT_MAX               = null;
    const DEFAULT_MATCHES           = [];
    const DEFAULT_CASE_SENSITIVE    = true;

    protected $min;
    protected $max;
    protected $matches;
    protected $caseSensitive;


    public function __construct(array $args = [])
    {
        parent::__construct($args);

        $this->min              = static::DEFAULT_MIN;
        $this->max              = static::DEFAULT_MAX;
        $this->matches          = static::DEFAULT_MATCHES;
        $this->caseSensitive    = static::DEFAULT_CASE_SENSITIVE;

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg[S::ARG_KEY_MIN]) && is_numeric($arg[S::ARG_KEY_MIN])) {
                $this->min = (int)$arg[ARG_KEY_MIN];
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MAX]) && is_numeric($arg[S::ARG_KEY_MAX])) {
                $this->max = (int)$arg[ARG_KEY_MAX];
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MATCH]) && is_array($arg[S::ARG_KEY_MATCH])) {
                $this->matches = $arg[S::ARG_KEY_MATCH];
            } elseif ($arg === S::CASE_SENSITIVE) {
                $this->caseSensitive = true;
            } elseif ($arg === S::CASE_INSENSITIVE) {
                $this->caseSensitive = false;
            }
        }
    }

    public static function fromArray(array $array): self
    {
        $this->validateArraySchema($array);

        $args = $array['args'];

        return new self([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
            S::MIN($args['min'] ?? static::DEFAULT_MIN),
            S::MAX($args['max'] ?? static::DEFAULT_MAX),
            S::MATCH($args['matches'] ?? static::DEFAULT_MATCHES),
            S::CASE_SENSITIVE($args['case_sensitive'] ?? static::DEFAULT_CASE_SENSITIVE),
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['string']),
            'args' => S::Struct([
                'nullable'          => S::Bool([S::NULLABLE]),
                'min'               => S::Int([S::NULLABLE, S::MIN(0)]),
                'max'               => S::Int([S::NULLABLE, S::MIN(0)]),
                'matches'           => S::Hashmap(S::String(), S::String(), [S::NULLABLE]),
                'case_sensitive'    => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'string',
            'args' => [
                'nullable'          => $this->nullable,
                'min'               => $this->min,
                'max'               => $this->max,
                'matches'           => $this->matches,
                'case_sensitive'    => $this->caseSensitive,
            ],
        ];
    }

    public function cast($value)
    {
        if (is_string($value)) {
            return $value;
        } elseif ($value === null && $this->nullable) {
            return null;
        } elseif ($value === null && !$this->nullable) {
            return '';
        } elseif (is_scalar($value)) {
            return (string)$value;
        } else {
            return $value;
        }
    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }

        if ($value === null) {
            return [];
        }

        if (!is_string($value)) {
            return ['Value is not a string.'];
        }

        $strlen = mb_strlen($value);
        if ($this->min !== null && $strlen < $this->min) {
            return [
                sprintf('String is too short, min length allowed is %s.', $this->min),
            ];
        }

        if ($this->max !== null && $strlen > $this->max) {
            return [
                sprintf('String is too short, max length allowed is %s.', $this->max),
            ];
        }

        foreach ($this->matches as $regex => $message) {
            if (!preg_match($regex, $value)) {
                return [
                    $message,
                ];
            }
        }

        return [];
    }
}
