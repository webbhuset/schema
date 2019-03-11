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

    public function cast($value)
    {
        if (is_bool($value)) {
            return $value;
        } elseif ($value === null && $this->nullable) {
            return null;
        } elseif ($value === null && !$this->nullable) {
            return false;
        } elseif ($value === 0 || $value === '0') {
            return false;
        } elseif ($value === 1 || $value === '1') {
            return true;
        } else {
            return $value;
        }
    }

    public function validate($value): array
    {
        if ($errors = parent::validate($value)) {
            return $errors;
        }

        if ($value === null) {
            return [];
        }

        if (!is_bool($value)) {
            return ['Value is not a bool.'];
        }

        return [];
    }
}
