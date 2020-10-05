<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class NullableSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $schema;


    public function __construct(\Webbhuset\Schema\SchemaInterface $schema)
    {
        $this->schema = $schema;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self($array['args']['schema']);

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/nullable/'),
            'args' => S::Struct([
                'schema' => S::ArraySchema(),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'nullable',
            'args' => [
                'schema' => $this->schema->toArray(),
            ],
        ];
    }

    public function normalize($value)
    {
        if ($value === null) {
            return $value;
        } else {
            return $this->schema->normalize($value);
        }
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        if ($value === null) {
            return new \Webbhuset\Schema\ValidationResult();
        }

        $result = $this->schema->validate($value);

        if (!$result->isValid()) {
            return new \Webbhuset\Schema\ValidationResult([
                'Value must be null or match the following:' => $result->getErrors(),
            ]);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
