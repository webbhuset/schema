<?php

namespace Webbhuset\Schema\Simple;

use Webbhuset\Schema\Constructor as S;
use Webbhuset\Schema\AbstractSchema;
use Webbhuset\Schema\Composite\StructSchema;
use Webbhuset\Schema\SchemaInterface;

class BoolSchema extends AbstractSchema
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
            'type' => S::Enum(['bool']),
            'args' => S::Struct([
                'nullable' => S::Bool([S::NULLABLE]),
            ]),
        ]);
    }

    public function toArray(): array
    {
        return [
            'type' => 'bool',
            'args' => [
                'nullable' => $this->nullable,
            ],
        ];
    }

    public function validate($value, bool $strict = true): bool
    {
        if (!is_bool($value)) {
            if ($strict) {
                throw new \Webbhuset\Schema\ValidationException(['Value must be a bool.']);
            } else {
                $value = (bool)$value;
            }
        }

        return $value;
    }
}
