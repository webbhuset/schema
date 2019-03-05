<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;

class FloatSchema extends AbstractSchema
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
                $this->min = (int)$arg[ARG_KEY_MIN];
            } elseif (is_array($arg) && isset($arg[S::ARG_KEY_MAX]) && is_numeric($arg[S::ARG_KEY_MAX])) {
                $this->max = (int)$arg[ARG_KEY_MAX];
            }
        }

        if ($this->min !== null && $this->max !== null && $this->min > $this->max) {
            throw new \Exception();
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
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['float']),
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
            'type' => 'float',
            'args' => [
                'nullable'  => $this->nullable,
                'min'       => $this->min,
                'max'       => $this->max,
            ],
        ];
    }

    public function cast($value)
    {
        if (is_float($value)) {
            return $value;
        } elseif ($value === null && $this->nullable) {
            return null;
        } elseif ($value === null && !$this->nullable) {
            return 0.0;
        } elseif (is_numeric($value)) {
            return (float)$value;
        } else {
            return $value;
        }
    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }
    }
}
