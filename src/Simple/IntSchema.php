<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\SchemaInterface;

class IntSchema extends AbstractSchema
{
    const DEFAULT_MIN = null;
    const DEFAULT_MAX = null;

    protected $min;
    protected $max;


    public function __construct(array $args = [])
    {
        parent::__construct($args);

        $this->min = static::DEFAULT_MIN;
        $this->max = static::DEFAULT_MAX;

        foreach ($args as $arg) {
            if (is_array($arg) && isset($arg[S::ARG_KEY_MIN]) && is_numeric($arg[S::ARG_KEY_MIN])) {
                $this->min = (int)$arg[S::ARG_KEY_MIN];
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MAX]) && is_numeric($arg[S::ARG_KEY_MAX])) {
                $this->max = (int)$arg[S::ARG_KEY_MAX];
            }
        }

        if ($this->min !== null && $this->max !== null && $this->min > $this->max) {
            throw new \InvalidArgumentException();
        }
    }

    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
            S::MIN($args['min'] ?? static::DEFAULT_MIN),
            S::MAX($args['max'] ?? static::DEFAULT_MAX),
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['int']),
            'args' => S::Struct([
                'nullable'      => S::Bool([S::NULLABLE]),
                'min'           => S::Int([S::NULLABLE]),
                'max'           => S::Int([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'int',
            'args' => [
                'nullable'  => $this->nullable,
                'min'       => $this->min,
                'max'       => $this->max,
            ],
        ];
    }

    public function cast($value)
    {
        if (is_int($value)) {
            return $value;
        } elseif ($value === null && $this->nullable) {
            return null;
        } elseif ($value === null && !$this->nullable) {
            return 0;
        } elseif (ctype_digit($value)) {
            return (int)$value;
        } elseif (is_numeric($value)) {
            $cast = (int)$value;

            return $cast == $value ? $cast : $value;
        } elseif (is_bool($value)) {
            return (int)$value;
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

        if (!is_int($value)) {
            return ['Value is not an int.'];
        }

        return [];
    }
}
