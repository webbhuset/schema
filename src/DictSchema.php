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
        S::validateArray(static::getArraySchema(), $array);

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

    public function normalize($value)
    {
        if ($value === null) {
            return [];
        }

        if (!is_array($value)) {
            return $value;
        }

        $newValue = [];

        foreach ($value as $k => $v) {
            $k = $this->keySchema->normalize($k);
            $v = $this->valueSchema->normalize($v);

            $newValue[$k] = $v;
        }

        return $newValue;
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        if (!is_array($value)) {
            return new \Webbhuset\Schema\ValidationResult(['Value must be an array.']);
        }

        $size = count($value);
        if ($this->min !== null && $size < $this->min) {
            return new \Webbhuset\Schema\ValidationResult([
                sprintf('Value must have at least %s item(s).', $this->min),
            ]);
        }

        if ($this->max !== null && $size > $this->max) {
            return new \Webbhuset\Schema\ValidationResult([
                sprintf('Value must have at most %s item(s).', $this->max),
            ]);
        }

        $errors = [];

        foreach ($value as $k => $v) {
            $keyResult = $this->keySchema->validate($k);

            if (!$keyResult->isValid()) {
                $errors[$k]['key'] = $keyResult->getErrors();
            }

            $valueResult = $this->valueSchema->validate($v);

            if (!$valueResult->isValid()) {
                $errors[$k]['value'] = $valueResult->getErrors();
            }
        }

        if ($errors) {
            return new \Webbhuset\Schema\ValidationResult($errors);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
