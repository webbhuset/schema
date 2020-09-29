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
            isset($args['min']) ? S::MIN($args['min']) : null,
            isset($args['max']) ? S::MAX($args['max']) : null,
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['int']),
            'args' => S::Struct([
                'nullable' => S::Bool([S::NULLABLE]),
                'min' => S::Int([S::NULLABLE]),
                'max' => S::Int([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'int',
            'args' => [
                'nullable' => $this->nullable,
                'min' => $this->min,
                'max' => $this->max,
            ],
        ];
    }

    public function validate($value, bool $strict = true): int
    {
        if (!is_int($value)) {
            if ($strict) {
                throw new \Webbhuset\Schema\ValidationException(['Value must be an int.']);
            } elseif ($value === null) {
                $value = 0;
            } elseif (is_bool($value)) {
                $value = $value ? 1 : 0;
            } elseif (is_numeric($value)) {
                $cast = (int)$value;

                if ($cast == $value) {
                    $value = $cast;
                } else {
                    throw new \Webbhuset\Schema\ValidationException(['Value must be coercible to an int.']);
                }
            } else {
                throw new \Webbhuset\Schema\ValidationException(['Value must be coercible to an int.']);
            }
        }

        if ($this->min !== null && $strlen < $this->min) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must be at least %s.', $this->min),
            ]);
        }

        if ($this->max !== null && $strlen > $this->max) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must be at most %s.', $this->max),
            ]);
        }

        return $value;
    }
}
