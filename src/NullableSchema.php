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
        static::getArraySchema()->validate($array);

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

    public function validate($value, bool $strict = true)
    {
        if ($value === null) {
            return $value;
        } else {
            try {
                return $this->schema->validate($value, $strict);
            } catch (\Webbhuset\Schema\ValidationException $e) {
                throw new \Webbhuset\Schema\ValidationException([
                    'Value must be null or match the following:' => $e->getValidationErrors(),
                ]);
            }
        }
    }
}
