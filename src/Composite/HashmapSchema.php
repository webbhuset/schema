<?php

namespace Webbhuset\Schema\Composite;

use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\SchemaInterface;

class HashmapSchema extends AbstractSchema
{
    protected $keySchema;
    protected $valueSchema;
    protected $min;
    protected $max;


    public function __construct(SchemaInterface $keySchema, SchemaInterface $valueSchema, array $args = [])
    {
        parent::__construct($args);

        $this->keySchema = $keySchema;
        $this->valueSchema = $valueSchema;
    }

    public static function fromArray(array $array)
    {
        $this->validateArraySchema($array);

        $args = $array['args'];

    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['hashmap']),
            'args' => S::Struct([
                'nullable'  => S::Bool([S::NULLABLE]),
                'min'       => S::Int([S::NULLABLE]),
                'max'       => S::Int([S::NULLABLE]),
                'key'       => S::ArraySchema(),
                'value'     => S::ArraySchema(),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type'  => 'hashmap',
            'args'  => [
                'nullable'  => $this->nullable,
                'key'       => $this->keyType->toArray(),
                'value'     => $this->valueType->toArray(),
                'min'       => $this->min,
                'max'       => $this->max,
            ],
        ];
    }

    public function cast($value)
    {

    }

    public function isEqual($a, $b): bool
    {

    }

    public function diff($a, $b): array
    {

    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }

        if ($value === null) {
            return [];
        }

        if (!is_array($value)) {
            return ['Value is not an array.'];
        }

        $size = count($value);
        if ($this->min !== null && $size < $this->min) {
            return [
                sprintf('Value has too few elements, min amount allowed is %s.', $this->min),
            ];
        }

        if ($this->max !== null && $size > $this->max) {
            return [
                sprintf('Value has too many elements, max amount allowed is %s.', $this->min),
            ];
        }

        $errors = [];

        foreach ($value as $k => $v) {
            if ($keyErrors = $this->keySchema->validate($k)) {
                $errors[$k]['key'] = $keyErrors;
            }

            if ($valueErrors = $this->valueSchema->validate($k)) {
                $errors[$k]['value'] = $valueErrors;
            }
        }

        return $errors;
    }
}
