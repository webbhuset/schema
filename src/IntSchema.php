<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class IntSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $min;
    protected $max;


    public function min(int $min): self
    {
        if ($this->max !== null && $min > $this->max) {
            throw new \InvalidArgumentException('Min cannot be lower than max.');
        }

        $clone = clone $this;
        $clone->min = $min;

        return $clone;
    }

    public function max(int $max): self
    {
        if ($this->min !== null && $max < $this->min) {
            throw new \InvalidArgumentException('Max cannot be lower than min.');
        }

        $clone = clone $this;
        $clone->max = $max;

        return $clone;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self();

        if ($array['args']['min']) {
            $schema->min = $array['args']['min'];
        }

        if ($array['args']['max']) {
            $schema->max = $array['args']['max'];
        }

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/int/'),
            'args' => S::Struct([
                'min' => S::Nullable(S::Int()),
                'max' => S::Nullable(S::Int()),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'int',
            'args' => [
                'min' => $this->min,
                'max' => $this->max,
            ],
        ];
    }

    public function normalize($value)
    {
        if (is_int($value)) {
            return $value;
        } elseif ($value === null) {
            return 0;
        } elseif (is_bool($value)) {
            return $value ? 1 : 0;
        } elseif (is_numeric($value)) {
            $cast = (int)$value;

            if ($cast == $value) {
                return $cast;
            } else {
                return $value;
            }
        } else {
            return $value;
        }
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        if (!is_int($value)) {
            return new \Webbhuset\Schema\ValidationResult(['Value must be an int.']);
        }

        if ($this->min !== null && $strlen < $this->min) {
            return new \Webbhuset\Schema\ValidationResult([
                sprintf('Value must be at least %s.', $this->min),
            ]);
        }

        if ($this->max !== null && $strlen > $this->max) {
            return new \Webbhuset\Schema\ValidationResult([
                sprintf('Value must be at most %s.', $this->max),
            ]);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
