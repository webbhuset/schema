<?php

namespace Webbhuset\Schema;

use Webbhuset\Schema\Constructor as S;

class StructSchema implements \Webbhuset\Schema\SchemaInterface
{
    const ERROR_ON_MISSING = 'ERROR_ON_MISSING';
    const MISSING_AS_NULL = 'MISSING_AS_NULL';
    const SKIP_MISSING = 'SKIP_MISSING';

    protected $fields;
    protected $allowUndefined;
    protected $missing;


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
        $this->allowUndefined = false;
        $this->missing = static::ERROR_ON_MISSING;
    }

    public function errorOnMissing(): self
    {
        $clone = clone $this;
        $clone->missing = static::ERROR_ON_MISSING;

        return $clone;
    }

    public function missingAsNull(): self
    {
        $clone = clone $this;
        $clone->missing = static::MISSING_AS_NULL;

        return $clone;
    }

    public function skipMissing(): self
    {
        $clone = clone $this;
        $clone->missing = static::SKIP_MISSING;

        return $clone;
    }

    public function allowUndefined(bool $allow): self
    {
        $clone = clone $this;
        $clone->allowUndefined = $allow;

        return $clone;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        S::validateArray(static::getArraySchema(), $array);

        $schema = new self($array['args']['fields']);

        if ($array['args']['missing']) {
            $this->missing = $array['args']['missing'];
        }

        if ($array['args']['allow_undefined']) {
            $this->missing = $array['args']['allow_undefined'];
        }

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
                'missing' => S::OneOf([
                    S::String()->regex('/' . static::ERROR_ON_MISSING . '/'),
                    S::String()->regex('/' . static::SKIP_MISSING . '/'),
                    S::String()->regex('/' . static::MISSING_AS_NULL . '/'),
                ]),
                'allow_undefined' => S::Bool(),
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
                'missing' => $this->missing,
                'allow_undefined' => $this->allowUndefined,
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
                switch ($this->missing) {
                    case static::ERROR_ON_MISSING:
                        $errors[$key] = ['Value must be set.'];

                        continue 2;

                    case static::SKIP_MISSING:
                        continue 2;

                    case static::MISSING_AS_NULL:
                        $value[$key] = null;

                        break;
                }
            }

            $result = $schema->validate($value[$key]);

            if (!$result->isValid()) {
                $errors[$key] = $result->getErrors();
            }
        }

        if (!$this->allowUndefined) {
            foreach (array_diff_key($value, $this->fields) as $key => $v) {
                $errors[$key] = ['Value must not be set (undefined key).'];
            }
        }

        if ($errors) {
            return new \Webbhuset\Schema\ValidationResult($errors);
        }

        return new \Webbhuset\Schema\ValidationResult();
    }
}
