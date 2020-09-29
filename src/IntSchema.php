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
        static::getArraySchema()->validate($array);

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
