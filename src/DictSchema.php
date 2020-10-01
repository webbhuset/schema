<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class DictSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $keySchema;
    protected $valueSchema;
    protected $min;
    protected $max;


    public function __construct(
        \Webbhuset\Schema\SchemaInterface $keySchema,
        \Webbhuset\Schema\SchemaInterface $valueSchema
    ) {
        $this->keySchema = $keySchema;
        $this->valueSchema = $valueSchema;
    }

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

        $schema = new self(
            S::fromArray($array['args']['key']),
            S::fromArray($array['args']['value'])
        );

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
            'type' => S::String()->regex('/dict/'),
            'args' => S::Struct([
                'key' => S::ArraySchema(),
                'value' => S::ArraySchema(),
                'min' => S::Nullable(S::Int()->min(0)),
                'max' => S::Nullable(S::Int()->min(0)),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'dict',
            'args' => [
                'key' => $this->keySchema->toArray(),
                'value' => $this->valueSchema->toArray(),
                'min' => $this->min,
                'max' => $this->max,
            ],
        ];
    }

    public function validate($value, bool $strict = true): array
    {
        if (!is_array($value)) {
            throw new \Webbhuset\Schema\ValidationException(['Value must be an array.']);
        }

        $size = count($value);
        if ($this->min !== null && $size < $this->min) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must have at least %s item(s).', $this->min),
            ]);
        }

        if ($this->max !== null && $size > $this->max) {
            throw new \Webbhuset\Schema\ValidationException([
                sprintf('Value must have at most %s item(s).', $this->max),
            ]);
        }

        $errors = [];
        $newValue = [];
        foreach ($value as $k => $v) {
            try {
                $k = $this->keySchema->validate($k, $strict);
            } catch (\Webbhuset\Schema\ValidationException $e) {
                $errors[$k]['key'] = $e->getValidationErrors();
            }

            try {
                $v = $this->valueSchema->validate($v, $strict);
            } catch (\Webbhuset\Schema\ValidationException $e) {
                $errors[$k]['value'] = $e->getValidationErrors();
            }

            $newValue[$k] = $v;
        }

        if ($errors) {
            throw new \Webbhuset\Schema\ValidationException($errors);
        }

        return $newValue;
    }
}
