<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class OneOfSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $schemas;


    public function __construct(array $schemas)
    {
        if (!$schemas) {
            throw new \InvalidArgumentException('Schemas cannot be empty.');
        }

        foreach ($schemas as $schema) {
            if (!$schema instanceof \Webbhuset\Schema\SchemaInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Schema must be instance of \Webbhuset\Schema\SchemaInterface, %s given.',
                        is_object($schema) ? get_class($schema) : gettype($schema)
                    )
                );
            }
        }

        $this->schemas = $schemas;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self(
            array_map(S::fromArray, $array['args']['schemas'])
        );

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/one_of/'),
            'args' => S::Struct([
                'schemas' => S::Dict(S::Int(), S::ArraySchema()),
            ])
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'one_of',
            'args' => [
                'schemas' => array_map(function($schema) {
                    return $schema->toArray();
                }, $this->schemas),
            ],
        ];
    }

    public function normalize($value)
    {
        return $value;
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        $errors = [];

        foreach ($this->schemas as $schema) {
            $result = $schema->validate($value);

            if ($result->isValid()) {
                return new \Webbhuset\Schema\ValidationResult();
            }

            $errors[] = $result->getErrors();
        }

        return new \Webbhuset\Schema\ValidationResult([
            'Value must match one of the following:' => $errors,
        ]);
    }
}
