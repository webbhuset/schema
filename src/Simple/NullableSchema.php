<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;

class NullableSchema extends \Webbhuset\Schema\AbstractSchema
{
    protected $schema;


    public function __construct(\Webbhuset\Schema\SchemaInterface $schema)
    {
        $this->schema = $schema;
    }

    public static function fromArray(array $array): \Webbhuset\Schema\SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE),
            isset($args['min']) ? S::MIN($args['min']) : null,
            isset($args['max']) ? S::MAX($args['max']) : null,
        ]);
    }

    public static function getArraySchema(): \Webbhuset\Schema\Composite\StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['int']),
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
            return $this->schema->validate($value, $strict);
        }
    }
}
