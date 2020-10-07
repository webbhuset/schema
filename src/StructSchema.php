<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class StructSchema implements \Webbhuset\Schema\SchemaInterface
{
    protected $fields;


    public function __construct(array $fields)
    {
        foreach ($fields as $key => $schema) {
            if (!$schema instanceof SchemaInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Schema must be instance of \Webbhuset\Schema\SchemaInterface, %s given.',
                        is_object($schema) ? get_class($schema) : gettype($schema)
                    )
                );
            }
        }

        $this->fields = $fields;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self($array['args']['fields']);

        return $schema;
    }

    public static function getArraySchema(): \Webbhuset\Schema\StructSchema
    {
        return S::Struct([
            'type' => S::String()->regex('/struct/'),
            'args' => S::Struct([
                'fields' => S::Dict(
                    S::OneOf([
                        S::Bool(),
                        S::Float(),
                        S::Int(),
                        S::String(),
                    ]),
                    S::ArraySchema()
                ),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'struct',
            'args' => [
                'fields' => array_map(function($schema) {
                    return $schema->toArray();
                }, $this->fields),
            ],
        ];
    }

    public function normalize($value)
    {
        if ($value === null) {
            $value = [];
        } elseif (!is_array($value)) {
            return $value;
        }

        foreach ($this->fields as $key => $schema) {
            $value[$key] = $schema->normalize($value[$key] ?? null);
        }

        foreach (array_diff_key($value, $this->fields) as $key => $v) {
            unset($value[$key]);
        }

        return $value;
    }

    public function validate($value): \Webbhuset\Schema\ValidationResult
    {
        if (!is_array($value)) {
            return new \Webbhuset\Schema\ValidationResult(['Value must be an array.']);
        }

        $errors = [];
        foreach ($this->fields as $key => $schema) {
            if (!array_key_exists($key, $value)) {
                $errors[$key] = ['Value must be set.'];

                continue;
            }

            $result = $schema->validate($value[$key]);

            if (!$result->isValid()) {
                $errors[$key] = $result->getErrors();
            }
        }

        foreach (array_diff_key($value, $this->fields) as $key => $v) {
            $errors[$key] = ['Undefined key must not be set.'];
        }

        if ($errors) {
            return new \Webbhuset\Schema\ValidationResult($errors);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
