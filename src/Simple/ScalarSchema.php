<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\SchemaInterface;

class ScalarSchema extends AbstractSchema
{
    public static function fromArray(array $array): SchemaInterface
    {
        static::validateArraySchema($array);

        $args = $array['args'];

        return new self([
            S::NULLABLE($args['nullable'] ?? static::DEFAULT_NULLABLE)
        ]);
    }

    public static function getArraySchema(): StructSchema
    {
        return S::Struct([
            'type' => S::Enum(['scalar']),
            'args' => S::Struct([
                'nullable' => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'scalar',
            'args' => [
                'nullable' => $this->nullable,
            ],
        ];
    }

    public function validate($value, bool $strict = true): array
    {
        if (!is_scalar($value)) {
            if ($strict) {
                throw new \Webbhuset\Schema\ValidationException(['Value must be a scalar.']);
            } elseif ($value === null) {
                $value = '';
            }
        }

        return $value;
    }
}
